<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;


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
