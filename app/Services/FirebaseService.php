<?php

namespace App\Services;

use GuzzleHttp\RequestOptions;
use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Http\HttpClientOptions;

class FirebaseService
{
    private ?Database $database = null;

    public function __construct()
    {
        $credentialsPath = config('services.firebase.credentials') ?: env('FIREBASE_CREDENTIALS');
        $databaseUrl = config('services.firebase.database_url') ?: env('FIREBASE_DATABASE_URL');

        if (empty($credentialsPath) || empty($databaseUrl)) {
            \Log::warning('FirebaseService skipped initialization: missing credentials or database URL');
            return;
        }

        $absoluteCredentialsPath = $this->resolveCredentialsPath($credentialsPath);
        if (! file_exists($absoluteCredentialsPath)) {
            \Log::warning("Firebase credentials file not found: {$absoluteCredentialsPath}");
            return;
        }

        $caBundlePath = base_path('vendor/grpc/grpc/etc/roots.pem');
        if (file_exists($caBundlePath)) {
            @ini_set('openssl.cafile', $caBundlePath);
            @ini_set('curl.cainfo', $caBundlePath);
            @putenv('SSL_CERT_FILE=' . $caBundlePath);
            @putenv('CURL_CA_BUNDLE=' . $caBundlePath);
        }

        try {
            $verify = file_exists($caBundlePath) ? $caBundlePath : false;

            $httpOptions = HttpClientOptions::default()
                ->withGuzzleConfigOption(RequestOptions::VERIFY, $verify)
                ->withGuzzleConfigOption(RequestOptions::CONNECT_TIMEOUT, 10)
                ->withGuzzleConfigOption(RequestOptions::TIMEOUT, 30);

            $firebase = (new Factory())
                ->withServiceAccount($absoluteCredentialsPath)
                ->withDatabaseUri($databaseUrl)
                ->withHttpClientOptions($httpOptions);

            $this->database = $firebase->createDatabase();
            \Log::info('FirebaseService initialized with database URI: ' . $databaseUrl);
        } catch (\Throwable $e) {
            \Log::error("FirebaseService initialization failed: {$e->getMessage()}", ['exception' => $e]);
        }
    }

    private function resolveCredentialsPath(string $path): string
    {
        $trimmed = trim($path);

        if ($trimmed === '') {
            return $trimmed;
        }

        if (preg_match('#^[A-Za-z]:[\\/]#', $trimmed) || str_starts_with($trimmed, DIRECTORY_SEPARATOR)) {
            return $trimmed;
        }

        $resolved = base_path($trimmed);
        if (file_exists($resolved)) {
            return $resolved;
        }

        $resolved = storage_path($trimmed);
        if (file_exists($resolved)) {
            return $resolved;
        }

        $resolved = storage_path('app/firebase/' . ltrim($trimmed, '/\\'));
        if (file_exists($resolved)) {
            return $resolved;
        }

        return $trimmed;
    }

    public static function connect(): ?Database
    {
        return (new self())->database;
    }

    public function getDatabase(): ?Database
    {
        return $this->database;
    }

    public function isConnected(): bool
    {
        return $this->database !== null;
    }

    public function getReferenceValue(string $path): mixed
    {
        if (! $this->database) {
            return null;
        }

        try {
            $reference = $this->database->getReference($path);
            $snapshot = $reference->getSnapshot();

            $value = $snapshot->exists() ? $snapshot->getValue() : null;

            if (config('app.debug')) {
                \Log::debug("Firebase raw value for {$path}", ['value' => $value]);
            }

            return $value;
        } catch (\Exception $e) {
            \Log::error("FirebaseService getReferenceValue error: {$e->getMessage()}");
            return null;
        }
    }

    public function getData(string $path): mixed
    {
        if (! $this->isConnected()) {
            return null;
        }

        return $this->getReferenceValue($path);
    }

    public function getArusData(string $userId): ?array
    {
        if (! $this->database) {
            return null;
        }

        try {
            $reference = $this->database->getReference("users/{$userId}/arus");
            $snapshot = $reference->getSnapshot();

            return $snapshot->exists() ? $this->normalizeArus($snapshot->getValue()) : null;
        } catch (\Exception $e) {
            \Log::error("FirebaseService getArusData error: {$e->getMessage()}");
            return null;
        }
    }

    public function getDayaData(string $userId): ?array
    {
        if (! $this->database) {
            return null;
        }

        try {
            $reference = $this->database->getReference("users/{$userId}/daya");
            $snapshot = $reference->getSnapshot();

            return $snapshot->exists() ? $this->normalizeDaya($snapshot->getValue()) : null;
        } catch (\Exception $e) {
            \Log::error("FirebaseService getDayaData error: {$e->getMessage()}");
            return null;
        }
    }

    public function getTagihanData(string $userId): ?array
    {
        if (! $this->database) {
            return null;
        }

        try {
            $reference = $this->database->getReference("users/{$userId}/tagihan");
            $snapshot = $reference->getSnapshot();

            return $snapshot->exists() ? $this->normalizeTagihan($snapshot->getValue()) : null;
        } catch (\Exception $e) {
            \Log::error("FirebaseService getTagihanData error: {$e->getMessage()}");
            return null;
        }
    }

    public function getRootUserData(string $userId): ?array
    {
        $data = $this->getReferenceValue("users/{$userId}");
        return is_array($data) ? $data : null;
    }

