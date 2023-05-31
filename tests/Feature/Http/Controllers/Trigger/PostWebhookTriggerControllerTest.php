<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Transfers\TriggerTypeId;
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
