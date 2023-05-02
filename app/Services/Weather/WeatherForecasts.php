<?php

namespace App\Services\Weather;

class WeatherForecasts
{
    /**
     * @param  array<WeatherForecast>  $forecasts
     */
    public function __construct(
        public readonly array $forecasts,
    ) {
    }

    /**
     * @return array{array{
     *     code: int,
     *     condition: string,
     *     temperature2m_max: float,
     *     temperature2m_min: float,
     *     apparent_temperature_max: float,
     *     apparent_temperature_min: float,
     *     sunrise: string,
     *     sunset: string,
     *     uv_index_max: float,
     *     uv_index_clear_sky_max: float,
     *     precipitation_sum: float,
     *     rain_sum: float,
     *     showers_sum: float,
     *     snowfall_sum: float,
     *     precipitation_hours: float,
     *     precipitation_probability_max: float,
     *     wind_speed_10m_max: float,
     *     wind_gusts_10m_max: float,
     *     wind_direction_10m_dominant: float,
     *     shortwave_radiation_sum: float,
     *     et0_fao_evapotranspiration: float,
     * }}
     */
    public function toArray(): array
    {
        return collect($this->forecasts)
            ->mapWithKeys(function (WeatherForecast $forecast) {
                return [
                    $forecast->key => $forecast->toArray(),
                ];
            })
            ->toArray();
    }
}
