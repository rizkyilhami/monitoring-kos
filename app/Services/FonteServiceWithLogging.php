<?php

namespace App\Services;

use App\Models\WhatsappMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Enhanced Fonnte Service with Database Logging
 * 
 * Uncomment save methods jika ingin log ke database
 */
class FonteServiceWithLogging extends FonteService
{
    /**
     * Kirim pesan WhatsApp dan log ke database
     *
     * @param string $targetNumber
     * @param string $message
     * @param int|null $userId
     * @param string $messageType
     * @return array
     */
    public function sendMessageWithLogging(
        string $targetNumber,
        string $message,
        ?int $userId = null,
        string $messageType = 'other'
    ): array {
        // Normalize phone number
        $targetNumber = $this->formatPhoneNumber($targetNumber);

        // Validate
        if (! $this->isValidPhoneNumber($targetNumber)) {
            return [
                'success' => false,
                'error' => 'Invalid phone number',
            ];
        }

        // Create record
        $record = null;
        if ($userId) {
            $record = WhatsappMessage::create([
                'user_id' => $userId,
                'phone_number' => $targetNumber,
                'message_type' => $messageType,
                'message_content' => $message,
                'status' => 'pending',
            ]);
        }

        // Send message
        $result = $this->sendMessage($targetNumber, $message);

        // Update record
        if ($record) {
            if ($result['success']) {
                $record->markAsSent(
                    $result['data'] ?? null,
                    $result['data']['id'] ?? null
                );
            } else {
                $record->markAsFailed($result['error']);
            }
        }

        return $result;
    }

    /**
     * Kirim tagihan dan log ke database
     *
     * @param string $targetNumber
     * @param array $tagihan
     * @param int|null $userId
     * @return array
     */
    public function sendBillingMessageWithLogging(
        string $targetNumber,
        array $tagihan,
        ?int $userId = null
    ): array {
        $message = $this->formatBillingMessage($tagihan);

        return $this->sendMessageWithLogging(
            $targetNumber,
            $message,
            $userId,
            'tagihan'
        );
    }

    /**
     * Kirim monitoring dan log ke database
     *
     * @param string $targetNumber
     * @param array $data
     * @param int|null $userId
     * @return array
     */
    public function sendMonitoringMessageWithLogging(
        string $targetNumber,
        array $data,
        ?int $userId = null
    ): array {
        $message = $this->formatMonitoringMessage($data);

        return $this->sendMessageWithLogging(
            $targetNumber,
            $message,
            $userId,
            'monitoring'
        );
    }

    /**
     * Get history for user
     *
     * @param int $userId
     * @param int $limit
     * @return mixed
     */
    public function getHistory(int $userId, int $limit = 50)
    {
        return WhatsappMessage::ofUser($userId)
            ->latest('sent_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get statistics
     *
     * @param int $userId
     * @param string|null $type
     * @return array
     */
    public function getStatistics(int $userId, ?string $type = null): array
    {
        $query = WhatsappMessage::ofUser($userId);

        if ($type) {
            $query = $query->ofType($type);
        }

        return [
            'total' => $query->count(),
            'sent' => $query->clone()->sent()->count(),
            'failed' => $query->clone()->failed()->count(),
            'pending' => $query->clone()->pending()->count(),
            'success_rate' => $this->calculateSuccessRate($query),
        ];
    }

    /**
     * Calculate success rate
     *
     * @param mixed $query
     * @return float
     */
    private function calculateSuccessRate($query): float
    {
        $total = $query->count();

        if ($total === 0) {
            return 0;
        }

        $sent = $query->clone()->sent()->count();

        return round(($sent / $total) * 100, 2);
    }

    /**
     * Send batch messages
     *
     * @param array $messages Format: [['phone' => '62...', 'message' => 'text', 'user_id' => 1], ...]
     * @param string $messageType
     * @return array
     */
    public function sendBatch(array $messages, string $messageType = 'other'): array
    {
        $results = [
            'total' => count($messages),
            'sent' => 0,
            'failed' => 0,
            'details' => [],
        ];

        foreach ($messages as $item) {
            $phone = $item['phone'] ?? null;
            $message = $item['message'] ?? null;
            $userId = $item['user_id'] ?? null;

            if (! $phone || ! $message) {
                $results['details'][] = [
                    'phone' => $phone,
                    'success' => false,
                    'error' => 'Missing phone or message',
                ];
                continue;
            }

            $result = $this->sendMessageWithLogging(
                $phone,
                $message,
                $userId,
                $messageType
            );

            if ($result['success']) {
                $results['sent']++;
            } else {
                $results['failed']++;
            }

            $results['details'][] = [
                'phone' => $phone,
                'success' => $result['success'],
                'error' => $result['error'] ?? null,
            ];

            // Add small delay to avoid rate limiting
            usleep(100000); // 100ms
        }

        return $results;
    }
}
