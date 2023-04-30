<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Notifications\TriggerNotification;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params): void
    {
        // Get value key of array where name = parameters
        $requiredParams = collect($trigger->configuration['fields']['parameters']);

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty()) {
            throw MissingTriggerParams::with($missingParams);
        }

        $trigger->user->notify(new TriggerNotification($trigger, $params));
    }

}
