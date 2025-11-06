<?php

use App\Jobs\TeamTriggerNotificationJob;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Services\Triggers\MissingTriggerParams;
use App\Services\Triggers\SendWebhookTriggerNotification;
use App\Transfers\TriggerTypeId;
use Illuminate\Support\Facades\Queue;

it('does not require user_id parameter even when it is in trigger configuration', function () {
    [$user, $team] = user_with_team();
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $trigger = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                        'user_id',
                    ],
                ],
            ],
        ]);

    Queue::fake();

    $service = new SendWebhookTriggerNotification();
    $params = [
        'name' => 'Test',
        'content' => 'Test content',
    ];

    expect(fn () => $service($trigger, $params))->not->toThrow(MissingTriggerParams::class);

    Queue::assertPushed(TeamTriggerNotificationJob::class);
});

it('works correctly when user_id is provided even when it is in trigger configuration', function () {
    [$user, $team] = user_with_team();
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $trigger = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                        'user_id',
                    ],
                ],
            ],
        ]);

    Queue::fake();

    $service = new SendWebhookTriggerNotification();
    $params = [
        'name' => 'Test',
        'content' => 'Test content',
        'user_id' => '123',
    ];

    expect(fn () => $service($trigger, $params))->not->toThrow(MissingTriggerParams::class);

    Queue::assertPushed(TeamTriggerNotificationJob::class);
});

it('still throws MissingTriggerParams when required parameters are missing but ignores user_id', function () {
    [$user, $team] = user_with_team();
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $trigger = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                        'user_id',
                    ],
                ],
            ],
        ]);

    Queue::fake();

    $service = new SendWebhookTriggerNotification();
    $params = [
        'name' => 'Test',
    ];

    expect(fn () => $service($trigger, $params))->toThrow(MissingTriggerParams::class);

    Queue::assertNothingPushed();
});
