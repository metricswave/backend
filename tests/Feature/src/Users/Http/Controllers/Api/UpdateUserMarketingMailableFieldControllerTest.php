<?php

use App\Models\User;

use function Pest\Laravel\deleteJson;

it('update users marketing_mailable field', function () {
    $email = fake()->email();
    $user = User::factory()->create([
        'email' => $email,
        'marketing_mailable' => true,
    ]);

    deleteJson('api/users/marketing_mailable?token='.md5($email))
        ->assertNoContent();

    expect($user->refresh())->marketing_mailable->toBeFalse();
});

it('return not found if random token', function () {
    User::factory()->create([
        'email' => fake()->email(),
        'marketing_mailable' => true,
    ]);

    deleteJson('api/users/marketing_mailable?token='.md5('random@email.com'))
        ->assertNotFound();
});
