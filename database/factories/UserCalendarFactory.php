<?php

namespace Database\Factories;

use App\Models\UserCalendar;
use App\Transfers\ServiceId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserCalendar>
 */
class UserCalendarFactory extends Factory
{
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
