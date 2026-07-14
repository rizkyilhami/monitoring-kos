<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Test Controller untuk testing API endpoints
 * 
 * GUNAKAN HANYA UNTUK DEVELOPMENT!
 * Hapus di production.
 */
class TestController extends Controller
{
    public function __construct()
    {
        // No constructor work needed for Firebase read-only test controller.
    }

    /**
     * Test Firebase connection
     */
    public function testFirebaseConnection(Request $request): JsonResponse
    {
        try {
            $firebaseService = app(\App\Services\FirebaseService::class);
            $userId = optional(auth()->user())->id ?? 'test-user';

            // Fetch only Firebase data
            $data = $firebaseService->getAllUserData((string) $userId);

            return response()->json([
                'success' => true,
                'message' => 'Firebase read OK',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase connection failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Debug Firebase room data path.
     */
    public function debugFirebaseRoom(Request $request): JsonResponse
    {
        try {
            $firebaseService = app(\App\Services\FirebaseService::class);
            $roomId = (int) ($request->input('room_id') ?? 1);
            $month = $request->input('month');

            $data = $firebaseService->getAllRoomData($roomId, $month);

            return response()->json([
                'success' => true,
                'room_id' => $roomId,
                'month' => $month,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase debug failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test Fonnte connection
     */
    public function testFonteConnection(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'phone_number' => 'required|string',
            ]);

            $fonteService = app(\App\Services\FonteService::class);
            $phoneNumber = $request->input('phone_number');

            // Format and validate
            $phoneNumber = $fonteService->formatPhoneNumber($phoneNumber);

            if (! $fonteService->isValidPhoneNumber($phoneNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid phone number',
                    'formatted_number' => $phoneNumber,
                ], 400);
            }

            // Send test message
            $result = $fonteService->sendMessage(
                $phoneNumber,
                "🧪 Test message dari monitoring system\n\nJika Anda menerima pesan ini, Fonnte API berfungsi dengan baik! ✓"
            );

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Fonnte connection OK' : 'Fonnte connection failed',
                'formatted_number' => $phoneNumber,
                'response' => $result['data'] ?? $result['error'],
            ], $result['success'] ? 200 : 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test complete workflow
     */
    public function testCompleteWorkflow(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'phone_number' => 'required|string',
            ]);

            $firebaseService = app(\App\Services\FirebaseService::class);
            $fonteService = app(\App\Services\FonteService::class);
            $userId = auth()->user()->id ?? 'test-user';
            $phoneNumber = $request->input('phone_number');

            // Format phone
            $phoneNumber = $fonteService->formatPhoneNumber($phoneNumber);

            if (! $fonteService->isValidPhoneNumber($phoneNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid phone number format',
                ], 400);
            }

            // Step 1: Get Firebase data
            $tagihan = $firebaseService->getTagihanData($userId);
            if (! $tagihan) {
                return response()->json([
                    'success' => false,
                    'message' => 'No billing data found in Firebase',
                    'hint' => 'Run: php artisan firebase:setup',
                ], 404);
            }

            // Step 2: Send via WhatsApp
            $result = $fonteService->sendBillingMessage($phoneNumber, $tagihan);

            if (! $result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send WhatsApp',
                    'error' => $result['error'],
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Complete workflow tested successfully',
                'steps' => [
                    'Firebase fetch' => '✓ OK',
                    'Fonnte send' => '✓ OK',
                ],
                'data_sent' => [
                    'phone' => $phoneNumber,
                    'tagihan' => $tagihan,
                ],
                'fonnte_response' => $result['data'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Workflow test failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $this->database->getReference('test/blogs/' . $request['title'])
            ->update([
                'content/' => $request['content']
            ]);

        return response()->json('blog has been edited');
    }

    public function delete(Request $request): JsonResponse
    {
        $this->database->getReference('test/blogs/' . $request['title'])
            ->remove();

        return response()->json('blog has been deleted');
    }

    /**
     * Get environment configuration (for debugging)
     */
    public function getConfig(): JsonResponse
    {
        if (! app()->isLocal()) {
            return response()->json([
                'success' => false,
                'message' => 'This endpoint is only available in local environment',
            ], 403);
        }

        return response()->json([
            'firebase' => [
                'configured' => ! empty(config('services.firebase.credentials')) && ! empty(config('services.firebase.database_url')),
                'credentials_file' => config('services.firebase.credentials'),
                'database_url' => config('services.firebase.database_url'),
            ],
            'fonnte' => [
                'configured' => ! empty(config('services.fonnte.api_token')),
                'api_url' => config('services.fonnte.api_url'),
                'api_token_preview' => substr(config('services.fonnte.api_token'), 0, 10) . '...',
            ],
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
        ]);
    }
}
