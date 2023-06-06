<?php

namespace App\Console\Commands\TelegramBot;

use App\Services\CacheKey;
use Cache;
use Http;
use Illuminate\Console\Command;

class ReplyWithGroupIdCommand extends Command
{
    protected $signature = 'telegram:reply-with-group-id';

    protected $description = 'Reply with group id when invoked in a group.';

    public function handle(): int
    {
        $time_start = microtime(true);
        $end_time = $time_start + 59;

        do {
            $this->getMessages();
            sleep(1);
        } while ($end_time > microtime(true));

        return self::SUCCESS;
    }

    private function getMessages(): void
    {
        $telegramBotToken = config('services.telegram-bot-api.token');
        $messages = Http::get("https://api.telegram.org/bot{$telegramBotToken}/getUpdates")
            ->json('result');

        if (empty($messages)) {
            return;
        }

        foreach ($messages as $message) {
            if (isset($message['message']['chat']['type']) && $message['message']['chat']['type'] === 'group' && isset($message['message']['text']) && $message['message']['text'] === '/connect@NotifyWaveBot') {
                $cacheKey = CacheKey::generate(
                    'telegram_connect_command',
                    $message['message']['chat']['id'],
                    $message['message']['message_id']
                );

                if (Cache::has($cacheKey)) {
                    continue;
                }

                $chatId = $message['message']['chat']['id'];
                $messageId = $message['message']['message_id'];
                $text = "This is the group id: {$chatId}";
                Http::get("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'reply_to_message_id' => $messageId,
                ]);

                Cache::put($cacheKey, true, now()->addWeek());
            }
        }
    }
}
