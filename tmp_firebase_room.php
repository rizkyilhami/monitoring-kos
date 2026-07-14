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

    $roomId = 1;
    echo "Fetching getAllRoomData({$roomId})\n";
    $data = $firebase->getAllRoomData($roomId);
    var_export($data);
    echo "\nDone\n";
        echo "\n-- Root keys (top-level) --\n";
        $root = $firebase->getReferenceValue('/');
        if (is_array($root)) {
            foreach (array_keys($root) as $k) echo "- $k\n";
        } else {
            var_export($root);
        }

        echo "\n-- history-bulan content --\n";
        $hb = $firebase->getReferenceValue('history-bulan');
        var_export($hb);
} catch (Throwable $e) {
    echo 'ERROR: ' . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
