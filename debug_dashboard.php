<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Http\Kernel::class)->bootstrap();
$user = App\Models\User::where('role','admin')->first();
if (! $user) { echo "NO_ADMIN"; exit(1); }
Illuminate\Support\Facades\Auth::login($user);
$controller = new App\Http\Controllers\DashboardController();
echo $controller->adminDashboard();
