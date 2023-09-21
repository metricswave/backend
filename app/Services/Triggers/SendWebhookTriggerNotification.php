<?php

namespace App\Services\Triggers;

use App\Jobs\TeamTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params, bool $fromScript = false): void
    {
        $requiredParams = collect($trigger->configuration['fields']['parameters']);

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty() && ! $fromScript) {
            throw MissingTriggerParams::with($missingParams);
        }

        TeamTriggerNotificationJob::dispatch(
            $trigger->team,
            new TriggerNotification(
                $trigger,
                $params,
            )
        );
    }
}
