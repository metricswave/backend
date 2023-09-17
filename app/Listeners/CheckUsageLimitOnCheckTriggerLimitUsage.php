<?php

namespace App\Listeners;

use App\Events\CheckTriggerLimitUsage;
use App\Notifications\TriggerLimitReachedNotification;
use App\Services\CacheKey;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class CheckUsageLimitOnCheckTriggerLimitUsage implements ShouldQueue
{
    public function handle(CheckTriggerLimitUsage $event): void
    {
        $team = $event->notification->trigger->team;
        // todo: notify by team
        $user = $team->owner;
        $key = CacheKey::generateForModel($team, 'trigger_notification_sent');

        if (! Cache::has($key) && $user->triggerNotificationVisitsLimitReached()) {
            Http::post('https://metricswave.com/webhooks/d5c2d8ab-983e-4653-8e92-b6dc4c55ee6a', [
                'email' => $user->email,
            ]);
            $user->notify(new TriggerLimitReachedNotification());
            Cache::put($key, '1', now()->addDays(3));
        }
    }
}
