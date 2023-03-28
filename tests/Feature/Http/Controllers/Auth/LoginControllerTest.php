<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\postJson;

it("return expected response", function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'test',
    ])
        ->assertStatus(200)
        ->assertJson(fn(AssertableJson $json) => $json
            ->hasAll(['token', 'refresh_token'])
        );
});

it('return http status 400 if invalid login', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    postJson('/api/login', [
        'email' => $user->email,
        'password' => 'invalid_password',
        'device_name' => 'test',
    ])
        ->assertStatus(401)
        ->assertJson(fn(AssertableJson $json) => $json
            ->hasAll(['message'])
        );
});


