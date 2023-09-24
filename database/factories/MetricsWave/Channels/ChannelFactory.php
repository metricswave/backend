<?php

namespace Database\Factories\MetricsWave\Channels;

use Illuminate\Database\Eloquent\Factories\Factory;
use MetricsWave\Channels\Channel;

/**
 * @extends Factory<Channel>
 */
class ChannelFactory extends Factory
{
    protected $model = Channel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'driver' => $this->faker->randomElement(['telegram', 'slack', 'discord']),
            'description' => $this->faker->sentence,
            'configuration' => [
                'token' => $this->faker->word,
                'channel' => $this->faker->word,
            ],
        ];
    }
}
