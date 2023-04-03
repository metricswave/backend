<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RefreshTokenControllerController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\SignUpController;
use App\Http\Controllers\Api\Services\GetServicesController;
use App\Http\Controllers\Api\Socialite\RedirectToDriverController;
use App\Http\Controllers\Api\Socialite\StoreUserServiceController;
use App\Http\Controllers\Api\Triggers\GetTriggersController;
use App\Http\Controllers\Api\TriggerTypes\GetTriggerTypesController;
use App\Http\Controllers\Api\Users\GetUserController;
use App\Http\Controllers\Api\UserServices\GetUserServicesController;
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
Route::post('/logout', LogoutController::class);
Route::post('/forgot-password', ForgotPasswordController::class);
Route::post('/reset-password', ResetPasswordController::class);
Route::post('/refresh', RefreshTokenControllerController::class);

// User
Route::get('/users', GetUserController::class);
Route::get('/users/services', GetUserServicesController::class);

// Trigger types
Route::get('/trigger-types', GetTriggerTypesController::class);

// Triggers
Route::get('/triggers', GetTriggersController::class);

// Services
Route::get('/services', GetServicesController::class);

// Tally
Route::post('/tally', PostTallyController::class);

// Socialite
Route::get('/auth/{service:driver}/redirect', RedirectToDriverController::class);
Route::get('/auth/{service:driver}/callback', StoreUserServiceController::class);
