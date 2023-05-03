<?php

namespace App\Listeners;

use App\Events\TriggerNotificationSent;
use App\Notifications\TriggerLimitReachedNotification;
use App\Services\CacheKey;
use Illuminate\Support\Facades\Cache;

class CheckUsageLimitOnTriggerNotificationSent
{
    public function handle(TriggerNotificationSent $event): void
    {
        $user = $event->notification->trigger->user;
        $key = CacheKey::generate($user, 'trigger_notification_sent');

        if ($user->triggerNotificationVisitsLimitReached() && !Cache::has($key)) {
            $user->notify(new TriggerLimitReachedNotification());

            Cache::put($key, true, now()->addDays(3));
        }
    }
}
