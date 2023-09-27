<?php

use MetricsWave\Users\User;

it('successfully logs out a user', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $this
        ->actingAs($user)
        ->postJson(
            '/api/logout',
            [
                'device_name' => 'test',
            ],
        )
        ->assertSuccessful();

    $this->assertCount(0, $user->tokens);
});

it('return error if no auth provided')
    ->postJson(
        '/api/logout',
        [
            'device_name' => 'test',
        ],
    )
    ->assertUnauthorized();
