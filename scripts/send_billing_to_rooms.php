<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

try {
    $controller = $app->make(\App\Http\Controllers\BillingController::class);

    // Build a request to send to rooms 1-4 (adjust as needed)
    $req = Request::create('/send-billing', 'POST', ['room_ids' => [1, 2, 3, 4]]);

    // Call the controller method
    $res = $controller->sendBillingNotifications($req);

    echo "Status: " . ($res->getStatusCode() ?? 'n/a') . PHP_EOL;
    echo "Response: " . $res->getContent() . PHP_EOL;
} catch (Throwable $t) {
    echo "Exception: " . $t->getMessage() . PHP_EOL;
    echo $t->getTraceAsString();
}

echo "Done.\n";
