<?php

namespace App\Services\Weather;

use Date;

class WeatherForecast
{
    private const WMO_CODES = [
        "0" => "Clear sky",
        "1" => "Mainly clear",
        "2" => "Partly cloudy",
        "3" => "Overcast",
        "45" => "Fog",
        "48" => "Depositing rime fog",
        "51" => "Drizzle: Light intensity",
        "53" => "Drizzle: Moderate intensity",
        "55" => "Drizzle: Dense intensity",
        "56" => "Freezing Drizzle: Light intensity",
        "57" => "Freezing Drizzle: Dense intensity",
        "61" => "Rain: Slight intensity",
        "63" => "Rain: Moderate intensity",
        "65" => "Rain: Heavy intensity",
        "66" => "Freezing Rain: Light intensity",
        "67" => "Freezing Rain: Heavy intensity",
        "71" => "Snow fall: Slight intensity",
        "73" => "Snow fall: Moderate intensity",
        "75" => "Snow fall: Heavy intensity",
        "77" => "Snow grains",
        "80" => "Rain showers: Slight intensity",
        "81" => "Rain showers: Moderate intensity",
        "82" => "Rain showers: Violent intensity",
        "85" => "Snow showers: Slight intensity",
        "86" => "Snow showers: Heavy intensity",
        "95" => "Thunderstorm: Slight or moderate",
        "96" => "Thunderstorm with hail: Slight intensity",
        "99" => "Thunderstorm with hail: Heavy intensity"
    ];

    public function __construct(
        public readonly Location $location,
        public readonly int $code,
        public readonly float $temperature2mMax,
        public readonly float $temperature2mMin,
        public readonly float $apparentTemperatureMax,
        public readonly float $apparentTemperatureMin,
        public readonly string $sunrise,
        public readonly string $sunset,
        public readonly float $uvIndexMax,
        public readonly float $uvIndexClearSkyMax,
        public readonly float $precipitationSum,
        public readonly float $rainSum,
        public readonly float $showersSum,
        public readonly float $snowfallSum,
        public readonly float $precipitationHours,
        public readonly float $precipitationProbabilityMax,
        public readonly float $windSpeed10mMax,
        public readonly float $windGusts10mMax,
        public readonly float $windDirection10mDominant,
        public readonly float $shortwaveRadiationSum,
        public readonly float $et0FaoEvapotranspiration,
    ) {
    }

    /**
     * @return array{
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
     * }
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'condition' => $this->condition(),
            'temperature2m_max' => $this->temperature2mMax,
            'temperature2m_min' => $this->temperature2mMin,
            'apparent_temperature_max' => $this->apparentTemperatureMax,
            'apparent_temperature_min' => $this->apparentTemperatureMin,
            'sunrise' => Date::createFromFormat('Y-m-d\TH:i', $this->sunrise)->format('H:i'),
            'sunset' => Date::createFromFormat('Y-m-d\TH:i', $this->sunset)->format('H:i'),
            'uv_index_max' => $this->uvIndexMax,
            'uv_index_clear_sky_max' => $this->uvIndexClearSkyMax,
            'precipitation_sum' => $this->precipitationSum,
            'rain_sum' => $this->rainSum,
            'showers_sum' => $this->showersSum,
            'snowfall_sum' => $this->snowfallSum,
            'precipitation_hours' => $this->precipitationHours,
            'precipitation_probability_max' => $this->precipitationProbabilityMax,
            'wind_speed10m_max' => $this->windSpeed10mMax,
            'wind_gusts10m_max' => $this->windGusts10mMax,
            'wind_direction10m_dominant' => $this->windDirection10mDominant,
            'shortwave_radiation_sum' => $this->shortwaveRadiationSum,
            'et0_fao_evapotranspiration' => $this->et0FaoEvapotranspiration,
        ];
    }

    public function condition(): string
    {
        return self::WMO_CODES[$this->code];
    }
}
