<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ShippingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Payments
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/payments/initiate', [PaymentController::class, 'initiate']);
    Route::get('/payments/enquiry/{paymentId}', [PaymentController::class, 'enquiry']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Shipments CRUD
    Route::get('/shipments', [ShippingController::class, 'index']);
    Route::post('/shipments', [ShippingController::class, 'store']);
    Route::get('/shipments/{id}', [ShippingController::class, 'show']);
    Route::put('/shipments/{id}', [ShippingController::class, 'update']);
    Route::delete('/shipments/{id}', [ShippingController::class, 'destroy']);

    // Deliveries CRUD
    Route::get('/deliveries', [DeliveryController::class, 'index']);
    Route::post('/deliveries', [DeliveryController::class, 'store']);
    Route::get('/deliveries/{id}', [DeliveryController::class, 'show']);
    Route::put('/deliveries/{id}', [DeliveryController::class, 'update']);
    Route::delete('/deliveries/{id}', [DeliveryController::class, 'destroy']);
});