    public function getAllUserData(string $userId, ?int $roomId = null): array
    {
        $userData = $this->getRootUserData($userId);
        $arus = $this->getArusData($userId);
        $daya = $this->getDayaData($userId);
        $tagihan = $this->getTagihanData($userId);

        if ($userData) {
            if (! $arus) {
                $arus = $this->normalizeArus($userData['arus'] ?? $userData['current'] ?? null);
            }
            if (! $daya) {
                $daya = $this->normalizeDaya($userData['daya'] ?? $userData['power'] ?? null);
            }
            if (! $tagihan) {
                $tagihan = $this->normalizeTagihan($userData['tagihan'] ?? $userData['billing'] ?? null);
            }
        }

        if (! $arus && ! $daya && ! $tagihan && $roomId !== null) {
            return $this->getAllRoomData($roomId);
        }

        return [
            'arus' => $arus,
            'daya' => $daya,
            'tagihan' => $tagihan,
        ];
    }

    public function getAllRoomData(int $roomId, ?string $month = null, string $basePath = 'history'): array
    {
        $month = $month ?? $this->findLatestMonthKey($basePath);
        $roomKey = "kamar_{$roomId}";

        if ($month) {
            $possibleBases = array_unique([$basePath, 'history-bulan']);
            $roomPath = null;

            foreach ($possibleBases as $path) {
                $candidatePath = trim("{$path}/{$month}/{$roomKey}", '/');
                if ($this->referenceExists($candidatePath)) {
                    $roomPath = $candidatePath;
                    break;
                }
            }

            $roomPath = $roomPath ?? trim("{$basePath}/{$month}/{$roomKey}", '/');
        } else {
            $roomPath = $roomKey;
        }

        $roomValue = $this->getReferenceValue($roomPath);
        if (! is_array($roomValue)) {
            $roomValue = [];
        }

        $arus = $roomValue['arus'] ?? $this->getReferenceValue("{$roomPath}/arus");
        $daya = $roomValue['daya'] ?? $this->getReferenceValue("{$roomPath}/daya");
        $tagihan = $roomValue['biaya_estimasi'] ?? $roomValue['total_tagihan'] ?? $roomValue['tagihan'] ?? $this->getReferenceValue("{$roomPath}/biaya_estimasi");

        return [
            'arus' => $this->normalizeArus($arus),
            'daya' => $this->normalizeDaya($daya),
            'tagihan' => $this->normalizeTagihan($tagihan),
            'month' => $month,
            'path' => $roomPath,
        ];
    }

    public function getHistoryMonths(string $basePath = 'history'): array
    {
        $months = [];
        $paths = array_unique([$basePath, 'history-bulan', 'history']);

        foreach ($paths as $path) {
            $history = $this->getReferenceValue($path);
            if (! is_array($history)) {
                continue;
            }

            $months = array_merge($months, array_keys($history));
        }

        $months = array_values(array_unique($months));
        if (empty($months)) {
            return [];
        }

        $numericMonths = array_filter($months, fn ($key) => preg_match('/^\d{2}-\d{4}$/', $key));
        if (! empty($numericMonths)) {
            usort($numericMonths, function ($a, $b) {
                [$am, $ay] = explode('-', $a);
                [$bm, $by] = explode('-', $b);

                if ($ay === $by) {
                    return (int) $am <=> (int) $bm;
                }

                return (int) $ay <=> (int) $by;
            });

            return $numericMonths;
        }

        return $months;
    }

    private function referenceExists(string $path): bool
    {
        if (! $this->database) {
            return false;
        }

        try {
            $reference = $this->database->getReference($path);
            $snapshot = $reference->getSnapshot();

            return $snapshot->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Save data to a given path in Firebase Realtime Database
     */
    public function saveData(string $path, mixed $data): bool
    {
        if (! $this->database) {
            return false;
        }

        try {
            $this->database->getReference($path)->set($data);
            return true;
        } catch (\Throwable $e) {
            \Log::error("FirebaseService saveData error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Update data at a given path in Firebase Realtime Database
     */
    public function updateData(string $path, array $updates): bool
    {
        if (! $this->database) {
            return false;
        }

        try {
            $this->database->getReference($path)->update($updates);
            return true;
        } catch (\Throwable $e) {
            \Log::error("FirebaseService updateData error: {$e->getMessage()}");
            return false;
        }
    }

    private function normalizeArus(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return [
                'current' => $value['current'] ?? $value['arus'] ?? $value['value'] ?? $value['val'] ?? $value['v'] ?? null,
                'voltage' => $value['voltage'] ?? $value['volt'] ?? $value['vlt'] ?? null,
            ];
        }

        return [
            'current' => round((float) $value, 4),
            'voltage' => null,
        ];
    }

    private function normalizeDaya(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return [
                'power' => $value['power'] ?? $value['daya'] ?? $value['value'] ?? $value['val'] ?? null,
                'kwh_total' => $value['kwh_total'] ?? $value['kwh_total'] ?? $value['kwh'] ?? null,
            ];
        }

        return [
            'power' => round((float) $value, 4),
            'kwh_total' => null,
        ];
    }

    private function normalizeTagihan(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return [
                'total_tagihan' => $value['total_tagihan'] ?? $value['harga_total'] ?? $value['biaya_estimasi'] ?? $value['value'] ?? null,
                'batas_pembayaran' => $value['batas_pembayaran'] ?? $value['due_date'] ?? $value['tanggal_jatuh_tempo'] ?? null,
            ];
        }

        return [
            'total_tagihan' => round((float) $value, 2),
            'batas_pembayaran' => null,
        ];
    }

    private function findLatestMonthKey(string $basePath = 'history'): ?string
    {
        $months = $this->getHistoryMonths($basePath);
        return empty($months) ? null : end($months);
    }
}
