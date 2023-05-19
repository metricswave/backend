<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Transfers\ServiceId;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        Service::query()
            ->updateOrCreate(
                [
                    'id' => ServiceId::Github->value,
                    'driver' => 'github',
                ],
                [
                    'name' => 'GitHub',
                    'description' => 'GitHub is a web-based hosting service for version control.',
                    'scopes' => ['read:user', 'notifications', 'user:email'],
                    'configuration' => [
                        'type' => 'oauth',
                    ]
                ]
            );

        Service::query()
            ->updateOrCreate(
                [
                    'id' => ServiceId::Google->value,
                    'driver' => 'google',
                ],
                [
                    'name' => 'Google Calendar',
                    'description' => 'Connect your calendar to receive notifications on incoming events or time to leave.',
                    'scopes' => [
                        'profile',
                        'email',
                        'https://www.googleapis.com/auth/calendar.readonly',
                        'https://www.googleapis.com/auth/calendar.events.readonly',
                    ],
                    'configuration' => [
                        'version' => '1.0',
                        'type' => 'oauth',
                    ]
                ]
            );

        Service::query()
            ->updateOrCreate(
                [
                    'id' => ServiceId::Telegram->value,
                    'driver' => 'telegram',
                ],
                [
                    'name' => 'Telegram',
                    'description' => 'Connect a Telegram channel to receive notifications on.',
                    'scopes' => [],
                    'multiple' => true,
                    'configuration' => [
                        'type' => 'form',
                        'form' => [
                            'title' => 'Telegram Channel',
                            'description' => 'Connect a Telegram channel to receive notifications on.',
                            'help' => [
                                'title' => 'How to get a Telegram channel ID?',
                                'href' => '/documentation/services/telegram',
                            ],
                            'fields' => [
                                [
                                    'name' => 'channel_id',
                                    'type' => 'input',
                                    'label' => 'Channel ID',
                                    'placeholder' => 'Channel ID',
                                    'required' => true,
                                    'validation' => [
                                        'type' => 'integer',
                                        'max_value' => 0,
                                    ],
                                ],
                                [
                                    'name' => 'channel_name',
                                    'type' => 'input',
                                    'label' => 'Channel Name',
                                    'placeholder' => 'Channel Name',
                                    'required' => true,
                                    'validation' => [
                                        'min_length' => 3,
                                    ],
                                ],
                            ],
                        ]
                    ]
                ]
            );
    }
}
