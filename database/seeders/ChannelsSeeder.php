<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MetricsWave\Channels\Channel;

class ChannelsSeeder extends Seeder
{
    public function run(): void
    {
        Channel::updateOrCreate(
            [
                'driver' => 'telegram',
            ],
            [
                'name' => 'Telegram',
                'description' => 'Connect a Telegram channel to receive notifications on.',
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

        Channel::query()
            ->updateOrCreate(
                [
                    'driver' => 'stripe',
                ],
                [
                    'name' => 'Stripe (beta)',
                    'description' => 'Connect your stripe account to automatically track all your charges with the proper user email.',
                    'configuration' => [
                        'type' => 'form',
                        'form' => [
                            'title' => 'Stripe Key',
                            'description' => 'Generate a Stripe Restricted API key with the next link (everything is already configured), and paste it bellow.',
                            'help' => [
                                'title' => 'Create Restricted API key',
                                'href' => 'https://dashboard.stripe.com/apikeys/create?name=MetricsWave&permissions%5B%5D=rak_charge_read&permissions%5B%5D=rak_bucket_connect_read',
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
