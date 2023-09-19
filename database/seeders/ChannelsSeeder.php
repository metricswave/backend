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
                'configuration' => '{"form": {"help": {"href": "/documentation/services/telegram", "title": "How to get a Telegram channel ID?"}, "title": "Telegram Channel", "fields": [{"name": "channel_id", "type": "input", "label": "Channel ID", "required": true, "validation": {"type": "integer", "max_value": 0}, "placeholder": "Channel ID"}, {"name": "channel_name", "type": "input", "label": "Channel Name", "required": true, "validation": {"min_length": 3}, "placeholder": "Channel Name"}], "description": "Connect a Telegram channel to receive notifications on."}, "type": "form"}',
            ]
        );
    }
}
