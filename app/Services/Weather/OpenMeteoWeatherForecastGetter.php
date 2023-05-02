<?php

namespace App\Services\Weather;

use Cache;
use Date;
use Http;

class OpenMeteoWeatherForecastGetter implements WeatherForecastGetter
{
    public function daily(Location $location): WeatherForecast
    {
        $data = Cache::remember(
            'weather-forecast-'.$location->latitude.'-'.$location->longitude,
            Date::now()->addHour(),
            fn() => Http::get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'forecast_days' => 1,
                    'daily' => 'weathercode,temperature_2m_max,temperature_2m_min,apparent_temperature_max,apparent_temperature_min,sunrise,sunset,uv_index_max,uv_index_clear_sky_max,precipitation_sum,rain_sum,showers_sum,snowfall_sum,precipitation_hours,precipitation_probability_max,windspeed_10m_max,windgusts_10m_max,winddirection_10m_dominant,shortwave_radiation_sum,et0_fao_evapotranspiration',
                    'timezone' => 'auto',
                ]
            )->json()
        );

        return new WeatherForecast(
            $location,
            $data['daily']['weathercode'][0],
            $data['daily']['temperature_2m_max'][0],
            $data['daily']['temperature_2m_min'][0],
            $data['daily']['apparent_temperature_max'][0],
            $data['daily']['apparent_temperature_min'][0],
            $data['daily']['sunrise'][0],
            $data['daily']['sunset'][0],
            $data['daily']['uv_index_max'][0],
            $data['daily']['uv_index_clear_sky_max'][0],
            $data['daily']['precipitation_sum'][0],
            $data['daily']['rain_sum'][0],
            $data['daily']['showers_sum'][0],
            $data['daily']['snowfall_sum'][0],
            $data['daily']['precipitation_hours'][0],
            $data['daily']['precipitation_probability_max'][0],
            $data['daily']['windspeed_10m_max'][0],
            $data['daily']['windgusts_10m_max'][0],
            $data['daily']['winddirection_10m_dominant'][0],
            $data['daily']['shortwave_radiation_sum'][0],
            $data['daily']['et0_fao_evapotranspiration'][0],
        );
    }
}
