<?php

namespace Database\Factories;

use App\Models\Trigger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trigger>
 */
class TriggerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'trigger_type_id' => fake()->numberBetween(1, 10),
            'uuid' => fake()->uuid,
            'emoji' => fake()->emoji,
            'title' => fake()->word,
            'content' => fake()->sentence,
            'configuration' => json_encode([
                'version' => '1.0.0',
                'fields' => [
                    [
                        'name' => 'message',
                        'value' => fake()->sentence,
                    ],
                ],
            ]),
        ];
    }
}
