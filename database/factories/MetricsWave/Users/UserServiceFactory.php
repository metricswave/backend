<?php

namespace Database\Factories\MetricsWave\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use MetricsWave\Users\User;
use MetricsWave\Users\UserService;

/**
 * @extends Factory<UserService>
 */
class UserServiceFactory extends Factory
{
    protected $model = UserService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_id' => $this->faker->randomNumber(),
            'service_data' => [
                'id' => $this->faker->randomNumber(),
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
            ],
        ];
    }
}
