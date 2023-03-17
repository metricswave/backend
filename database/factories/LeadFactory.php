<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        $paidUser = $this->faker->boolean;
        $paidPrice = $paidUser ? $this->faker->numberBetween(950, 3000) : 0;
        $paidAt = $paidUser ? $this->faker->dateTimeBetween('-1 year', 'now') : null;

        return [
            'uuid' => $this->faker->uuid,
            'email' => $this->faker->email,
            'paid_price' => $paidPrice,
            'paid_at' => $paidAt,
        ];
    }
}
