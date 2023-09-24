<?php

namespace Database\Factories\MetricsWave\Channels;

use Illuminate\Database\Eloquent\Factories\Factory;
use MetricsWave\Channels\TeamChannel;

/**
 * @extends Factory<TeamChannel>
 */
class TeamChannelFactory extends Factory
{
    protected $model = TeamChannel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => fake()->randomNumber(),
            'channel_id' => fake()->randomNumber(),
            'data' => [
                'id' => $this->faker->randomNumber(),
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
            ],
        ];
    }
}
