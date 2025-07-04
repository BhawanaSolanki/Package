<?php

use Illuminate\Support\Facades\Route;
use Bhawana\SchoolPay\Http\Controllers\PaymentController;


Route::middleware(['api', 'auth:sanctum'])->prefix('SchoolPay')->group(function () {
    Route::post('/payment', [PaymentController::class, 'createPayment'])->name('SchoolPay.payment.create');
    Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('SchoolPay.payment.verify');
    Route::get('/status/{paymentId}', [PaymentController::class, 'getStatus'])->name('SchoolPay.payment.status');
});
