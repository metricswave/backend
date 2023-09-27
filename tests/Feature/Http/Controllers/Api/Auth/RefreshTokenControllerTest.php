<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('return a new token', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    $tokens = $user->createTokens('test');

    $this
        ->postJson(
            '/api/refresh',
            [
                'device_name' => 'test',
            ],
            [
                'Authorization' => 'Bearer '.$tokens['refresh_token']['token'],
            ]
        )
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->hasAll([
                'data.token.token',
                'data.token.expires_at',
                'data.refresh_token.token',
                'data.refresh_token.expires_at',
            ])
        );

    $this->assertCount(2, $user->tokens);
});

it('return error if not using the refresh token', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    $tokens = $user->createTokens('test');

    $this
        ->postJson(
            '/api/refresh',
            [
                'device_name' => 'test',
            ],
            [
                'Authorization' => 'Bearer '.$tokens['token']['token'],
            ]
        )
        ->assertForbidden();
});

it('return error if no auth provided')
    ->postJson(
        '/api/refresh',
        [
            'device_name' => 'test',
        ],
    )
    ->assertUnauthorized();
