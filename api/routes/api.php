<?php

use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('cakes', CakeController::class);
    Route::apiResource('orders', OrderController::class);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
