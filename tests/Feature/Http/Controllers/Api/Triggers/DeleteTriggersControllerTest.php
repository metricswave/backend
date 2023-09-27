<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use MetricsWave\Users\User;

it('delete a trigger', function () {
    [$user, $team] = user_with_team();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($team)->for($triggerType)->create();

    $this
        ->actingAs($user)
        ->deleteJson("/api/triggers/{$trigger->uuid}", [])
        ->assertNoContent();

    $this->assertDatabaseMissing('triggers', [
        'uuid' => $trigger->uuid,
        'team_id' => $team->id,
        'deleted_at' => null,
    ]);
});

it('check that the user is the owner of the trigger', function () {
    [$user, $team] = user_with_team();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($team)->for($triggerType)->create();

    $otherUser = User::factory()->create();

    $this
        ->actingAs($otherUser)
        ->putJson("/api/triggers/{$trigger->uuid}")
        ->assertForbidden();
});
