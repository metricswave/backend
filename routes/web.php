<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Checkout\GetCheckoutController;
use App\Http\Controllers\Checkout\GetCheckoutCreatingLeadController;
use App\Http\Controllers\Lead\GetLeadController;
use App\Http\Controllers\Lead\PostLeadController;
use App\Http\Controllers\Open\GetOpenPageController;
use App\Http\Controllers\Trigger\GetWebhookTriggerController;
use App\Http\Controllers\Trigger\PostWebhookTriggerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing page routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');
Route::view('/roadmap', 'roadmap');
Route::get('/blog', BlogController::class);
Route::get('/blog/category/{slug}', CategoryController::class);

// Use case landings
Route::view('/trigger/deployments-notification', 'trigger.deployments', [
    'title' => 'Deployments notifications',
    'meta_description' => 'Receive a notification when your deployments finish. You can receive a notification in any device or app like Telegram, for example.',
]);
Route::view('/trigger/terminal', 'trigger.terminal', [
    'title' => 'Terminal notifications',
    'meta_description' => 'Your terminal has become smarter and more productive. Receive a notification when a long command finish in all your devices.',
]);
Route::view('/trigger/medication-reminder', 'trigger.medication-reminder', [
    'title' => 'Remember to take your Medication',
    'meta_description' => 'Never forget to take your medication again. Thanks to the on-time notifications you can receive a notification at the exact time, on the days you want.',
]);
Route::view('/trigger/weather-summary', 'trigger.weather-summary', [
    'title' => 'Weather Summary notifications',
    'meta_description' => 'Receive a summary of the weather forecast for the next day. You can receive a notification in any device or app like Telegram, for example.',
]);


Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-and-conditions', 'terms-and-conditions');

// Open page metrics
Route::get('/open', GetOpenPageController::class);

// Leads
Route::view('/leads', 'leads');
Route::get('/leads/{lead:uuid}', GetLeadController::class);
Route::post('/leads', PostLeadController::class);

// Prices
Route::get('/leads/create/prices/{price}', GetCheckoutCreatingLeadController::class);
Route::get('/leads/{lead:uuid}/prices/{price}', GetCheckoutController::class);

// Webhooks notification
Route::get('/webhooks/{trigger:uuid}', GetWebhookTriggerController::class);
Route::post('/webhooks/{trigger:uuid}', PostWebhookTriggerController::class);
