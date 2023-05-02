<?php

namespace App\Providers;

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
