<?php

namespace Database\Factories\MetricsWave\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MetricsWave\Teams\TeamInvite;

/**
 * @extends Factory<TeamInvite>
 */
class TeamInviteFactory extends Factory
{
    protected $model = TeamInvite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => 1,
            'email' => $this->faker->email,
            'token' => Str::random(15),
        ];
    }
}
