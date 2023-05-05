<?php

namespace App\Providers;

use App\Console\Commands\StatamicInstallCommand;
use App\Services\Weather\OpenMeteoWeatherForecastGetter;
use App\Services\Weather\WeatherForecastGetter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend('command.statamic.install', function () {
            return new StatamicInstallCommand();
        });

        $this->app->bind(
            WeatherForecastGetter::class,
            OpenMeteoWeatherForecastGetter::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
