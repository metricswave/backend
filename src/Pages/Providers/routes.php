<?php

use App\Http\Middleware\SetLocale;
use MetricsWave\Pages\Http\Controllers\GetUpgradePageController;

$localizedRoutes = function () {
    Route::get('/upgrade/{teamId}', GetUpgradePageController::class);
};

Route::group(
    [
        'prefix' => '{locale?}',
        'where' => ['locale' => 'es'],
        'middleware' => [SetLocale::class],
    ],
    $localizedRoutes
);

$localizedRoutes();
