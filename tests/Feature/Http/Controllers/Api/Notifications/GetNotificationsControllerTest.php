<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Notifications\TriggerNotification;

use function Pest\Laravel\actingAs;

it('return a expected list of user notifications', function () {
    [$user, $team] = user_with_team();
    $triggerType = TriggerType::factory()->create();

    foreach (Trigger::factory()->for($team)->for($triggerType)->count(3)->create() as $trigger) {
        $user->notify(new TriggerNotification($trigger));
    }

    actingAs($user)
        ->getJson('/api/teams/'.$team->id.'/notifications')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonFragment([
            'title' => $user->notifications->first()->data['title'],
            'content' => $user->notifications->first()->data['content'],
            'emoji' => $user->notifications->first()->data['emoji'],
            'trigger_id' => $user->notifications->first()->data['trigger_id'],
            'trigger_type_id' => $user->notifications->first()->data['trigger_type_id'],
        ]);
});
