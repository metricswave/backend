<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Checkout\GetCheckoutController;
use App\Http\Controllers\Checkout\GetCheckoutCreatingLeadController;
use App\Http\Controllers\Checkout\GetCheckoutPlanCreatingLeadController;
use App\Http\Controllers\Lead\GetLeadController;
use App\Http\Controllers\Lead\PostLeadController;
use App\Http\Controllers\Open\GetOpenPageController;
use App\Http\Controllers\Trigger\GetWebhookTriggerController;
use App\Http\Controllers\Trigger\PostWebhookTriggerController;
use App\Http\Middleware\RedirectOldNotifyWaveDomain;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Entry;

/*
|--------------------------------------------------------------------------
| Landing page routes
|--------------------------------------------------------------------------
*/

Route::middleware(RedirectOldNotifyWaveDomain::class)->group(function () {
    Route::get('/', function () {
        return view('welcome', [
            'page' => Entry::query()->where('slug', 'landing')->first(),
        ]);
    });
    Route::permanentRedirect('/roadmap', '/');
    Route::get('/blog', BlogController::class);
    Route::get('/blog/category/{slug}', CategoryController::class);

    // Use case landings
    Route::permanentRedirect('/trigger/monitoring', '/');
    Route::permanentRedirect('/trigger/calendar-time-to-leave', '/');
    Route::permanentRedirect('/trigger/deployments-notification', '/');
    Route::permanentRedirect('/trigger/terminal', '/');
    Route::permanentRedirect('/trigger/medication-reminder', '/');
    Route::permanentRedirect('/trigger/weather-summary', '/');
    Route::permanentRedirect('/trigger/time-to-leave', '/');


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

    // Blog redirections
    Route::permanentRedirect(
        '/blog/google-analytics-is-blocked-by-more-than-50-of-tech-sites-audientes',
        '/blog/50-of-tech-sites-traffic-is-blocking-google-analytics'
    );
});

// Webhooks notification
Route::get('/webhooks/{trigger:uuid}', GetWebhookTriggerController::class);
Route::post('/webhooks/{trigger:uuid}', PostWebhookTriggerController::class);
