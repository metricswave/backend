<?php

namespace App\Services\Triggers;

use App\Jobs\UserTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params): void
    {
        $requiredParams = collect($trigger->configuration['fields']['parameters']);

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty()) {
            throw MissingTriggerParams::with($missingParams);
        }

        UserTriggerNotificationJob::dispatch(
            $trigger->user,
            new TriggerNotification(
                $trigger,
                $params,
            )
        );
    }

}
