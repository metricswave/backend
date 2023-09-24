<?php

use App\Jobs\UserTriggerTelegramNotificationJob;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Notifications\TriggerNotification;
use MetricsWave\Channels\Channel;
use MetricsWave\Channels\TeamChannel;

it('catch error 400 when group changed to supergroup and change channel_id', function () {
    // https://api.telegram.org/bot6183664646:AAHMLE4zkKB2KPnpTRJoewYIZ6pYo0yVdR4/sendMessage
    Http::fake([
        'api.telegram.org/*' => Http::sequence([
            Http::response([
                'ok' => false,
                'error_code' => 400,
                'description' => 'Bad Request: group chat was upgraded to a supergroup chat',
                'parameters' => [
                    'migrate_to_chat_id' => -222222,
                ],
            ], 400),
            Http::response([
                'ok' => true,
                'error_code' => 200,
            ]),
        ]),
    ]);

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create();
    $channel = Channel::factory()->create();
    $userService = TeamChannel::factory()->create([
        'team_id' => $team->id,
        'channel_id' => $channel->id,
        'data' => [
            'configuration' => [
                'channel_id' => '-111111',
            ],
        ],
    ]);

    UserTriggerTelegramNotificationJob::dispatchSync(new TriggerNotification($trigger, []), $userService);

    Http::assertSent(function (Illuminate\Http\Client\Request $request) {
        return $request->url() === 'https://api.telegram.org/bot'.config('services.telegram-bot-api.token').'/sendMessage' && $request['chat_id'] === '-111111';
    });

    Http::assertSent(function (Illuminate\Http\Client\Request $request) {
        return $request->url() === 'https://api.telegram.org/bot'.config('services.telegram-bot-api.token').'/sendMessage' && $request['chat_id'] === '-222222';
    });
});
