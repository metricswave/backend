<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Checkout\GetCheckoutController;
use App\Http\Controllers\Checkout\GetCheckoutCreatingLeadController;
use App\Http\Controllers\Lead\GetLeadController;
use App\Http\Controllers\Lead\PostLeadController;
use App\Http\Controllers\Open\GetOpenPageController;
use App\Http\Controllers\Trigger\GetWebhookTriggerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing page routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');
Route::view('/roadmap', 'roadmap');
Route::view('/trigger/terminal', 'trigger.terminal');
Route::get('/blog', BlogController::class);
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
