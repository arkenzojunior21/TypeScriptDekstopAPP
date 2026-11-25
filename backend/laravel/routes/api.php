<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/stores', [StoreController::class, 'index']);
Route::get('/stores/{store}', [StoreController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->middleware('role:platform_admin,store_admin');
    Route::get('/customers', [CustomerController::class, 'index'])->middleware('role:platform_admin,store_admin');
    Route::post('/services', [ServiceController::class, 'store'])->middleware('role:platform_admin,store_admin');
    Route::patch('/services/{service}', [ServiceController::class, 'update'])->middleware('role:platform_admin,store_admin');
    Route::patch('/stores/{store}', [StoreController::class, 'update'])->middleware('role:platform_admin,store_admin');
    Route::get('/complaints', [ComplaintController::class, 'index']);
    Route::post('/complaints', [ComplaintController::class, 'store'])->middleware('role:customer');
    Route::patch('/complaints/{complaint}', [ComplaintController::class, 'update'])->middleware('role:platform_admin,store_admin');
    Route::get('/reports/summary', [ReportController::class, 'summary'])->middleware('role:platform_admin,store_admin');
});
