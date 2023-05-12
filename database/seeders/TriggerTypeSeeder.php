<?php

namespace Database\Seeders;

use App\Models\TriggerType;
use App\Transfers\TriggerTypeId;
use Illuminate\Database\Seeder;

class TriggerTypeSeeder extends Seeder
{
    public function run(): void
    {
        TriggerType::updateOrCreate(
            ['id' => TriggerTypeId::Webhook],
            [
                'name' => 'Webhook',
                'icon' => 'webhook.png',
                'description' => 'Trigger a task when a webhook is received.',
                'configuration' => [
                    'version' => '1.0',
                    'fields' => [
                        [
                            'name' => 'parameters',
                            'type' => 'parameters',
                            'label' => 'Parameters',
                            'multiple' => true,
                            'required' => false,
                        ]
                    ],
                ],
            ],
        );

        TriggerType::updateOrCreate(
            ['id' => TriggerTypeId::OnTime],
            [
                'name' => 'On Time',
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
                            'default' => [
                                'monday',
                                'tuesday',
                                'wednesday',
                                'thursday',
                                'friday',
                                'saturday',
                                'sunday',
                            ],
                        ]
                    ],
                ],
            ],
        );

        TriggerType::updateOrCreate(
            ['id' => TriggerTypeId::WeatherSummary],
            [
                'name' => 'Daily Weather Summary',
                'icon' => 'weather.png',
                'description' => 'Receive a summary of the weather for a location.',
                'configuration' => [
                    'version' => '1.0',
                    'fields' => [
                        [
                            'name' => 'location',
                            'type' => 'location',
                            'label' => 'Location',
                            'required' => true,
                        ],
                        [
                            'name' => 'time',
                            'type' => 'time',
                            'label' => 'Time',
                            'required' => true,
                            'default' => '08:00',
                        ],
                        [
                            'name' => 'weekdays',
                            'type' => 'weekdays',
                            'label' => 'Weekdays',
                            'required' => true,
                            'multiple' => true,
                            'default' => [
                                'monday',
                                'tuesday',
                                'wednesday',
                                'thursday',
                                'friday',
                                'saturday',
                                'sunday',
                            ],
                        ]
                    ],
                ],
            ],
        );

        TriggerType::updateOrCreate(
            ['id' => TriggerTypeId::TimeToLeave],
            [
                'name' => 'Time to Leave (Beta)',
                'icon' => 'live_transit.png',
                'description' => 'Receive a notification when it\'s time to leave based on live transit data.',
                'configuration' => [
                    'version' => '1.0',
                    'fields' => [
                        [
                            'name' => 'origin',
                            'type' => 'address',
                            'label' => 'Origin',
                            'required' => true,
                        ],
                        [
                            'name' => 'destination',
                            'type' => 'address',
                            'label' => 'Destination',
                            'required' => true,
                        ],
                        [
                            'name' => 'mode',
                            'type' => 'select',
                            'label' => 'Mode',
                            'required' => true,
                            'multiple' => false,
                            'default' => 'driving',
                            'options' => [
                                ['value' => 'driving', 'label' => 'Driving'],
                                ['value' => 'walking', 'label' => 'Walking'],
                                ['value' => 'bicycling', 'label' => 'Bicycling'],
                                ['value' => 'transit', 'label' => 'Transit'],
                            ]
                        ],
                        [
                            'name' => 'arrival_time',
                            'type' => 'time',
                            'label' => 'Arrival Time',
                            'required' => true,
                            'default' => '08:00',
                        ],
                        [
                            'name' => 'weekdays',
                            'type' => 'weekdays',
                            'label' => 'Weekdays',
                            'required' => true,
                            'multiple' => true,
                            'default' => [
                                'monday',
                                'tuesday',
                                'wednesday',
                                'thursday',
                                'friday',
                                'saturday',
                                'sunday',
                            ],
                        ]
                    ],
                ],
            ],
        );

        if (app()->environment('local')) {
            $this->seedForLocalEnvironment();
        }
    }

    private function seedForLocalEnvironment(): void
    {
    }
}
