<?php

use MetricsWave\Teams\Http\Controllers\Api\GetTeamsController;
use MetricsWave\Teams\Http\Controllers\Api\PutTeamsController;

Route::get('/teams', GetTeamsController::class);
Route::put('/teams/{team}', PutTeamsController::class);
