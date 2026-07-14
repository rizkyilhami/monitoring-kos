<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Bootstrapped\n";
    $firebase = app(App\Services\FirebaseService::class);
    if (! $firebase->isConnected()) {
        echo "Firebase not connected\n";
        exit(0);
    }
    echo "Firebase connected\n";

    $userId = '1';
    echo "Fetching getAllUserData($userId)\n";
    $data = $firebase->getAllUserData($userId);
    var_export($data);
    echo "\nDone\n";
} catch (Throwable $e) {
    echo 'ERROR: ' . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
