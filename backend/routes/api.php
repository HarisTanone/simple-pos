<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\TableController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/tables', [TableController::class, 'index']);
    Route::get('/tables/available', [TableController::class, 'available']);
    Route::get('/tables/{id}', [TableController::class, 'show']);

    Route::apiResource('foods', FoodController::class);
    Route::get('/foods/category/{category}', [FoodController::class, 'category']);
});
