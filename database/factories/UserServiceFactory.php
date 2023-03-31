<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserService>
 */
class UserServiceFactory extends Factory
{
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
