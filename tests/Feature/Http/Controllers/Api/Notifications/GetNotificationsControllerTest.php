<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Notifications\TriggerNotification;
use Illuminate\Support\Carbon;
use MetricsWave\Teams\Team;

use function Pest\Laravel\actingAs;

$sendNotifications = function (User $user, Team $team) {
    $triggerType = TriggerType::factory()->create();

    foreach (Trigger::factory()->for($team)->for($triggerType)->count(3)->create() as $k => $trigger) {
        $user->notify(new TriggerNotification($trigger, [
            'user' => 'user_'.$k,
        ]));
    }
};

it('return a expected list of user notifications', function () use ($sendNotifications) {
    Carbon::setTestNow(now());
    DB::connection('visits')->table('notifications_'.now()->year)->truncate();

    [$user, $team] = user_with_team();
    $sendNotifications($user, $team);

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

it('return a expected list of user notifications while filtering by user_parameter', function () use ($sendNotifications) {
    Carbon::setTestNow(now());
    DB::connection('visits')->table('notifications_'.now()->year)->truncate();

    [$user, $team] = user_with_team();
    $sendNotifications($user, $team);

    actingAs($user)
        ->getJson('/api/teams/'.$team->id.'/notifications?user_parameter=user_1')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});
