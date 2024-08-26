<?php

use App\Http\Middleware\SetLocale;
use MetricsWave\Pages\Http\Controllers\GetUpgradePageController;
use MetricsWave\Pages\Http\Controllers\GetUpgradingPageController;

$localizedRoutes = function () {
    Route::get('/upgrade/{teamId}', GetUpgradePageController::class);
    Route::get('/upgrading/{teamId}', GetUpgradingPageController::class);
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
