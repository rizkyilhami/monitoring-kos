<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class DashboardController extends Controller
{
    /**
     * Try to resolve FirebaseService lazily. Returns null if credentials missing.
     */
    private function resolveFirebaseService(): ?FirebaseService
    {
        try {
            return app(FirebaseService::class);
        } catch (\Throwable $e) {
            \Log::warning("FirebaseService not available: {$e->getMessage()}");
            return null;
        }
    }



    protected function sampleRooms(): array
    {
        return [
            1 => [
                'name' => 'Kamar 1',
                'status' => 'Online',
                'voltage' => '220',
                'current' => '2.35',
                'power' => '517',
                'bill' => '98.230',
            ],
            2 => [
                'name' => 'Kamar 2',
                'status' => 'Online',
                'voltage' => '220',
                'current' => '1.80',
                'power' => '396',
                'bill' => '75.120',
            ],
            3 => [
                'name' => 'Kamar 3',
                'status' => 'Online',
                'voltage' => '220',
                'current' => '2.10',
                'power' => '462',
                'bill' => '87.430',
            ],
            4 => [
                'name' => 'Kamar 4',
                'status' => 'Online',
                'voltage' => '220',
                'current' => '1.65',
                'power' => '363',
                'bill' => '68.910',
            ],
        ];
    }

    protected function formatMonetaryValue($value): string
    {
        $value = preg_replace('/[^0-9]/', '', (string) $value);
        return number_format((int) $value, 0, ',', '.');
    }

    protected function parseNumericValue($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = str_replace([',', ' '], ['.', ''], trim((string) $value));
        $clean = preg_replace('/[^0-9.]/', '', $clean);

        return is_numeric($clean) ? (float) $clean : 0.0;
    }

    public function adminDashboard()
    {
        $rooms = $this->sampleRooms();

        $firebase = $this->resolveFirebaseService();

        // Enrich rooms with realtime data from Firebase when available
        foreach ($rooms as $roomId => &$room) {
            try {
                $user = User::where('room', $roomId)->where('role', 'user')->first();
                if ($firebase && $user) {
                    $data = $firebase->getAllUserData((string) $user->id, $user->room);
                    $arus = $data['arus'] ?? null;
                    $daya = $data['daya'] ?? null;
                    $tagihan = $data['tagihan'] ?? null;

                    $room['status'] = ($arus || $daya || $tagihan) ? 'Online' : 'Offline';
                    $room['voltage'] = $arus['voltage'] ?? $room['voltage'];
                    $room['current'] = $arus['current'] ?? $room['current'];
                    $room['power'] = $daya['power'] ?? $room['power'];
                    $room['bill'] = $tagihan['total_tagihan'] ?? $room['bill'];
                    // Expose the linked user id so frontend can poll per-room
                    $room['user_id'] = $user->id;
                    // Also attach monthly history snapshot (from history-bulan/<MM-YYYY>/kamar_<id>) if available
                    try {
                        $monthly = $firebase->getAllRoomData((int) $roomId);
                        if (is_array($monthly)) {
                            $room['monthly'] = $monthly;
                        }
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to load monthly data for room {$roomId}: {$e->getMessage()}");
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning("Failed to enrich room {$roomId} from Firebase: {$e->getMessage()}");
            }
        }

        $totalRooms = count($rooms);
        $activeRooms = 0;
        $totalPower = 0.0;
        $totalBill = 0.0;

        foreach ($rooms as $room) {
            if (isset($room['power'])) {
                $totalPower += $this->parseNumericValue($room['power']);
            }
            if (isset($room['bill'])) {
                $totalBill += $this->parseNumericValue($room['bill']);
            }
            if (isset($room['status']) && strtolower($room['status']) === 'online') {
                $activeRooms++;
            }
        }

        return view('admin.dashboard', [
            'rooms' => $rooms,
            'totalRooms' => $totalRooms,
            'activeRooms' => $activeRooms,
            'totalPower' => $totalPower,
            'totalBill' => $totalBill,
        ]);
    }

    /**
     * Tampilkan halaman laporan admin untuk mengirim notifikasi tagihan
     */
    public function adminReports()
    {
        // Ambil semua users yang non-admin
        $users = User::where('role', 'user')
            ->orderBy('room')
            ->get();

        // Ambil daftar kamar yang unik
        $rooms = $this->sampleRooms();

        return view('admin.reports', [
            'users' => $users,
            'rooms' => $rooms,
        ]);
    }

    public function adminRooms()
    {
        $rooms = $this->sampleRooms();

        return view('admin.rooms', [
            'rooms' => $rooms,
        ]);
    }

    public function adminSettings()
    {
        return view('admin.settings');
    }

    public function adminHistory()
    {
        $firebase = $this->resolveFirebaseService();
        $historyByMonth = [];
        $usersByRoom = User::whereIn('room', [1, 2, 3, 4])
            ->where('role', 'user')
            ->get()
            ->keyBy('room');

        if ($firebase) {
            $months = $firebase->getHistoryMonths();
            if (! empty($months)) {
                foreach ($months as $monthKey) {
                    $records = [];
                    foreach ([1, 2, 3, 4] as $roomId) {
                        $user = $usersByRoom->get($roomId);
                        $roomData = $firebase->getAllRoomData($roomId, $monthKey);
                        $tagihan = $roomData['tagihan'] ?? [];

                        if (empty($tagihan['total_tagihan']) && $user) {
                            $userTagihan = $firebase->getTagihanData((string) $user->id);
                            if (is_array($userTagihan)) {
                                $tagihan = array_merge($tagihan, $userTagihan);
                            }
                        }

                        $totalTagihan = $tagihan['total_tagihan'] ?? 0;
                        $statusPembayaran = $tagihan['status_pembayaran'] ?? null;
                        $status = $statusPembayaran ?: 'Belum Bayar';
                        $batasPembayaran = $tagihan['batas_pembayaran'] ?? null;

                        $records[] = [
                            'room' => $roomId,
                            'name' => "Kamar {$roomId}",
                            'status' => $status,
                            'amount' => $totalTagihan,
                            'paid_at' => $batasPembayaran ? $this->formatDateLabel($batasPembayaran) : null,
                            'method' => $totalTagihan ? 'Transfer' : null,
                        ];
                    }

                    $historyByMonth[$monthKey] = $records;
                }
            }

            if (empty($historyByMonth)) {
                $currentMonth = now()->format('F Y');
                $records = [];

                foreach ([1, 2, 3, 4] as $roomId) {
                    $tagihan = null;
                    $user = $usersByRoom->get($roomId);

                    if ($user) {
                        $tagihan = $firebase->getTagihanData((string) $user->id);
                    }

                    if (! is_array($tagihan) || empty($tagihan['total_tagihan'])) {
                        $roomData = $firebase->getAllRoomData($roomId);
                        $tagihan = $roomData['tagihan'] ?? [];
                    }

                    $totalTagihan = $tagihan['total_tagihan'] ?? 0;
                    $statusPembayaran = $tagihan['status_pembayaran'] ?? null;
                    $status = $statusPembayaran ?: ($totalTagihan ? 'Lunas' : 'Belum Bayar');
                    $batasPembayaran = $tagihan['batas_pembayaran'] ?? null;

                    $records[] = [
                        'room' => $roomId,
                        'name' => "Kamar {$roomId}",
                        'status' => $status,
                        'amount' => $totalTagihan,
                        'paid_at' => $batasPembayaran ? $this->formatDateLabel($batasPembayaran) : null,
                        'method' => $totalTagihan ? 'Transfer' : null,
                    ];
                }

                $historyByMonth[$currentMonth] = $records;
            }
        }

        if (empty($historyByMonth)) {
            $historyByMonth = [
                '—' => [
                    ['room' => 1, 'name' => 'Kamar 1', 'status' => 'Belum Bayar', 'amount' => 0, 'paid_at' => null, 'method' => null],
                    ['room' => 2, 'name' => 'Kamar 2', 'status' => 'Belum Bayar', 'amount' => 0, 'paid_at' => null, 'method' => null],
                    ['room' => 3, 'name' => 'Kamar 3', 'status' => 'Belum Bayar', 'amount' => 0, 'paid_at' => null, 'method' => null],
                    ['room' => 4, 'name' => 'Kamar 4', 'status' => 'Belum Bayar', 'amount' => 0, 'paid_at' => null, 'method' => null],
                ],
            ];
        }

        return view('admin.history', [
            'historyByMonth' => $historyByMonth,
        ]);
    }

    protected function formatDateLabel(?string $dateString): ?string
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            $date = new \DateTime($dateString);
            return $date->format('d M Y');
        } catch (\Throwable $e) {
            return $dateString;
        }
    }

    public function userDashboard()
    {
        $user = Auth::user();
        $rooms = $this->sampleRooms();
        $roomData = $rooms[$user->room] ?? [
            'name' => 'Kamar tidak tersedia',
            'status' => 'Offline',
            'voltage' => '220',
            'current' => '0',
            'power' => '0',
            'bill' => '0',
        ];

        $firebase = $this->resolveFirebaseService();
        if ($firebase) {
            try {
                $data = $firebase->getAllUserData((string) $user->id, $user->room);
                $arus = $data['arus'] ?? null;
                $daya = $data['daya'] ?? null;
                $tagihan = $data['tagihan'] ?? null;

                $roomData['status'] = ($arus || $daya || $tagihan) ? 'Online' : $roomData['status'];
                $roomData['voltage'] = $arus['voltage'] ?? $roomData['voltage'];
                $roomData['current'] = $arus['current'] ?? $roomData['current'];
                $roomData['power'] = $daya['power'] ?? $roomData['power'];
                $roomData['bill'] = $tagihan['total_tagihan'] ?? $roomData['bill'];
                // Attach monthly history snapshot for this user's room
                try {
                    $monthly = $firebase->getAllRoomData((int) $user->room);
                    if (is_array($monthly)) {
                        $roomData['monthly'] = $monthly;
                    }
                } catch (\Throwable $e) {
                    \Log::warning("Failed to load monthly data for user room {$user->room}: {$e->getMessage()}");
                }
            } catch (\Throwable $e) {
                \Log::warning("Failed to load Firebase data for user {$user->id}: {$e->getMessage()}");
            }
        }

        return view('user.dashboard', [
            'room' => $roomData,
            'roomNumber' => $user->room,
            'userName' => $user->name,
        ]);
    }

    public function userHistory()
    {
        $user = Auth::user();
        $rooms = $this->sampleRooms();
        $roomData = $rooms[$user->room] ?? ['name' => 'Kamar tidak tersedia'];

        // Sample history data (12 months)
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $historyData = [];
        for ($i = 0; $i < 12; $i++) {
            $historyData[] = [
                'month' => $months[$i],
                'power' => rand(150, 300) . ' kWh',
                'bill' => 'Rp ' . number_format(rand(250000, 500000), 0, ',', '.'),
                'status' => rand(0, 1) ? 'Lunas' : 'Pending',
                'date' => date('Y-m-d', strtotime("-" . (11 - $i) . " months"))
            ];
        }

        return view('user.dashboard', [
            'room' => $roomData,
            'roomNumber' => $user->room,
            'userName' => $user->name,
            'activeTab' => 'history',
            'historyData' => $historyData,
        ]);
    }

    public function userBilling()
    {
        $user = Auth::user();
        $rooms = $this->sampleRooms();
        $roomData = $rooms[$user->room] ?? ['name' => 'Kamar tidak tersedia'];

        // Sample billing data
        $billingData = [
            [
                'month' => 'Bulan Ini (Juli 2026)',
                'period' => '01 - 31 Juli 2026',
                'usage' => '285 kWh',
                'amount' => 'Rp 427.500',
                'status' => 'Pending',
                'dueDate' => '10 Agustus 2026'
            ],
            [
                'month' => 'Juni 2026',
                'period' => '01 - 30 Juni 2026',
                'usage' => '250 kWh',
                'amount' => 'Rp 375.000',
                'status' => 'Lunas',
                'paidDate' => '08 Juli 2026'
            ],
            [
                'month' => 'Mei 2026',
                'period' => '01 - 31 Mei 2026',
                'usage' => '265 kWh',
                'amount' => 'Rp 397.500',
                'status' => 'Lunas',
                'paidDate' => '05 Juni 2026'
            ],
            [
                'month' => 'April 2026',
                'period' => '01 - 30 April 2026',
                'usage' => '220 kWh',
                'amount' => 'Rp 330.000',
                'status' => 'Lunas',
                'paidDate' => '02 Mei 2026'
            ],
        ];

        return view('user.dashboard', [
            'room' => $roomData,
            'roomNumber' => $user->room,
            'userName' => $user->name,
            'activeTab' => 'billing',
            'billingData' => $billingData,
        ]);
    }

    public function userProfile()
    {
        $user = Auth::user();
        $rooms = $this->sampleRooms();
        $roomData = $rooms[$user->room] ?? ['name' => 'Kamar tidak tersedia'];

        $profileData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '081234567890',
            'room' => $user->room,
            'joinDate' => $user->created_at->format('d F Y'),
            'memberSince' => $user->created_at->diffForHumans(),
            'totalUsage' => '3.240 kWh',
            'totalBilled' => 'Rp 4.860.000',
            'outstandingBill' => 'Rp 427.500',
        ];

        return view('user.dashboard', [
            'room' => $roomData,
            'roomNumber' => $user->room,
            'userName' => $user->name,
            'activeTab' => 'profile',
            'profileData' => $profileData,
        ]);
    }
}
