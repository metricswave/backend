<?php

use App\Models\TriggerType;
use App\Models\User;

it('creates a trigger', function () {
    $uuid = $this->faker->uuid;

    /** @var User $user */
    $user = User::factory()->create();

    /** @var TriggerType $triggerType */
    $triggerType = TriggerType::factory()->create([
        'name' => 'Test Trigger Type',
        'description' => 'This is a test trigger type',
        'configuration' => [
            'version' => '1.0',
            'fields' => [
                [
                    'name' => 'time',
                    'type' => 'time',
                    'label' => 'Time',
                    'required' => true,
                ],
                [
                    'name' => 'weekdays',
                    'type' => 'weekdays',
                    'label' => 'Weekdays',
                    'required' => true,
                    'multiple' => true,
                ]
            ],
        ],
    ]);

    $this
        ->actingAs($user)
        ->postJson('/api/triggers', [
            'uuid' => $uuid,
            'trigger_type_id' => $triggerType->id,
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
            'configuration' => [
                'fields' => [
                    'time' => '12:00',
                    'weekdays' => ['monday', 'tuesday'],
                ],
            ],
        ])->assertCreated();

    $this->assertDatabaseHas('triggers', [
        'uuid' => $uuid,
        'user_id' => $user->id,
        'trigger_type_id' => $triggerType->id,
        'emoji' => '👍',
        'title' => 'Test Trigger',
        'content' => 'This is a test trigger',
        'configuration' => cast_to_json([
            'fields' => [
                'time' => '12:00',
                'weekdays' => ['monday', 'tuesday'],
            ],
        ]),
    ]);
});

it('creates a trigger updating time to UTC', function () {
    $uuid = $this->faker->uuid;

    /** @var User $user */
    $user = User::factory()->create();

    /** @var TriggerType $triggerType */
    $triggerType = TriggerType::factory()->create([
        'name' => 'Test Trigger Type',
        'description' => 'This is a test trigger type',
        'configuration' => [
            'version' => '1.0',
            'fields' => [
                [
                    'name' => 'time',
                    'type' => 'time',
                    'label' => 'Time',
                    'required' => true,
                ],
                [
                    'name' => 'weekdays',
                    'type' => 'weekdays',
                    'label' => 'Weekdays',
                    'required' => true,
                    'multiple' => true,
                ]
            ],
        ],
    ]);

    $this
        ->actingAs($user)
        ->postJson(
            '/api/triggers',
            [
                'uuid' => $uuid,
                'trigger_type_id' => $triggerType->id,
                'emoji' => '👍',
                'title' => 'Test Trigger',
                'content' => 'This is a test trigger',
                'configuration' => [
                    'fields' => [
                        'time' => '12:00',
                        'weekdays' => ['monday', 'tuesday'],
                    ],
                ],
            ],
            [
                'x-timezone' => 'Europe/Madrid',
            ]
        )->assertCreated();

    $this->assertDatabaseHas('triggers', [
        'uuid' => $uuid,
        'user_id' => $user->id,
        'trigger_type_id' => $triggerType->id,
        'emoji' => '👍',
        'title' => 'Test Trigger',
        'content' => 'This is a test trigger',
        'configuration' => cast_to_json([
            'fields' => [
                'time' => '10:00',
                'weekdays' => ['monday', 'tuesday'],
            ],
        ]),
    ]);
});

it('tries to create a trigger with missing fields', function () {
    /** @var User $user */
    $user = User::factory()->create();

    /** @var TriggerType $triggerType */
    $triggerType = TriggerType::factory()->create([
        'name' => 'Test Trigger Type',
        'description' => 'This is a test trigger type',
        'configuration' => [
            'version' => '1.0',
            'fields' => [
                [
                    'name' => 'time',
                    'type' => 'time',
                    'label' => 'Time',
                    'required' => true,
                ],
                [
                    'name' => 'weekdays',
                    'type' => 'weekdays',
                    'label' => 'Weekdays',
                    'required' => true,
                    'multiple' => true,
                ]
            ],
        ],
    ]);

    $this
        ->actingAs($user)
        ->postJson('/api/triggers', [
            'trigger_type_id' => $triggerType->id,
            'configuration' => [
                'fields' => [
                    'time' => '12:00',
                    'weekdays' => ['monday', 'tuesday'],
                ],
            ],
        ])->assertInvalid([
            'uuid' => 'The uuid field is required.',
            'emoji' => 'The emoji field is required.',
            'title' => 'The title field is required.',
            'content' => 'The content field is required.',
        ]);
});

it('tries to create trigger with missing fields in configuration', function () {
    $uuid = $this->faker->uuid;

    /** @var User $user */
    $user = User::factory()->create();

    /** @var TriggerType $triggerType */
    $triggerType = TriggerType::factory()->create([
        'name' => 'Test Trigger Type',
        'description' => 'This is a test trigger type',
        'configuration' => [
            'version' => '1.0',
            'fields' => [
                [
                    'name' => 'filter',
                    'type' => 'input',
                    'label' => 'Filter',
                    'required' => true,
                ],
                [
                    'name' => 'time',
                    'type' => 'time',
                    'label' => 'Time',
                    'required' => true,
                ],
                [
                    'name' => 'weekdays',
                    'type' => 'weekdays',
                    'label' => 'Weekdays',
                    'required' => true,
                    'multiple' => true,
                ]
            ],
        ],
    ]);

    $this
        ->actingAs($user)
        ->postJson('/api/triggers', [
            'uuid' => $uuid,
            'trigger_type_id' => $triggerType->id,
            'emoji' => '👍',
            'title' => 'Test Trigger',
            'content' => 'This is a test trigger',
            'configuration' => [
                'time' => [],
                'weekdays' => [
                    'value' => [],
                ],
            ],
        ])->assertInvalid([
            'configuration' => [
                "The filter inside configuration field is required.",
                "The time inside configuration field is required.",
                "The weekdays inside configuration field is required.",
            ]
        ]);
});
