<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/rooms', [DashboardController::class, 'adminRooms'])->name('admin.rooms');
    Route::get('/admin/history', [DashboardController::class, 'adminHistory'])->name('admin.history');
    Route::get('/admin/settings', [DashboardController::class, 'adminSettings'])->name('admin.settings');
    Route::get('/admin/reports', [DashboardController::class, 'adminReports'])->name('admin.reports');
    Route::post('/admin/reports/send-billing', [BillingController::class, 'sendBillingNotifications'])->name('admin.reports.send-billing');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/history', [DashboardController::class, 'userHistory'])->name('user.history');
    Route::get('/user/billing', [DashboardController::class, 'userBilling'])->name('user.billing');
    Route::get('/user/profile', [DashboardController::class, 'userProfile'])->name('user.profile');
});

// ========================================
// API Routes untuk Firebase & Fonnte
// ========================================
Route::middleware('auth')->group(function () {
    // Billing Routes
    Route::prefix('api/billing')->group(function () {
        Route::get('/tagihan', [BillingController::class, 'getTagihan'])->name('api.billing.tagihan');
        Route::post('/send-whatsapp', [BillingController::class, 'sendTagihanViaWhatsApp'])->name('api.billing.send-whatsapp');

        // Monitoring Data
        Route::get('/monitoring', [BillingController::class, 'getMonitoring'])->name('api.billing.monitoring');
        Route::post('/monitoring/send-whatsapp', [BillingController::class, 'sendMonitoringViaWhatsApp'])->name('api.billing.monitoring.send-whatsapp');

        // Individual data
        Route::get('/arus', [BillingController::class, 'getArus'])->name('api.billing.arus');
        Route::get('/daya', [BillingController::class, 'getDaya'])->name('api.billing.daya');
    });

    // Firebase generic read/write routes
    Route::prefix('api/firebase')->group(function () {
        Route::get('/read', [FirebaseController::class, 'read'])->name('api.firebase.read');
        Route::post('/write', [FirebaseController::class, 'write'])->name('api.firebase.write');
    });
});

// ========================================
// Test Routes (Local/Development Only)
// ========================================
if (app()->isLocal()) {
    Route::prefix('test')->middleware('auth')->group(function () {
        Route::get('/firebase', [TestController::class, 'testFirebaseConnection'])->name('test.firebase');
        Route::get('/firebase-room', [TestController::class, 'debugFirebaseRoom'])->name('test.firebase-room');
        Route::post('/fonnte', [TestController::class, 'testFonteConnection'])->name('test.fonnte');
        Route::post('/workflow', [TestController::class, 'testCompleteWorkflow'])->name('test.workflow');
        Route::get('/config', [TestController::class, 'getConfig'])->name('test.config');
    });
}
