<?php

namespace Database\Factories\MetricsWave\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use MetricsWave\Teams\Team;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'domain' => fake()->domainName(),
        ];
    }
}
