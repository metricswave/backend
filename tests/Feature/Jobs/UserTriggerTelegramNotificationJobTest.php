<?php

use App\Jobs\UserTriggerTelegramNotificationJob;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use App\Models\UserService;
use App\Notifications\TriggerNotification;

it('catch error 400 when group changed to supergroup and change channel_id', function () {
    // https://api.telegram.org/bot6183664646:AAHMLE4zkKB2KPnpTRJoewYIZ6pYo0yVdR4/sendMessage
    Http::fake([
        'api.telegram.org/*' => Http::sequence([
            Http::response([
                'ok' => false,
                'error_code' => 400,
                'description' => 'Bad Request: group chat was upgraded to a supergroup chat',
                'parameters' => [
                    'migrate_to_chat_id' => -222222
                ]
            ], 400),
            Http::response([
                'ok' => true,
                'error_code' => 200,
            ])
        ]),
    ]);

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create();
    $userService = UserService::factory()->create([
        'user_id' => $trigger->user_id,
        'service_id' => 1,
        'service_data' => [
            'configuration' => [
                'channel_id' => '-111111'
            ]
        ]
    ]);

    UserTriggerTelegramNotificationJob::dispatchSync(new TriggerNotification($trigger, []), $userService);

    Http::assertSent(function (Illuminate\Http\Client\Request $request) {
        return $request->url() === 'https://api.telegram.org/bot'.config('services.telegram-bot-api.token').'/sendMessage' && $request['chat_id'] === '-111111';
    });

    Http::assertSent(function (Illuminate\Http\Client\Request $request) {
        return $request->url() === 'https://api.telegram.org/bot'.config('services.telegram-bot-api.token').'/sendMessage' && $request['chat_id'] === '-222222';
    });
});
