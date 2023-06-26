<?php

namespace App\Notifications;

use App\Models\Trigger;
use App\Services\CacheKey;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Str;

class TriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public readonly string $title;
    public readonly string $content;
    public readonly string $emoji;

    public function __construct(public readonly Trigger $trigger, public readonly array $params = [])
    {
        $this->title = $trigger->formattedTitle($params);
        $this->content = $trigger->formattedContent($params);
        $this->emoji = $trigger->formattedEmoji($params);
    }

    public function via(object $notifiable): array
    {
        // todo: uncomment this when we have a billing system
        // $user = $this->trigger->user;
        // if ($user->triggerNotificationVisitsLimitReached()) {
        //     return ['database'];
        // }

        $this->trigger->visits()->increment();

        $params = $this->params;

        if ($this->trigger->isVisitsType()) {
            if (isset($params['deviceName'])) {
                $cacheKey = CacheKey::generateForModel($this->trigger, ['unique', $params['deviceName']]);
                unset($params['deviceName']);

                if (!Cache::has($cacheKey)) {
                    $this->trigger->visits(Trigger::UNIQUE_VISITS)->increment();
                    Cache::put($cacheKey, true, now()->endOfDay());
                }
            }

            if (isset($params['visit'])) {
                if ($params['visit'] === 1 || $params['visit'] === '1') {
                    $this->trigger->visits(Trigger::NEW_VISITS)->increment();
                }
                unset($params['visit']);
            }

            if (
                empty($params['referrer'])
                || (
                    isset($params['domain'])
                    && Str::of($params['referrer'])->contains($params['domain'])
                )
            ) {
                $params['referrer'] = 'Direct / None';
            }
        }

        $this->trigger->visits()->recordParams($params);

        $via = collect($this->trigger->via)
            ->filter(fn($via) => $via['checked'] && $via['type'] !== 'telegram')
            ->unique('type')
            ->map(fn($via) => $via['type'])
            ->toArray();

        return [
            'database',
            ...$via,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'emoji' => $this->emoji,
            'trigger_id' => $this->trigger->id,
            'trigger_type_id' => $this->trigger->trigger_type_id,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->trigger->emoji.' '.$this->title)
            ->markdown('mail.trigger', [
                'emoji' => $this->emoji,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
