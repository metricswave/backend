<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Checkout\GetCheckoutController;
use App\Http\Controllers\Lead\GetLeadController;
use App\Http\Controllers\Lead\PostLeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing page routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');
Route::view('/roadmap', 'roadmap');
Route::get('/blog', BlogController::class);
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-and-conditions', 'terms-and-conditions');

// Leads
Route::get('/leads/{lead:uuid}', GetLeadController::class);
Route::post('/leads', PostLeadController::class);

// Prices
Route::get('/leads/{lead:uuid}/prices/{price}', GetCheckoutController::class);
