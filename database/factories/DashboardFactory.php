<?php

namespace Database\Factories;

use App\Models\Dashboard;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'items' => [
                [
                    'eventUuid' => $this->faker->uuid,
                    'title' => $this->faker->word,
                    'size' => $this->faker->randomElement(['base', 'large']),
                    'type' => $type,
                    ...($type === 'parameter' ? ['parameter' => $this->faker->word] : [])
                ],
            ],
        ];
    }
}
