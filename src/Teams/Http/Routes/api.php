<?php

use MetricsWave\Teams\Http\Controllers\Api\AcceptTeamInviteController;
use MetricsWave\Teams\Http\Controllers\Api\DeleteTeamInviteController;
use MetricsWave\Teams\Http\Controllers\Api\DeleteUserFromTeamController;
use MetricsWave\Teams\Http\Controllers\Api\GetTeamInviteController;
use MetricsWave\Teams\Http\Controllers\Api\GetTeamsController;
use MetricsWave\Teams\Http\Controllers\Api\PostTeamInviteController;
use MetricsWave\Teams\Http\Controllers\Api\PutTeamsController;

Route::get('/teams', GetTeamsController::class);
Route::put('/teams/{team}', PutTeamsController::class);

Route::delete('/teams/{team}/users/{user}', DeleteUserFromTeamController::class);

Route::get('/teams/{team}/invites', GetTeamInviteController::class);
Route::post('/teams/{team}/invites', PostTeamInviteController::class);
Route::delete('/teams/{team}/invites/{invite}', DeleteTeamInviteController::class);
Route::post('/teams/{team}/invites/{invite:token}/accept', AcceptTeamInviteController::class);
