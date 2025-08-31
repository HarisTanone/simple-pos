<?php

use App\Http\Controllers\Api\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/available', [TableController::class, 'available']);
Route::get('/tables/{id}', [TableController::class, 'show']);
