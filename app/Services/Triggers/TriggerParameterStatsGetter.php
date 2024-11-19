<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Services\CacheKey;
use App\Transfers\Stats\ParametersGraphDataCollection;
use App\Transfers\Stats\Period;
use Illuminate\Support\Facades\Cache;

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
            $parametersData[$parameter] = Cache::remember(
                CacheKey::generateForModel($trigger, ['param_stats', $parameter, $period->key()]),
                now()->addMinutes(config('app.cache.stats')),
                fn () => $trigger
                    ->visits()
                    ->period($period->period->visitsPeriodInterval())
                    ->countAllByParamAndDate(
                        $parameter,
                        $period->fromDate(),
                        $period->toDate(),
                    ));
        }

        return new ParametersGraphDataCollection(
            $period,
            collect($parametersData)->toArray(),
        );
    }
}
