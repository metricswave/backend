<?php

namespace Database\Factories;

use App\Models\MailLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MailLog>
 */
class MailLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mail' => $this->faker->email,
            'type' => $this->faker->randomElement(['lead', 'price']),
        ];
    }
}
