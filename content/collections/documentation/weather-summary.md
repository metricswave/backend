---
id: f5b693af-4344-4655-969d-ce511d04f435
blueprint: documentation
title: 'Triggers: Weather Summary'
short_content: "Receive a daily summary of today's weather with all the information. You can configure the notification the way you want."
parent: 3826e861-c213-4482-8ab7-0e3add2a4d7f
updated_by: 1
updated_at: 1683054177
---
**Receive a daily summary of today's weather with all the information. You can configure the notification the way you want.**

<div id="available-data" style="scroll-margin-top: 2em;"></div>

### Available data for your title and content

You can add dynamic variables to the title and content of your notification. In this weather trigger we have all of this:

#### {weather.condition}
Display current weather condition. Example: "Clear sky", "Rain: Moderate intensity" or "Snow grains".

#### {weather.temperature2m_max}
Display current weather max temperature for that day.

#### {weather.temperature2m_min}
Display current weather min temperature for that day.

#### {weather.apparent_temperature_max}
Display current weather apparent max temperature.

#### {weather.apparent_temperature_min}
Display current weather apparent min temperature.

#### {weather.sunrise}
Display sunrise time. 

#### {weather.sunset}
Display sunset time.

#### {weather.uv_index_max}
Display max UV index.

#### {weather.uv_index_clear_sky_max}
Display min UV index.

#### {weather.precipitation_sum}
Display total presipitation on current day. 

#### {weather.rain_sum}
Display current weather rain sum.

#### {weather.showers_sum}
Display current weather showers sum.

#### {weather.snowfall_sum}
Display current weather snowfall sum.

#### {weather.precipitation_hours}
Display weather precipitation hours. 

#### {weather.precipitation_probability_max}
Display max probability of precipitations.

#### {weather.wind_speed10m_max}
Display max wind speed 

#### {weather.wind_gusts10m_max}
Display max wind gusts. 

#### {weather.wind_direction10m_dominant}
Display dominant wind direction.

#### {weather.shortwave_radiation_sum}
Display radiation sum

#### {weather.et0_fao_evapotranspiration}
Display fao evopatranspiration