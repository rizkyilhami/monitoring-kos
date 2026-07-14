<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;

$controller = app(App\Http\Controllers\BillingController::class);
$request = Request::create('/api/billing/monitoring', 'GET', ['room_id' => 1]);
$response = $controller->getMonitoring($request);

// If response is JsonResponse, print data
if (method_exists($response, 'getContent')) {
    echo $response->getContent();
} else {
    var_export($response);
}
