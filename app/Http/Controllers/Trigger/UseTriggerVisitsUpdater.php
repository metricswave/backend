<?php

namespace App\Http\Controllers\Trigger;

use App\Models\Trigger;

trait UseTriggerVisitsUpdater
{
    public function checkTrigger(bool $fromScript, Trigger $trigger): void
    {
        if (!$fromScript) {
            return;
        }

        $configuration = $trigger->configuration;

        if (!$trigger->isVisitsType()) {
            $configuration['type'] = 'visits';
        }

        $configuration['fields']['parameters'] = array_unique([
            ...Trigger::VISITS_PARAMS,
            ...($configuration['fields']['parameters'] ?? [])
        ]);

        $trigger->configuration = $configuration;
        $trigger->save();
    }
}
