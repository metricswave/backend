---
id: f5b693af-4344-4655-969d-ce511d04f435
blueprint: documentation
title: 'Triggers: Weather Summary'
short_content: "Receive a daily summary of today's weather with all the information. You can configure the notification the way you want."
parent: 3826e861-c213-4482-8ab7-0e3add2a4d7f
updated_by: 1
updated_at: 1683196702
---
**Receive a daily summary of today's weather with all the information. You can configure the notification the way you want.**

<div id="available-data" style="scroll-margin-top: 2em;"></div>

### Available data for your title and content

You can add dynamic variables to the title and content of your notification. 

You can use `{weather.today.xxx}` or `{weather.tomorrow.xxx}` to get the forecast for the desire day.

In this weather trigger we have all of this:

#### {weather.today.condition}

Display current weather.today.condition. Example: "Clear sky", "Rain: Moderate intensity" or "Snow grains".

#### {weather.today.temperature2m_max}

Display current weather.today.max temperature for that day.

#### {weather.today.temperature2m_min}

Display current weather.today.min temperature for that day.

#### {weather.today.apparent_temperature_max}

Display current weather.today.apparent max temperature.

#### {weather.today.apparent_temperature_min}

Display current weather.today.apparent min temperature.

#### {weather.today.sunrise}

Display sunrise time.

#### {weather.today.sunset}

Display sunset time.

#### {weather.today.uv_index_max}

Display max UV index.

#### {weather.today.uv_index_clear_sky_max}

Display min UV index.

#### {weather.today.precipitation_sum}

Display total presipitation on current day.

#### {weather.today.rain_sum}

Display current weather.today.rain sum.

#### {weather.today.showers_sum}

Display current weather.today.showers sum.

#### {weather.today.snowfall_sum}

Display current weather.today.snowfall sum.

#### {weather.today.precipitation_hours}

Display weather.today.precipitation hours.

#### {weather.today.precipitation_probability_max}

Display max probability of precipitations.

#### {weather.today.wind_speed10m_max}

Display max wind speed

#### {weather.today.wind_gusts10m_max}

Display max wind gusts.

#### {weather.today.wind_direction10m_dominant}

Display dominant wind direction.

#### {weather.today.shortwave_radiation_sum}

Display radiation sum

#### {weather.today.et0_fao_evapotranspiration}

Display fao evopatranspiration

---

[← More about triggers](/documentation/triggers/)