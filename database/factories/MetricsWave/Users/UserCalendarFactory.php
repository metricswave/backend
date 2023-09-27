<?php

namespace Database\Factories\MetricsWave\Users;

use App\Transfers\ServiceId;
use Illuminate\Database\Eloquent\Factories\Factory;
use MetricsWave\Users\UserCalendar;

/**
 * @extends Factory<UserCalendar>
 */
class UserCalendarFactory extends Factory
{
    protected $model = UserCalendar::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'service_id' => ServiceId::Google,
            'calendar_id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'background_color' => $this->faker->hexColor,
            'foreground_color' => $this->faker->hexColor,
            'time_zone' => $this->faker->timezone,
        ];
    }
}
