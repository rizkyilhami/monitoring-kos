<?php
require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env as $line) {
        if (strpos($line, '=') === false) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v, " \t\n\r\0\x0B\"'");
        putenv("$k=$v");
    }
}

$cred = getenv('FIREBASE_CREDENTIALS') ?: getenv('GOOGLE_APPLICATION_CREDENTIALS');
$url = getenv('FIREBASE_DATABASE_URL');

if (! $cred || ! file_exists(__DIR__ . '/../' . $cred)) {
    echo "CREDENTIAL_MISSING\n";
    exit(2);
}

try {
    $factory = (new Factory)
        ->withServiceAccount(__DIR__ . '/../' . $cred)
        ->withDatabaseUri($url);

    $database = $factory->createDatabase();
    $ref = $database->getReference('users');
    $snapshot = $ref->getSnapshot();
    $value = $snapshot->getValue();

    if (is_array($value)) {
        echo "CONNECTED\n";
        echo "users_count=" . count($value) . "\n";
        $keys = array_slice(array_keys($value), 0, 5);
        echo "sample_keys=" . implode(',', $keys) . "\n";
    } else if ($value) {
        echo "CONNECTED\n";
        echo "users_value_present\n";
    } else {
        echo "CONNECTED_BUT_EMPTY\n";
    }
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(3);
}
