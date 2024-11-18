<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Transfers\TriggerTypeId;

use function Pest\Laravel\postJson;

it('send expected notification', function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    [$user, $team] = user_with_team();
    $t = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                    ],
                ],
            ],
        ]);

    Notification::fake();

    postJson(
        '/webhooks/'.$t->uuid,
        [
            'name' => 'Victor',
            'content' => 'Hola',
        ]
    )->assertSuccessful();

    Notification::assertCount(1);
});

it('send expected notification with triggered_at', function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    [$user, $team] = user_with_team();
    $t = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                    ],
                ],
            ],
        ]);

    Notification::fake();

    postJson(
        '/webhooks/'.$t->uuid,
        [
            'name' => 'Victor',
            'content' => 'Hola',
            'triggered_at' => '2021-09-01 12:00:00',
        ]
    )->assertSuccessful();

    Notification::assertCount(1);
});

it("trigger params are updated because it's called from the script", function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    [$user, $team] = user_with_team();
    $t = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                    ],
                ],
            ],
        ]);

    Notification::fake();

    postJson(
        '/webhooks/'.$t->uuid,
        [
            'f' => 'script',
            'name' => 'Victor',
            'content' => 'Hola',
        ]
    )->assertSuccessful();

    $t->refresh();

    expect($t->isVisitsType())->toBeTrue();
    expect($t->configurationParameters())->toMatchArray([
        ...Trigger::VISITS_PARAMS,
        'name',
        'content',
        'user_parameter',
    ]);

    Notification::assertCount(1);
});

it('error because missing parameters expected notification', function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    [$user, $team] = user_with_team();
    $t = Trigger::factory()
        ->for($team)
        ->create([
            'trigger_type_id' => TriggerTypeId::Webhook->value,
            'configuration' => [
                'fields' => [
                    'parameters' => [
                        'name',
                        'content',
                    ],
                ],
            ],
        ]);

    Notification::fake();

    postJson('/webhooks/'.$t->uuid.'?content=Hola')
        ->assertBadRequest();

    Notification::assertCount(0);
});
