<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;

it('delete a trigger', function () {
    $user = User::factory()->create();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($user)->for($triggerType)->create();

    $this
        ->actingAs($user)
        ->deleteJson("/api/triggers/{$trigger->uuid}", [])
        ->assertNoContent();

    $this->assertDatabaseMissing('triggers', [
        'uuid' => $trigger->uuid,
        'user_id' => $user->id,
        'deleted_at' => null,
    ]);
});

it('check that the user is the owner of the trigger', function () {
    $user = User::factory()->create();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($user)->for($triggerType)->create();

    $otherUser = User::factory()->create();

    $this
        ->actingAs($otherUser)
        ->putJson("/api/triggers/{$trigger->uuid}")
        ->assertForbidden();
});
