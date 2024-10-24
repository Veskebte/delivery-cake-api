<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::group(['middleware' => 'auth:sanctum'], function () {
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

    Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus']);
// });

//
