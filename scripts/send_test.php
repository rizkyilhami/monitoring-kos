<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    /** @var \App\Services\FonteService $fonte */
    $fonte = $app->make(\App\Services\FonteService::class);

    $phones = [
        $argv[1] ?? '6281249471258', // kamar 1
        $argv[2] ?? '62881038128104', // kamar 2
        $argv[3] ?? '62881038128104', // kamar 4 (default)
    ];

    foreach ($phones as $phone) {
        echo "Sending to: {$phone}\n";

        // If this is the room-4 test number, set per-room token override
        $room4Formatted = $fonte->formatPhoneNumber('0881038128104');
        $originalToken = config('services.fonnte.api_token');
        try {
            if ($fonte->formatPhoneNumber($phone) === $room4Formatted) {
                try {
                    $fonte->setApiToken('QAt8R6CwTyAgpmcCT1Vv');
                } catch (Throwable $e) {
                    echo "Warning: failed to set token for room 4: {$e->getMessage()}\n";
                }
            }

            $res = $fonte->sendMessage($phone, '[AUTOTEST] Notifikasi dari monitoring-kos (uji)');
            print_r($res);
            echo "\n";
        } finally {
            try {
                $fonte->setApiToken($originalToken);
            } catch (Throwable $e) {
                // ignore
            }
        }
    }
} catch (Throwable $t) {
    echo 'Exception: ' . $t->getMessage() . PHP_EOL;
    echo $t->getTraceAsString();
    exit(1);
}

echo "Done.\n";
