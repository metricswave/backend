<?php

namespace App\Providers;

use App\Console\Commands\StatamicInstallCommand;
use App\Services\Calendar\CalendarGetter;
use App\Services\Calendar\EventsGetter;
use App\Services\Calendar\GoogleCalendarEventsGetter;
use App\Services\Calendar\GoogleCalendarGetter;
use App\Services\TravelDistance\GoogleTravelDistanceCalculator;
use App\Services\TravelDistance\TravelDistanceCalculator;
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

        $this->app->bind(
            TravelDistanceCalculator::class,
            GoogleTravelDistanceCalculator::class,
        );

        $this->app->bind(
            CalendarGetter::class,
            GoogleCalendarGetter::class,
        );

        $this->app->bind(
            EventsGetter::class,
            GoogleCalendarEventsGetter::class,
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
