<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FonteService
{
    private Client $client;
    private string $apiToken;
    private string $apiUrl;
    /** @var bool|string */
    private $verify;

    public function __construct()
    {
        $this->apiToken = config('services.fonnte.api_token');
        $this->apiUrl = config('services.fonnte.api_url');
        $this->client = new Client();

        // Configure SSL verification behavior:
        // - If FONNTE_SKIP_SSL_VERIFY=true -> disable verification (use only for local debugging)
        // - Else if FONNTE_CAFILE is set -> use that file as CA bundle
        // - Otherwise, use default system verification (true)
        $skip = filter_var(env('FONNTE_SKIP_SSL_VERIFY', false), FILTER_VALIDATE_BOOLEAN);
        $cafile = env('FONNTE_CAFILE', '');

        if ($skip) {
            $this->verify = false;
            \Log::warning('Fonnte SSL verification is disabled via FONNTE_SKIP_SSL_VERIFY');
        } elseif (! empty($cafile)) {
            $this->verify = $cafile;
            \Log::info("Fonnte SSL verification using CA file: {$cafile}");
        } else {
            $this->verify = true;
        }
    }

    /**
     * Override the API token used for subsequent requests. Pass null to reset to config value.
     */
    public function setApiToken(?string $token): void
    {
        if ($token === null) {
            $this->apiToken = config('services.fonnte.api_token');
        } else {
            $this->apiToken = $token;
        }
    }

    /**
     * Kirim pesan WhatsApp ke nomor tertentu
     *
     * @param string $targetNumber Nomor WhatsApp tujuan (format: 628123456789)
     * @param string $message Pesan yang akan dikirim
     * @return array
     */
    public function sendMessage(string $targetNumber, string $message): array
    {
        try {
            // Re-evaluate SSL verification at request time in case env/config changed
            $skip = filter_var(env('FONNTE_SKIP_SSL_VERIFY', false), FILTER_VALIDATE_BOOLEAN);
            $cafile = env('FONNTE_CAFILE', '') ?: null;

            if ($skip) {
                $verifyOption = false;
            } elseif (! empty($cafile)) {
                $verifyOption = $cafile;
            } else {
                $verifyOption = $this->verify;
            }

            $options = [
                'headers' => [
                    'Authorization' => $this->apiToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'target' => $targetNumber,
                    'message' => $message,
                ],
                'verify' => $verifyOption,
            ];

            $response = $this->client->post($this->apiUrl, $options);

            $responseBody = json_decode((string) $response->getBody(), true);

            return [
                'success' => true,
                'status' => $response->getStatusCode(),
                'data' => $responseBody,
            ];
        } catch (GuzzleException $e) {
            \Log::error("Fonnte API Error: {$e->getMessage()}");

            // If error is cURL error 77 (CA bundle), retry once without SSL verification
            $msg = $e->getMessage();
            if (stripos($msg, 'cURL error 77') !== false) {
                \Log::warning('Detected cURL error 77, retrying Fonnte request with SSL verification disabled');

                try {
                    // Use a fresh Guzzle client for the retry to avoid any client-level defaults
                    $retryClient = new Client(['verify' => false]);
                    $retryOptions = [
                        'headers' => [
                            'Authorization' => $this->apiToken,
                            'Content-Type' => 'application/json',
                        ],
                        'json' => [
                            'target' => $targetNumber,
                            'message' => $message,
                        ],
                        'verify' => false,
                    ];

                    $response = $retryClient->post($this->apiUrl, $retryOptions);
                    $responseBody = json_decode((string) $response->getBody(), true);

                    return [
                        'success' => true,
                        'status' => $response->getStatusCode(),
                        'data' => $responseBody,
                        'warning' => 'ssl_verification_disabled_on_retry',
                    ];
                } catch (GuzzleException $e2) {
                    \Log::error("Fonnte API Retry Error: {$e2->getMessage()}");
                    return [
                        'success' => false,
                        'error' => $e2->getMessage(),
                        'status' => $e2->getCode(),
                    ];
                }
            }

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status' => $e->getCode(),
            ];
        }
    }

    /**
     * Kirim pesan WhatsApp dengan format tagihan listrik
     *
     * @param string $targetNumber Nomor WhatsApp tujuan
     * @param array $tagihan Data tagihan
     * @return array
     */
    public function sendBillingMessage(string $targetNumber, array $tagihan): array
    {
        $message = $this->formatBillingMessage($tagihan);

        // Optionally append a short nonce so repeated sends produce unique payloads
        if (filter_var(env('FONNTE_ALLOW_DUPLICATES', false), FILTER_VALIDATE_BOOLEAN)) {
            $nonce = substr(md5(uniqid((string) random_int(0, PHP_INT_MAX), true)), 0, 8);
            $message .= "\n\n(id:{$nonce})";
        }

        return $this->sendMessage($targetNumber, $message);
    }

    public function sendBillingReportMessage(string $targetNumber, array $rooms): array
    {
        $message = $this->formatBillingReportMessage($rooms);

        if (filter_var(env('FONNTE_ALLOW_DUPLICATES', false), FILTER_VALIDATE_BOOLEAN)) {
            $nonce = substr(md5(uniqid((string) random_int(0, PHP_INT_MAX), true)), 0, 8);
            $message .= "\n\n(id:{$nonce})";
        }

        return $this->sendMessage($targetNumber, $message);
    }

    private function formatBillingReportMessage(array $rooms): string
    {
        $messageLines = [
            '📊 LAPORAN TAGIHAN LISTRIK 📊',
            '',
        ];

        foreach ($rooms as $room) {
            $roomNumber = $room['room'] ?? ($room['name'] ?? 'N/A');
            $month = $room['bulan'] ?? date('m-Y');
            $penggunaan = $this->formatDecimalNumber($room['penggunaan'] ?? 0);
            $totalTagihan = $this->formatRupiah($room['total_tagihan'] ?? 0);
            $batasPembayaran = $this->formatDateIndo($room['batas_pembayaran'] ?? null);

            $messageLines[] = '📋 *Rincian Tagihan*';
            $messageLines[] = "• Kamar : {$roomNumber}";
            $messageLines[] = "• Periode : {$month}";
            $messageLines[] = "• Pemakaian Energi : {$penggunaan} kWh";
            $messageLines[] = "• Total Tagihan : *Rp {$totalTagihan}*";
            $messageLines[] = '';
            $messageLines[] = "Mohon kesediaannya untuk melakukan pembayaran paling lambat pada *{$batasPembayaran}*.";
            $messageLines[] = '';
            $messageLines[] = 'Pembayaran dapat dilakukan melalui:';
            $messageLines[] = '*Transfer Bank / QRIS*';
            $messageLines[] = '';
            $messageLines[] = 'Apabila pembayaran telah dilakukan, mohon konfirmasi dengan mengirimkan bukti pembayaran melalui WhatsApp ini.';
            $messageLines[] = '';
        }

        return implode("\n", array_filter($messageLines, fn($line) => $line !== null));
    }

    private function formatRupiah(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '0';
        }

        if (is_string($value)) {
            $clean = preg_replace('/[^0-9,\.]/', '', $value);
            if ($clean === '') {
                return '0';
            }
            $clean = str_replace(',', '.', $clean);
            $value = (float) $clean;
        }

        if (! is_numeric($value)) {
            return '0';
        }

        return number_format((float) $value, 0, ',', '.');
    }

    private function formatDecimalNumber(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '0,00';
        }

        if (is_string($value)) {
            $clean = preg_replace('/[^0-9,\.]/', '', $value);
            if ($clean === '') {
                return '0,00';
            }
            $clean = str_replace(',', '.', $clean);
            $value = (float) $clean;
        }

        if (! is_numeric($value)) {
            return '0,00';
        }

        return number_format((float) $value, 2, ',', '.');
    }

    private function formatDateIndo(?string $dateString): string
    {
        if (empty($dateString)) {
            return 'N/A';
        }

        try {
            $date = new \DateTime($dateString);
            return $date->format('d F Y');
        } catch (\Throwable $e) {
            return $dateString;
        }
    }

    /**
     * Format pesan tagihan listrik untuk WhatsApp
     *
     * @param array $tagihan
     * @return string
     */
    private function formatBillingMessage(array $tagihan): string
    {
        $roomNumber = $tagihan['room'] ?? 'N/A';
        $bulan = $tagihan['bulan'] ?? date('m-Y');
        $penggunaan = $this->formatDecimalNumber($tagihan['penggunaan'] ?? 0);
        $totalTagihan = $this->formatRupiah($tagihan['total_tagihan'] ?? 0);
        $batasPembayaran = $this->formatDateIndo($tagihan['batas_pembayaran'] ?? null);

        return <<<EOT
📊 LAPORAN TAGIHAN LISTRIK 📊

📋 *Rincian Tagihan*
• Kamar : {$roomNumber}
• Periode : {$bulan}
• Pemakaian Energi : {$penggunaan} kWh
• Total Tagihan : *Rp {$totalTagihan}*

Mohon kesediaannya untuk melakukan pembayaran paling lambat pada *{$batasPembayaran}*.

Pembayaran dapat dilakukan melalui:
*Transfer Bank / QRIS*

Apabila pembayaran telah dilakukan, mohon konfirmasi dengan mengirimkan bukti pembayaran melalui WhatsApp ini.
EOT;
    }

    /**
     * Kirim pesan data monitoring real-time
     *
     * @param string $targetNumber Nomor WhatsApp tujuan
     * @param array $data Data monitoring (arus, daya, dll)
     * @return array
     */
    public function sendMonitoringMessage(string $targetNumber, array $data): array
    {
        $message = $this->formatMonitoringMessage($data);

        if (filter_var(env('FONNTE_ALLOW_DUPLICATES', false), FILTER_VALIDATE_BOOLEAN)) {
            $nonce = substr(md5(uniqid((string) random_int(0, PHP_INT_MAX), true)), 0, 8);
            $message .= "\n\n(id:{$nonce})";
        }

        return $this->sendMessage($targetNumber, $message);
    }

    /**
     * Format pesan monitoring untuk WhatsApp
     *
     * @param array $data
     * @return string
     */
    private function formatMonitoringMessage(array $data): string
    {
        $arus = $data['arus'] ?? 0;
        $daya = $data['daya'] ?? 0;
        $tegangan = $data['tegangan'] ?? 0;
        $timestamp = $data['timestamp'] ?? now()->format('d-m-Y H:i:s');

        return <<<EOT
⚡ *MONITORING LISTRIK* ⚡

Waktu: $timestamp

Arus: {$arus} A
Daya: {$daya} W
Tegangan: {$tegangan} V

Sistem Monitoring Aktif ✓
EOT;
    }

    /**
     * Kirim pesan dengan media (gambar/dokumen)
     *
     * @param string $targetNumber Nomor WhatsApp tujuan
     * @param string $message Pesan text
     * @param string $mediaUrl URL media
     * @param string $mediaType Tipe media (image, document, audio, video)
     * @return array
     */
    public function sendMediaMessage(string $targetNumber, string $message, string $mediaUrl, string $mediaType = 'image'): array
    {
        try {
            $options = [
                'headers' => [
                    'Authorization' => $this->apiToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'target' => $targetNumber,
                    'message' => $message,
                    'url' => $mediaUrl,
                    'filename' => $this->generateFilename($mediaType),
                ],
                'verify' => $this->verify,
            ];

            $response = $this->client->post($this->apiUrl, $options);

            $responseBody = json_decode((string) $response->getBody(), true);

            return [
                'success' => true,
                'status' => $response->getStatusCode(),
                'data' => $responseBody,
            ];
        } catch (GuzzleException $e) {
            \Log::error("Fonnte Media Error: {$e->getMessage()}");

            $msg = $e->getMessage();
            if (stripos($msg, 'cURL error 77') !== false && $this->verify !== false) {
                \Log::warning('Detected cURL error 77 for media send, retrying with SSL verification disabled');

                try {
                    $retryOptions = $options;
                    $retryOptions['verify'] = false;
                    $response = $this->client->post($this->apiUrl, $retryOptions);
                    $responseBody = json_decode((string) $response->getBody(), true);

                    return [
                        'success' => true,
                        'status' => $response->getStatusCode(),
                        'data' => $responseBody,
                        'warning' => 'ssl_verification_disabled_on_retry',
                    ];
                } catch (GuzzleException $e2) {
                    \Log::error("Fonnte Media Retry Error: {$e2->getMessage()}");
                    return [
                        'success' => false,
                        'error' => $e2->getMessage(),
                        'status' => $e2->getCode(),
                    ];
                }
            }

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status' => $e->getCode(),
            ];
        }
    }

    /**
     * Generate nama file berdasarkan tipe media
     *
     * @param string $mediaType
     * @return string
     */
    private function generateFilename(string $mediaType): string
    {
        $timestamp = now()->format('YmdHis');

        return match ($mediaType) {
            'image' => "image_$timestamp.jpg",
            'document' => "document_$timestamp.pdf",
            'audio' => "audio_$timestamp.mp3",
            'video' => "video_$timestamp.mp4",
            default => "media_$timestamp"
        };
    }

    /**
     * Validasi format nomor WhatsApp
     *
     * @param string $phoneNumber
     * @return bool
     */
    public function isValidPhoneNumber(string $phoneNumber): bool
    {
        // Format: 628123456789 (62 adalah kode Indonesia)
        return preg_match('/^62\d{9,12}$/', $phoneNumber) === 1;
    }

    /**
     * Convert nomor lokal ke format WhatsApp
     * 08123456789 -> 628123456789
     *
     * @param string $phoneNumber
     * @return string
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Hapus semua karakter selain angka
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Jika dimulai dengan 0, ganti dengan 62
        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        // Jika belum ada kode negara, tambahkan 62
        if (! str_starts_with($phoneNumber, '62')) {
            $phoneNumber = '62' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
