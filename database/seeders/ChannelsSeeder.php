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
    }
}
