<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Transfers\Stats\ParametersGraphDataCollection;
use App\Transfers\Stats\Period;

class TriggerParameterStatsGetter
{
    public function get(
        Trigger $trigger,
        Period $period,
        string $parameter = null,
    ): ParametersGraphDataCollection {
        $parameters = $parameter === null
            ? ($trigger->configurationParameters())
            : [$parameter];
        $parametersData = [];

        foreach ($parameters as $parameter) {
            $parametersData[$parameter] = $trigger
                ->visits()
                ->period($period->period->visitsPeriodInterval())
                ->countAllByParamAndDate(
                    $parameter,
                    $period->fromDate(),
                    $period->toDate(),
                );
        }

        return new ParametersGraphDataCollection(
            $period,
            collect($parametersData)->toArray(),
        );
    }
}
