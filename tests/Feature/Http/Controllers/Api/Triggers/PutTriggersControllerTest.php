<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;

it('updates a trigger', function () {
    $user = User::factory()->create();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($user)->for($triggerType)->create();

    $this
        ->actingAs($user)
        ->putJson("/api/triggers/{$trigger->uuid}", [
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
        ])->assertNoContent();

    $this->assertDatabaseHas('triggers', [
        'uuid' => $trigger->uuid,
        'user_id' => $user->id,
        'emoji' => '👍',
        'title' => 'Test Trigger',
        'content' => 'This is a test trigger',
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
        ->putJson("/api/triggers/{$trigger->uuid}", [
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
        ])->assertForbidden();
});
