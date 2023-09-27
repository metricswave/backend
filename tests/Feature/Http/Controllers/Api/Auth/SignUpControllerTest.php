<?php

use App\Models\Lead;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Users\User;

it('return expected response', function () {
    Lead::factory()->create(['email' => 'victoor89@gmail.com', 'paid_at' => now()]);

    $this
        ->postJson('/api/signup', [
            'name' => 'Victor',
            'email' => 'victoor89@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'test',
        ])
        ->assertCreated()
        ->assertJson(fn (AssertableJson $json) => $json
            ->hasAll([
                'data.token.token',
                'data.token.expires_at',
                'data.refresh_token.token',
                'data.refresh_token.expires_at',
            ])
        );
});

it('return error if user is already registered', function () {
    Lead::factory()->create(['email' => 'victoor89@gmail.com', 'paid_at' => now()]);
    User::factory()->create(['email' => 'victoor89@gmail.com']);

    $this
        ->postJson('/api/signup', [
            'name' => 'Victor',
            'email' => 'victoor89@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'test',
        ])
        ->assertInvalid([
            'email' => 'The email has already been taken.',
        ]);
});

it('validates the email', function () {
    $this
        ->postJson('/api/signup', [
            'name' => 'Victor',
            'email' => 'invalid_email',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'test',
        ])
        ->assertInvalid([
            'email' => 'The email field must be a valid email address.',
        ]);
});

it('return error if not password confirmation', function () {
    $this
        ->postJson('/api/signup', [
            'name' => 'Victor',
            'email' => 'victoor89@gmail.com',
            'password' => 'password',
            'device_name' => 'test',
        ])
        ->assertInvalid([
            'password' => 'The password field confirmation does not match.',
        ]);
});
