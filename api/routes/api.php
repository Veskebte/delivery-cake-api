<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('cakes', CakeController::class);
Route::apiResource('orders', OrderController::class);

Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
