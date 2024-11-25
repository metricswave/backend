<?php

namespace App\Services\Triggers;

use App\Jobs\TeamTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params, bool $fromScript = false, string $triggeredAt = null): void
    {
        if ($trigger->team_id === 76) {
            return;
        }

        $requiredParams = collect($trigger->configuration['fields']['parameters']);

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty() && ! $fromScript) {
            throw MissingTriggerParams::with($missingParams);
        }

        if ($trigger->team === null) {
            if (config('app.env') === 'production') {
                Http::get(
                    'https://metricswave.com/webhooks/842e2f48-4c9f-436f-bb88-c00266496f10',
                    [
                        'message' => 'Trigger '.$trigger->uuid.' has no team.',
                    ]
                );
            }

            return;
        }

        $triggeredAt = $triggeredAt !== null ? CarbonImmutable::parse($triggeredAt) : null;

        TeamTriggerNotificationJob::dispatch(
            $trigger->team,
            new TriggerNotification(
                $trigger,
                $params,
                $triggeredAt,
            )
        );
    }
}
