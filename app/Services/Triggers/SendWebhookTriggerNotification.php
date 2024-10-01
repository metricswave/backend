<?php

namespace App\Services\Triggers;

use App\Jobs\TeamTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use Carbon\CarbonImmutable;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params, bool $fromScript = false, ?string $triggeredAt = null): void
    {
        $requiredParams = collect($trigger->configuration['fields']['parameters']);

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty() && ! $fromScript) {
            throw MissingTriggerParams::with($missingParams);
        }

        if ($trigger->team_id === 76) {
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
