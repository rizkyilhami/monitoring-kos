<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $serviceAccountPath = __DIR__ . '/../storage/app/firebase/monitoring-listrik-rumah-kos-firebase-adminsdk-fbsvc-99dfbec6fb.json';
    $creds = json_decode(file_get_contents($serviceAccountPath), true);
    $factory = (new Kreait\Firebase\Factory)
        ->withServiceAccount($creds)
        ->withDatabaseUri('https://monitoring-listrik-rumah-kos-default-rtdb.asia-southeast1.firebasedatabase.app');

    $db = $factory->createDatabase();
    $snapshot = $db->getReference()->getSnapshot();
    $value = $snapshot->getValue();
    file_put_contents(__DIR__ . '/firebase_root_dump.json', json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo 'Wrote dump to scripts/firebase_root_dump.json';
} catch (\Throwable $e) {
    echo 'Error: ' . $e->getMessage();
    exit(1);
}
