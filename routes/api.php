<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HotelBookingController;
use App\Http\Controllers\Api\MoneyTransferController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // Public Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/otp/send', [AuthController::class, 'sendOtp']);
    Route::post('/login/otp/verify', [AuthController::class, 'verifyOtp']);
    Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);

    // Public Search & Details
    Route::get('/flights/search', [FlightController::class, 'search']);
    Route::get('/flights/details/{id}', [FlightController::class, 'details']);
    Route::get('/hotels/search', [HotelController::class, 'search']);
    Route::get('/hotels/details/{code}', [HotelController::class, 'details']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Protected Actions
        Route::post('/flights/book', [FlightController::class, 'book']);
        Route::get('/flights/bookings', [FlightController::class, 'bookings']);
        Route::post('/hotel/book', [HotelBookingController::class, 'book']);
        Route::get('/hotels/bookings', [HotelController::class, 'bookings']);
    });

    // Other APIs (Legacy/Utility)
    Route::get('/get-exchange-rate', [MoneyTransferController::class, 'getExchangeRate']);
    Route::get('/get-providers', [MoneyTransferController::class, 'getProviders']);
    Route::post('/create-transfer', [MoneyTransferController::class, 'createTransfer']);
    Route::post('/webhook/payment-status', [MoneyTransferController::class, 'handleWebhook']);
});

