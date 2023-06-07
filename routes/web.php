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
Route::view('/trigger/monitoring', 'trigger.monitoring', [
    'title' => 'Real-time monitoring for your apps',
    'meta_description' => 'Track every inch of your product, monitor potential issues or opportunities, and respond by making data-driven decisions.',
]);
Route::view('/trigger/calendar-time-to-leave', 'trigger.calendar-ttl', [
    'title' => 'Calendar Time To Leave notifications',
    'meta_description' => 'Receive a notification when it is time to leave for your next event. You can receive a notification in any device or app like Telegram, for example.',
]);
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
Route::view('/trigger/time-to-leave', 'trigger.time-to-leave', [
    'title' => 'Time to leave notifications based on traffic',
    'meta_description' => 'Receive a notification when it is time to leave to arrive on time to your destination. You can receive a notification in any device or apps like Telegram, for example.',
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
Route::view('/payment/success', 'payment.success');

// Webhooks notification
Route::get('/webhooks/{trigger:uuid}', GetWebhookTriggerController::class);
Route::post('/webhooks/{trigger:uuid}', PostWebhookTriggerController::class);
