<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use App\Services\FonteService;
use App\Models\WhatsappMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __construct(
        private FonteService $fonteService,
    ) {}

    /**
     * Try to resolve FirebaseService lazily. Returns null if credentials missing.
     */
    private function resolveFirebaseService(): ?FirebaseService
    {
        try {
            $service = app(FirebaseService::class);
            \Log::info("FirebaseService resolved successfully");
            return $service;
        } catch (\Throwable $e) {
            \Log::error("FirebaseService resolution failed", [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null;
        }
    }

    /**
     * Ambil data tagihan dari Firebase
     */
    public function getTagihan(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id ?? $request->input('user_id');

            if (! $userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID tidak ditemukan',
                ], 400);
            }

            $firebase = $this->resolveFirebaseService();
            if (! $firebase) {
                return response()->json([
                    'success' => false,
                    'message' => 'Firebase tidak terkonfigurasi',
                ], 500);
            }

            $tagihan = $firebase->getTagihanData((string) $userId);

            return response()->json([
                'success' => true,
                'data' => $tagihan,
                'timestamp' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in getTagihan: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Kirim tagihan ke WhatsApp
     */
    public function sendTagihanViaWhatsApp(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'phone_number' => 'required|string',
            ]);

            $userId = $request->input('user_id');
            $phoneNumber = $request->input('phone_number');

            // Validasi nomor WhatsApp
            $phoneNumber = $this->fonteService->formatPhoneNumber($phoneNumber);

            if (! $this->fonteService->isValidPhoneNumber($phoneNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor WhatsApp tidak valid',
                ], 400);
            }

            // Ambil data tagihan dari Firebase
            $firebase = $this->resolveFirebaseService();

            if (! $firebase) {
                return response()->json([
                    'success' => false,
                    'message' => 'Firebase tidak terkonfigurasi',
                ], 500);
            }

            $tagihan = $firebase->getTagihanData($userId);

            if (! $tagihan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tagihan tidak ditemukan',
                ], 404);
            }

            // Jika pengguna terdaftar dan kamar = 4, kirim pesan khusus singkat sesuai permintaan
            $overrideMessageForRoom4 = 'NCN9vSoKGCabfQovLRwe';
            $userModel = \App\Models\User::find($userId);

            // Support per-room API token override for single sends as well
            $originalToken = config('services.fonnte.api_token');
            try {
                if ($userModel && ($userModel->room ?? null) == 4) {
                    // apply room-4 token then send override message
                    try {
                        $this->fonteService->setApiToken($overrideMessageForRoom4);
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to set Fonnte API token for room 4: {$e->getMessage()}");
                    }

                    $result = $this->fonteService->sendMessage($phoneNumber, $overrideMessageForRoom4);
                } else {
                    // Kirim ke WhatsApp menggunakan Fonnte (default)
                    $result = $this->fonteService->sendBillingMessage($phoneNumber, $tagihan);
                }
            } finally {
                // restore original token
                try {
                    $this->fonteService->setApiToken($originalToken);
                } catch (\Throwable $e) {
                    \Log::warning("Failed to restore original Fonnte API token: {$e->getMessage()}");
                }
            }

            if ($result['success']) {
                // Log pengiriman WhatsApp
                \Log::info("WhatsApp billing sent successfully", [
                    'user_id' => $userId,
                    'phone_number' => $phoneNumber,
                    'fonnte_response' => $result['data'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Tagihan berhasil dikirim via WhatsApp',
                    'data' => $result['data'] ?? null,
                ]);
            } else {
                \Log::error("Failed to send WhatsApp billing", [
                    'user_id' => $userId,
                    'error' => $result['error'],
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim tagihan via WhatsApp',
                    'error' => $result['error'],
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error("Error in sendTagihanViaWhatsApp: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil data monitoring (arus, daya)
     */
    public function getMonitoring(Request $request): JsonResponse
    {
        try {
            // Support fetching by user_id (normal) or room_id (admin fallback)
            $userId = $request->input('user_id');
            $roomIdParam = $request->input('room_id');

            \Log::info("getMonitoring called", ['user_id' => $userId, 'room_id' => $roomIdParam]);

            $firebase = $this->resolveFirebaseService();
            if (! $firebase) {
                \Log::error("Firebase service not available");
                return response()->json(['success' => false, 'message' => 'Firebase tidak terkonfigurasi'], 500);
            }

            if ($roomIdParam) {
                \Log::info("Fetching room data", ['room_id' => $roomIdParam]);
                $data = $firebase->getAllRoomData((int) $roomIdParam);
            } else {
                $userId = $userId ?? $request->user()->id;
                if (! $userId) {
                    return response()->json(['success' => false, 'message' => 'User ID tidak ditemukan'], 400);
                }

                \Log::info("Fetching user data", ['user_id' => $userId]);
                $user = User::find($userId);
                $roomId = $user?->room;
                $data = $firebase->getAllUserData((string) $userId, $roomId);
            }

            \Log::info("Firebase data received", ['data' => $data]);

            // Normalize values: ensure numeric formatting and keys we expect in views
            $arus = $data['arus'] ?? null;
            $daya = $data['daya'] ?? null;
            $tagihan = $data['tagihan'] ?? null;

            $normalized = [
                'arus' => $arus ? [
                    'current' => isset($arus['arus']) ? round((float)$arus['arus'], 4) : ($arus['current'] ?? null),
                    'voltage' => $arus['voltage'] ?? null,
                ] : null,
                'daya' => $daya ? [
                    'power' => $daya['daya'] ?? ($daya['power'] ?? null),
                    'kwh_total' => $daya['kwh_total'] ?? null,
                ] : null,
                'tagihan' => $tagihan ? [
                    'total_tagihan' => $tagihan['total_tagihan'] ?? $tagihan['harga_total'] ?? null,
                ] : null,
            ];

            $normalized['status'] = ($normalized['arus'] || $normalized['daya'] || $normalized['tagihan']) ? 'Online' : 'Offline';

            return response()->json(['success' => true, 'data' => $normalized]);
        } catch (\Exception $e) {
            \Log::error("Error in getMonitoring: {$e->getMessage()}", ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Kirim data monitoring via WhatsApp
     */
    public function sendMonitoringViaWhatsApp(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'phone_number' => 'required|string',
            ]);

            $userId = $request->input('user_id');
            $phoneNumber = $request->input('phone_number');

            // Format dan validasi nomor
            $phoneNumber = $this->fonteService->formatPhoneNumber($phoneNumber);

            if (! $this->fonteService->isValidPhoneNumber($phoneNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor WhatsApp tidak valid',
                ], 400);
            }

            // Ambil data monitoring
            $firebase = $this->resolveFirebaseService();

            if (! $firebase) {
                return response()->json([
                    'success' => false,
                    'message' => 'Firebase tidak terkonfigurasi',
                ], 500);
            }

            $data = $firebase->getAllUserData($userId);

            if (! ($data['arus'] ?? null) && ! ($data['daya'] ?? null)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data monitoring tidak ditemukan',
                ], 404);
            }

            // Jika user terkait (via user_id) ada dan kamar = 4, kirim pesan khusus singkat
            $overrideMessageForRoom4 = 'NCN9vSoKGCabfQovLRwe';
            $userModel = \App\Models\User::find($userId);

            $originalToken = config('services.fonnte.api_token');
            try {
                if ($userModel && ($userModel->room ?? null) == 4) {
                    try {
                        $this->fonteService->setApiToken($overrideMessageForRoom4);
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to set Fonnte API token for room 4: {$e->getMessage()}");
                    }

                    $result = $this->fonteService->sendMessage($phoneNumber, $overrideMessageForRoom4);
                } else {
                    // Kirim ke WhatsApp (default monitoring message)
                    $result = $this->fonteService->sendMonitoringMessage($phoneNumber, $data);
                }
            } finally {
                try {
                    $this->fonteService->setApiToken($originalToken);
                } catch (\Throwable $e) {
                    \Log::warning("Failed to restore original Fonnte API token: {$e->getMessage()}");
                }
            }

            if ($result['success']) {
                \Log::info("WhatsApp monitoring sent successfully", [
                    'user_id' => $userId,
                    'phone_number' => $phoneNumber,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data monitoring berhasil dikirim via WhatsApp',
                    'data' => $result['data'] ?? null,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim data monitoring via WhatsApp',
                    'error' => $result['error'],
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error("Error in sendMonitoringViaWhatsApp: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil data arus
     */
    public function getArus(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id ?? $request->input('user_id');
            if (! $userId) {
                return response()->json(['success' => false, 'message' => 'User ID tidak ditemukan'], 400);
            }

            $firebase = $this->resolveFirebaseService();
            if (! $firebase) {
                return response()->json(['success' => false, 'message' => 'Firebase tidak terkonfigurasi'], 500);
            }

            $arus = $firebase->getArusData((string) $userId);

            return response()->json([
                'success' => true,
                'data' => $arus,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil data daya
     */
    public function getDaya(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id ?? $request->input('user_id');
            if (! $userId) {
                return response()->json(['success' => false, 'message' => 'User ID tidak ditemukan'], 400);
            }

            $firebase = $this->resolveFirebaseService();
            if (! $firebase) {
                return response()->json(['success' => false, 'message' => 'Firebase tidak terkonfigurasi'], 500);
            }

            $daya = $firebase->getDayaData((string) $userId);

            return response()->json([
                'success' => true,
                'data' => $daya,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Kirim notifikasi tagihan listrik ke semua pengguna via WhatsApp
     * Diakses dari halaman laporan admin
     */
    public function sendBillingNotifications(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'room_ids' => 'array|required',
                'room_ids.*' => 'integer',
            ]);

            $roomIds = $request->input('room_ids', []);

            if (empty($roomIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pilih minimal satu kamar',
                ], 400);
            }

            // Ambil semua users berdasarkan room_id
            $users = \App\Models\User::whereIn('room', $roomIds)
                ->where('role', 'user')
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pengguna ditemukan untuk kamar yang dipilih',
                ], 404);
            }

            $firebase = $this->resolveFirebaseService();
            $roomReports = [];
            foreach ($roomIds as $roomId) {
                $roomData = [
                    'room' => $roomId,
                    'bulan' => date('F Y'),
                    'total_tagihan' => 'N/A',
                    'status_pembayaran' => 'Tidak tersedia',
                    'batas_pembayaran' => 'N/A',
                ];

                if ($firebase) {
                    try {
                        $roomHistory = $this->resolveFirebaseService()->getAllRoomData($roomId);
                        if (! empty($roomHistory['tagihan']['total_tagihan'] ?? null)) {
                            $roomData['bulan'] = $roomHistory['month'] ?? $roomData['bulan'];
                            $roomData['total_tagihan'] = $roomHistory['tagihan']['total_tagihan'];
                            $roomData['status_pembayaran'] = 'Tagihan tersedia';
                        }
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to load billing data for room {$roomId}: {$e->getMessage()}");
                    }
                }

                $roomReports[] = $roomData;
            }

            $results = [
                'success' => 0,
                'failed' => 0,
                'details' => [],
            ];

            foreach ($users as $user) {
                try {
                    // Default mapping per room (so admin UI works without manual DB edits)
                    $roomDefaults = [
                        1 => '081249471258',
                        2 => '082330710007',
                        3 => '081332425913',
                        // Perubahan: nomor tujuan untuk Kamar 4 (gunakan format internasional)
                        4 => '62881038128104',
                    ];

                    // Cek apakah user memiliki nomor WhatsApp. Jika tidak, isi otomatis dari mapping kamar khusus,
                    // lalu fallback ke ADMIN_NOTIFICATION_NUMBER jika mapping tidak ada.
                    $phoneNumber = $user->phone_number ?? null;
                    $usedFallback = false;

                    // Force use of default mapping for room 4 to avoid missed sends due to bad stored numbers
                    if (! empty($roomDefaults[$user->room] ?? null) && $user->room == 4) {
                        $phoneNumber = $roomDefaults[$user->room];
                        $usedFallback = true;
                    }

                    if (! $phoneNumber) {
                        if (! empty($roomDefaults[$user->room] ?? null)) {
                            $phoneNumber = $roomDefaults[$user->room];
                            $usedFallback = true;
                            // persist normalized phone for future convenience
                            try {
                                $normalized = $this->fonteService->formatPhoneNumber($phoneNumber);
                                $user->phone_number = $normalized;
                                $user->whatsapp_notifications_enabled = 1;
                                $user->save();
                                $phoneNumber = $normalized;
                            } catch (\Throwable $e) {
                                \Log::warning("Failed to persist default phone for user {$user->id}: {$e->getMessage()}");
                            }
                        } else {
                            $fallback = env('ADMIN_NOTIFICATION_NUMBER', '') ?: env('DEFAULT_WHATSAPP_NUMBER', '');
                            if (! empty($fallback)) {
                                $phoneNumber = $fallback;
                                $usedFallback = true;
                            } else {
                                $results['failed']++;
                                $results['details'][] = [
                                    'user' => $user->name,
                                    'status' => 'failed',
                                    'message' => 'Nomor WhatsApp tidak terdaftar',
                                ];
                                continue;
                            }
                        }
                    }

                    // Format dan validasi nomor WhatsApp. Jika perlu, coba fallback.
                    $formattedPhone = $this->fonteService->formatPhoneNumber($phoneNumber);

                    if (! $this->fonteService->isValidPhoneNumber($formattedPhone)) {
                        $fallback = env('ADMIN_NOTIFICATION_NUMBER', '') ?: env('DEFAULT_WHATSAPP_NUMBER', '');
                        if (! $usedFallback && ! empty($fallback)) {
                            $formattedPhone = $this->fonteService->formatPhoneNumber($fallback);
                            $usedFallback = true;
                        }
                    }

                    if (! $this->fonteService->isValidPhoneNumber($formattedPhone)) {
                        $results['failed']++;
                        $results['details'][] = [
                            'user' => $user->name,
                            'status' => 'failed',
                            'message' => 'Format nomor WhatsApp tidak valid',
                        ];
                        continue;
                    }

                    // Persist normalized number for future sends if original missing or different
                    try {
                        $normalized = $formattedPhone;
                        if ($user->phone_number !== $normalized) {
                            $user->phone_number = $normalized;
                            $user->whatsapp_notifications_enabled = 1;
                            $user->save();
                        }
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to persist normalized phone for user {$user->id}: {$e->getMessage()}");
                    }

                    // Support per-room API tokens (override FonteService token when configured)
                    $roomApiTokens = [
                        2 => 'tU9GoPoDw4vKq9Edde4s',
                        3 => 'x27yaMDq5DCwpawnYJZv',
                        4 => 'NCN9vSoKGCabfQovLRwe',
                    ];

                    // Preserve original token and apply override if room mapping exists
                    $originalToken = config('services.fonnte.api_token');
                    if (! empty($roomApiTokens[$user->room] ?? null)) {
                        try {
                            $this->fonteService->setApiToken($roomApiTokens[$user->room]);
                        } catch (\Throwable $e) {
                            \Log::warning("Failed to set per-room API token for room {$user->room}: {$e->getMessage()}");
                        }
                    } else {
                        // ensure FonteService has default token
                        $this->fonteService->setApiToken($originalToken);
                    }

                    // Kirim pesan laporan tagihan gabungan untuk semua kamar yang dipilih
                    $result = $this->fonteService->sendBillingReportMessage($formattedPhone, $roomReports);

                    // Restore original token to avoid leaking overrides across iterations
                    try {
                        $this->fonteService->setApiToken($originalToken);
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to restore original Fonnte API token: {$e->getMessage()}");
                    }

                    // Persist a whatsapp_messages record for audit/tracking
                    try {
                        $wmPayload = [
                            'user_id' => $user->id,
                            'phone_number' => $formattedPhone,
                            'message_type' => 'tagihan',
                            'message_content' => json_encode($roomReports, JSON_UNESCAPED_UNICODE),
                            'status' => $result['success'] ? 'sent' : 'failed',
                            'fonnte_response' => $result['data'] ?? null,
                            'error_message' => $result['error'] ?? null,
                            'sent_at' => $result['success'] ? now() : null,
                        ];

                        WhatsappMessage::create($wmPayload);
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to persist WhatsappMessage for user {$user->id}: {$e->getMessage()}");
                    }

                    if ($result['success']) {
                        $results['success']++;
                        $results['details'][] = [
                            'user' => $user->name,
                            'status' => 'success',
                            'message' => 'Notifikasi berhasil dikirim',
                        ];

                        \Log::info("Billing notification sent", [
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'phone_number' => $formattedPhone,
                        ]);
                    } else {
                        $results['failed']++;
                        $results['details'][] = [
                            'user' => $user->name,
                            'status' => 'failed',
                            'message' => 'Gagal mengirim: ' . ($result['error'] ?? 'Unknown error'),
                        ];

                        \Log::error("Failed to send billing notification", [
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'error' => $result['error'] ?? null,
                        ]);
                    }
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['details'][] = [
                        'user' => $user->name,
                        'status' => 'failed',
                        'message' => 'Error: ' . $e->getMessage(),
                    ];

                    \Log::error("Exception in sendBillingNotifications", [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Notifikasi dikirim: {$results['success']} berhasil, {$results['failed']} gagal",
                'data' => array_merge($results, [
                    'messages_sent' => $results['success'],
                    // aggregate total messages sent for these users in last 24 hours
                    'total_sent_last_24h' => \App\Models\WhatsappMessage::whereIn('user_id', $users->pluck('id'))->where('created_at', '>=', now()->subDay())->count(),
                ]),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in sendBillingNotifications: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
