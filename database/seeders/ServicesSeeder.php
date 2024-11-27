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
                    ],
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
                        ],
                    ],
                ]
            );

        Service::query()
            ->updateOrCreate(
                [
                    'id' => ServiceId::Stripe->value,
                    'driver' => 'stripe',
                ],
                [
                    'name' => 'Stripe',
                    'description' => 'Connect your stripe account to automatically track all your charges with the proper user email.',
                    'scopes' => [],
                    'multiple' => true,
                    'configuration' => [
                        'type' => 'form',
                        'form' => [
                            'title' => 'Stripe Key',
                            'description' => 'Generate a Stripe Restricted API key just with minimum read permissions and past it bellow.',
                            'help' => [
                                'title' => 'Create Restricted API key',
                                'href' => 'https://dashboard.stripe.com/apikeys/create?name=MetricsWave&permissions%5B%5D=rak_charge_read',
                            ],
                            'fields' => [
                                [
                                    'name' => 'api_key',
                                    'type' => 'input',
                                    'label' => 'API Key',
                                    'placeholder' => 'rk_51O29JHDeHCkjvn4gdfgDgThHuyAOCturdF8m0IoAAlAMSI9g2xBdO0d9Xs7ZV1dqTbOxjULEEWKTq1dg000mZd8Xmgq',
                                    'required' => true,
                                    'validation' => [
                                        'min_length' => 20,
                                    ],
                                ],
                                [
                                    'name' => 'name',
                                    'type' => 'input',
                                    'label' => 'Account Name',
                                    'placeholder' => 'Name',
                                    'required' => true,
                                    'validation' => [
                                        'min_length' => 3,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            );
    }
}
