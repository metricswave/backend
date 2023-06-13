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

        if (
            isset($trigger->configuration['fields']['parameters'])
            && collect(Trigger::VISITS_PARAMS)
                ->diff($trigger->configuration['fields']['parameters'])
                ->isEmpty()
        ) {
            return;
        }

        $configuration['fields']['parameters'] = array_merge(
            Trigger::VISITS_PARAMS,
            $configuration['fields']['parameters'] ?? []
        );

        $trigger->configuration = $configuration;
        $trigger->save();
    }
}
