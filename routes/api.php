<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DatabaseBackupController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmailSettingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('company', [CompanyController::class, 'show']);
    Route::put('company', [CompanyController::class, 'update']);

    Route::get('email-settings', [EmailSettingController::class, 'show']);
    Route::put('email-settings', [EmailSettingController::class, 'update']);
    Route::get('database-backup', [DatabaseBackupController::class, 'download']);

    Route::apiResource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('services', ServiceController::class);
    Route::get('orders/{order}/pdf', [OrderController::class, 'pdf']);
    Route::apiResource('orders', OrderController::class);
});
