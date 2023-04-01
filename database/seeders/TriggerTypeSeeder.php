<?php

namespace Database\Seeders;

use App\Models\TriggerType;
use Illuminate\Database\Seeder;

class TriggerTypeSeeder extends Seeder
{
    public function run(): void
    {
        TriggerType::updateOrCreate(
            ['name' => 'Webhook'],
            [
                'icon' => 'webhook.png',
                'description' => 'Trigger a task when a webhook is received.',
                'configuration' => [
                    'version' => '1.0',
                    'fields' => [
                        [
                            'name' => 'parameters',
                            'type' => 'input',
                            'label' => 'Parameters',
                            'multiple' => true,
                            'required' => false,
                        ]
                    ],
                ],
            ],
        );

        TriggerType::updateOrCreate(
            ['name' => 'On Time'],
            [
                'icon' => 'on_time.png',
                'description' => 'Trigger a task at a specific time and day(s) of the week.',
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
            ],
        );
    }
}
