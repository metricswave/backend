<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Services\CacheKey;
use App\Transfers\Stats\GraphData;
use App\Transfers\Stats\GraphDataCollection;
use App\Transfers\Stats\GraphHeader;
use App\Transfers\Stats\GraphHeaders;
use App\Transfers\Stats\Period;
use Illuminate\Support\Facades\Cache;
use Statamic\Data\DataCollection;

class TriggerStatsGetter
{
    public function get(
        Trigger $trigger,
        Period $period,
    ): GraphDataCollection {
        $stats = Cache::remember(
            CacheKey::generateForModel($trigger, ['stats', $period->key()]),
            now()->addMinutes(config('app.cache.stats')),
            fn () => $trigger->visits()
                ->period($period->period->visitsPeriodInterval())
                ->countAll(
                    $period->fromDate(),
                    $period->toDate(),
                )
                ->map(fn (array $stat) => new GraphData(
                    $stat['date'],
                    $stat['score'],
                ))
        );

        $data = new DataCollection($stats);

        return new GraphDataCollection(
            $period,
            $this->getHeadersOrNull($trigger, $period, $data),
            $data,
        );
    }

    private function getHeadersOrNull(Trigger $trigger, Period $period, DataCollection $data = null): ?GraphHeaders
    {
        if ($trigger->isVisitsType()) {
            return new GraphHeaders([
                new GraphHeader('unique', $this->total($trigger, $period, Trigger::UNIQUE_VISITS)),
                new GraphHeader('visits', $this->total($trigger, $period, Trigger::NEW_VISITS)),
                new GraphHeader('pageViews', $this->total($trigger, $period, Trigger::PAGE_VIEWS)),
            ]);
        }

        if ($trigger->isMoneyIncomeType()) {
            $total = $data->sum(fn (GraphData $d) => $d->score);

            return new GraphHeaders([
                new GraphHeader('total_income', $total),
            ]);
        }

        return null;
    }

    public function total(Trigger $trigger, Period $period, string $key): int
    {
        return $trigger->visits($key)
            ->period($period->period->visitsPeriodInterval())
            ->countAll(
                $period->fromDate(),
                $period->toDate(),
            )
            ->sum('score');
    }
}
