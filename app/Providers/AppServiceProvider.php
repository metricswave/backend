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
use Laravel\Cashier\Cashier;
use MetricsWave\Teams\Team;
use Njed\Toc\Extensions\CommonMark\TitleAnchorIdExtension;
use Statamic\Facades\Markdown;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Team::class);

        Markdown::addExtension(function () {
            return new TitleAnchorIdExtension();
        });
    }
}
