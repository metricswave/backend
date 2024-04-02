<?php

namespace Database\Factories;

use App\Models\Dashboard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Dashboard>
 */
class DashboardFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['stats', 'parameter']);

        return [
            'name' => $this->faker->word,
            'uuid' => Str::random(15),
            'public' => $this->faker->boolean,
            'items' => [
                [
                    'eventUuid' => $this->faker->uuid,
                    'title' => $this->faker->word,
                    'size' => $this->faker->randomElement(['base', 'large']),
                    'type' => $type,
                    ...($type === 'parameter' ? ['parameter' => $this->faker->word] : []),
                ],
            ],
        ];
    }
}
