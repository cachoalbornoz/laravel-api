<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;

use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/profile', [AuthController::class, 'profile']);

    Route::get('/users/getall', [UsersController::class, 'getAll']);
});
