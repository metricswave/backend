<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\Api\Auth\SignUpController;
use App\Http\Controllers\Tally\PostTallyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth
Route::post('/signup', SignUpController::class);
Route::post('/login', LoginController::class);
Route::post('/refresh', RefreshTokenController::class);

// Tally
Route::post('/tally', PostTallyController::class);
