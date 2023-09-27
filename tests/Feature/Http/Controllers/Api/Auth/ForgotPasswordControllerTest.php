<?php

use App\Models\User;
use App\Notifications\ResetPasswordNotification;

use function Pest\Laravel\postJson;

it('send reset password mail', function () {
    Notification::fake();
    $user = User::factory()->create();

    postJson('/api/forgot-password', ['email' => $user->email])
        ->assertSuccessful();

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

it('return error if user not exists')
    ->postJson('/api/forgot-password', ['email' => 'any@email.com'])
    ->assertInvalid(['email' => 'The selected email is invalid.']);
