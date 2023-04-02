<?php

use App\Models\User;

it('successfully logs out a user', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    $tokens = $user->createTokens('test');

    $this
        ->postJson(
            '/api/logout',
            [
                'device_name' => 'test',
            ],
            [
                'Authorization' => 'Bearer ' . $tokens['refresh_token']['token'],
            ]
        )
        ->assertSuccessful();

    $this->assertCount(0, $user->tokens);
});
