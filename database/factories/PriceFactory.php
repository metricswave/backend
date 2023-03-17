<?php

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Price>
 */
class PriceFactory extends Factory
{
    public function definition(): array
    {
        $totalAvailable = $this->faker->numberBetween(15, 100);

        return [
            'price' => $this->faker->numberBetween(950, 3950),
            'remaining' => $this->faker->numberBetween(0, $totalAvailable),
            'total_available' => $totalAvailable,
        ];
    }
}
