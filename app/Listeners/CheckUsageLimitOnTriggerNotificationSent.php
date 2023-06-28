<?php

namespace App\Listeners;

use App\Events\TriggerNotificationSent;
use App\Notifications\TriggerLimitReachedNotification;
use App\Services\CacheKey;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class CheckUsageLimitOnTriggerNotificationSent implements ShouldQueue
{
    public function handle(TriggerNotificationSent $event): void
    {
        $user = $event->notification->trigger->user;
        $key = CacheKey::generateForModel($user, 'trigger_notification_sent');

        if ($user->triggerNotificationVisitsLimitReached() && !Cache::has($key)) {
            Http::post('https://metricswave.com/webhooks/d5c2d8ab-983e-4653-8e92-b6dc4c55ee6a', [
                'email' => $user->email,
            ]);
            $user->notify(new TriggerLimitReachedNotification());
            Cache::put($key, "1", now()->addDays(3));
        }
    }
}
