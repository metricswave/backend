<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Transfers\TriggerTypeId;
use Awssat\Visits\Models\Visit;
use function Pest\Laravel\postJson;

it('send expected notification', function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $t = Trigger::factory()->for(User::factory()->create())->create([
        'trigger_type_id' => TriggerTypeId::Webhook->value,
        'configuration' => [
            'fields' => [
                "parameters" => [
                    'name',
                    'content',
                ]
            ]
        ]
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
    expect(Visit::query()->where('primary_key', 'visits:testing:users_domain_day_domain:1')->first())
        ->score->toBe(1)
        ->secondary_key->toBe('notifywave.test');
});

it("trigger params are updated because it's called from the script", function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $t = Trigger::factory()->for(User::factory()->create())->create([
        'trigger_type_id' => TriggerTypeId::Webhook->value,
        'configuration' => [
            'fields' => [
                "parameters" => [
                    'name',
                    'content',
                ]
            ]
        ]
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
    expect($t->configuration['fields']['parameters'])->toMatchArray([
        ...Trigger::VISITS_PARAMS,
        'name',
        'content',
    ]);

    Notification::assertCount(1);
});

it('error because missing parameters expected notification', function () {
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook->value]);
    $t = Trigger::factory()->for(User::factory()->create())->create([
        'trigger_type_id' => TriggerTypeId::Webhook->value,
        'configuration' => [
            'fields' => [
                "parameters" => [
                    'name',
                    'content',
                ]
            ]
        ]
    ]);

    Notification::fake();

    postJson('/webhooks/'.$t->uuid.'?content=Hola')
        ->assertBadRequest();

    Notification::assertCount(0);
});
