<?php

namespace Database\Factories;

use App\Models\TriggerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TriggerType>
 */
class TriggerTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'description' => fake()->sentence,
            'icon' => fake()->word,
            'configuration' => json_encode([
                'version' => '1.0.0',
                'fields' => [
                    [
                        'name' => 'message',
                        'type' => 'input',
                        'description' => 'The message to send',
                    ],
                ],
            ]),
        ];
    }
}
