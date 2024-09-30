<?php

use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rute untuk mendapatkan informasi pengguna
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

<<<<<<< Updated upstream
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('cakes', CakeController::class);
    Route::apiResource('orders', OrderController::class);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
=======
// Rute untuk cakes
Route::apiResource('cakes', CakeController::class);

// Rute untuk orders
Route::apiResource('orders', OrderController::class);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

// Rute untuk mendapatkan penjualan berdasarkan tanggal
Route::post('/sales-by-date', [OrderController::class, 'getSalesByDate']);

// Rute untuk mendapatkan penjualan berdasarkan bulan
Route::post('/sales-by-month', [OrderController::class, 'getSalesByMonth']);
>>>>>>> Stashed changes
