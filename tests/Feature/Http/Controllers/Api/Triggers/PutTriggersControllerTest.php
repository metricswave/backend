<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use MetricsWave\Users\User;

it('updates a trigger', function () {
    [$user, $team] = user_with_team();
    $triggerType = TriggerType::factory()->create();
    /** @var Trigger $trigger */
    $trigger = Trigger::factory()->for($team)->for($triggerType)->create();

    $this
        ->actingAs($user)
        ->putJson("/api/triggers/{$trigger->uuid}", [
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
            'via' => [
                [
                    'id' => 0,
                    'label' => 'Mail',
                    'checked' => true,
                    'type' => 'mail',
                ],
            ],
        ])->assertNoContent();

    $this->assertDatabaseHas('triggers', [
        'uuid' => $trigger->uuid,
        'team_id' => $team->id,
        'emoji' => '👍',
        'title' => 'Test Trigger',
        'content' => 'This is a test trigger',
        'via' => cast_to_json([
            [
                'id' => 0,
                'label' => 'Mail',
                'checked' => true,
                'type' => 'mail',
            ],
        ]),
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
        ->putJson("/api/triggers/{$trigger->uuid}", [
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
        ])->assertForbidden();
});
