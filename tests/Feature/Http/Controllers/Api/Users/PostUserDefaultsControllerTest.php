<?php

use App\Models\TriggerType;
use App\Models\User;
use App\Transfers\TriggerTypeId;

use function Pest\Laravel\actingAs;

it('create expected triggers, dashboards and team', function () {
    $user = User::factory()->create();
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook]);

    actingAs($user)->postJson('/api/users/defaults')->assertCreated();

    expect($user->ownedTeams()->count())->toBe(1)
        ->and($user->ownedTeams()->first()->triggers()->count())->toBe(1)
        ->and($user->ownedTeams()->first()->dashboards()->count())->toBe(1);
});
