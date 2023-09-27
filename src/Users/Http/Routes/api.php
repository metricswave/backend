<?php

use MetricsWave\Users\Http\Controllers\Api\DeleteUserMarketingMailableFieldController;
use MetricsWave\Users\Http\Controllers\Api\GetUserController;
use MetricsWave\Users\Http\Controllers\Api\GetUserUsageController;
use MetricsWave\Users\Http\Controllers\Api\PostUserDefaultsController;
use MetricsWave\Users\Http\Controllers\Api\UserServices\DeleteUserServiceController;
use MetricsWave\Users\Http\Controllers\Api\UserServices\GetUserServicesController;
use MetricsWave\Users\Http\Controllers\Api\UserServices\PostServiceController;

// User
Route::get('/users', GetUserController::class);
Route::post('/users/defaults', PostUserDefaultsController::class);
Route::get('/users/services', GetUserServicesController::class);
Route::post('/users/services', PostServiceController::class);
Route::delete('/users/services/{userService}', DeleteUserServiceController::class);
Route::delete('/users/marketing_mailable', DeleteUserMarketingMailableFieldController::class);

// Usage
Route::get('/users/usage', GetUserUsageController::class);
