<?php

namespace App\Listeners;

use App\Events\CheckTriggerLimitUsage;
use App\Models\User;
use App\Notifications\TriggerLimitReachedNotification;
use App\Services\CacheKey;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use MetricsWave\Teams\MonthlyLimit;

class CheckUsageLimitOnCheckTriggerLimitUsage implements ShouldQueue
{
    public function handle(CheckTriggerLimitUsage $event): void
    {
        $team = $event->notification->trigger->team;
        $user = $team->owner;

        $limitKey = CacheKey::generateForModel($team, ['limit_trigger_notification_sent', now()->format('Y-m')]);
        $notificationKey = CacheKey::generateForModel($team, 'trigger_notification_sent');

        if (! Cache::has($limitKey) && $team->triggerNotificationVisitsLimitReached()) {
            Cache::put($limitKey, '1', now()->addMonth());

            $params = [
                'team_id' => $team->id,
                'month' => now()->month,
                'year' => now()->year,
            ];

            if (MonthlyLimit::where($params)->count() === 0) {
                Http::post('https://metricswave.com/webhooks/d5c2d8ab-983e-4653-8e92-b6dc4c55ee6a', [
                    'email' => $user->email,
                ]);

                MonthlyLimit::updateOrCreate($params);
            }
        }

        if (! Cache::has($notificationKey) && Cache::has($limitKey)) {
            if (in_array($user->email, User::EMAILS_WITH_PRIVILEGES)) {
                Http::post('https://metricswave.com/webhooks/60bb9264-5e13-42a5-b563-b914b516fc74', [
                    'type' => 'Limit Reached Mail (Email Not Send)',
                    'email' => $user->email,
                ]);
            } else {
                Http::post('https://metricswave.com/webhooks/60bb9264-5e13-42a5-b563-b914b516fc74', [
                    'type' => 'Limit Reached Mail',
                    'email' => $user->email,
                ]);

                $user->notify(new TriggerLimitReachedNotification($team));
            }

            Cache::put($notificationKey, '1', now()->addDays(7));
        }
    }
}
