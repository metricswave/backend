<?php

use App\Http\Controllers\Checkout\GetCheckoutController;
use App\Http\Controllers\Lead\GetLeadController;
use App\Http\Controllers\Lead\PostLeadController;
use App\Http\Controllers\Tally\PostTallyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-and-conditions', 'terms-and-conditions');

// Leads
Route::get('/lead/{lead:uuid}', GetLeadController::class);
Route::post('/lead', PostLeadController::class);

// Prices
Route::get('/lead/{lead:uuid}/price/{price}', GetCheckoutController::class);

// Tally
Route::post('/tally', PostTallyController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
