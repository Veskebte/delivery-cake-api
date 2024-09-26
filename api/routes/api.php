<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/cakes', [CakeController::class, 'index']);
Route::post('/cakes', [CakeController::class, 'store']);
Route::get('/cakes/{id}', [CakeController::class, 'show']);
Route::put('/cakes/{id}', [CakeController::class, 'update']);
Route::delete('/cakes/{id}', [CakeController::class, 'destroy']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']); 
