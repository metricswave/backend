<?php

namespace App\Services\Weather;

interface WeatherForecastGetter
{
    public function daily(Location $location): WeatherForecasts;
}
