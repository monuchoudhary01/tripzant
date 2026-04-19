<?php
use App\Http\Controllers\Api\HotelBookingController;
Route::middleware('auth:sanctum')->post('/hotel/book', [HotelBookingController::class, 'book']);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\MoneyTransferController;

Route::get('/get-exchange-rate', [MoneyTransferController::class, 'getExchangeRate']);
Route::get('/get-providers', [MoneyTransferController::class, 'getProviders']);
Route::post('/create-transfer', [MoneyTransferController::class, 'createTransfer']);
Route::post('/webhook/payment-status', [MoneyTransferController::class, 'handleWebhook']);

