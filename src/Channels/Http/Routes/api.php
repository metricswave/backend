<?php

use MetricsWave\Channels\Http\Controllers\Api\DeleteTeamChannelController;
use MetricsWave\Channels\Http\Controllers\Api\GetChannelsController;
use MetricsWave\Channels\Http\Controllers\Api\GetTeamChannelsController;
use MetricsWave\Channels\Http\Controllers\Api\PostTeamChannelsController;

Route::get('/channels', GetChannelsController::class);

Route::get('/teams/{team}/channels', GetTeamChannelsController::class);
Route::post('/teams/{team}/channels', PostTeamChannelsController::class);
Route::delete('/teams/{team}/channels/{channel}', DeleteTeamChannelController::class);
