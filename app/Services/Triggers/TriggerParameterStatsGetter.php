<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Transfers\Stats\ParametersGraphDataCollection;
use App\Transfers\Stats\ParentPeriod;

class TriggerParameterStatsGetter
{
    public function get(
        Trigger $trigger,
        ParentPeriod $period,
    ): ParametersGraphDataCollection {
        $parameters = $trigger->configuration['fields']['parameters'] ?? [];
        $parametersData = [];

        $fromDate = $period->toDate()->startOf($period->period->visitsPeriodParent());

        foreach ($parameters as $parameter) {
            $parametersData[$parameter] = $trigger
                ->visits()
                ->period($period->period->visitsPeriodParent())
                ->countAllByParam(
                    $parameter,
                    $fromDate,
                );
        }

        return new ParametersGraphDataCollection(
            $period,
            collect($parametersData)->toArray(),
        );
    }
}
