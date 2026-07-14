<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$firebase = app(App\Services\FirebaseService::class);
$data = $firebase->getAllUserData('1');
print_r($data);
