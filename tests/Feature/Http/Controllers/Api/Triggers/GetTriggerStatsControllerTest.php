<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('return expected array list', function () {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create();

    $trigger->visits()->increment(1);

    actingAs($trigger->user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/stats')
        ->dump()
        ->assertSuccessful();
});
