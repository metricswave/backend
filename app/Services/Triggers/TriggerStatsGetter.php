<?php

namespace App\Services\Triggers;

use App\Models\Trigger;
use App\Transfers\Stats\GraphData;
use App\Transfers\Stats\GraphDataCollection;
use App\Transfers\Stats\GraphHeaders;
use App\Transfers\Stats\Period;
use Statamic\Data\DataCollection;

class TriggerStatsGetter
{
    public function get(
        Trigger $trigger,
        Period $period,
    ): GraphDataCollection {
        $stats = $trigger->visits()
            ->period($period->period->visitsPeriod())
            ->countAll(
                $period->fromDate(),
                $period->toDate(),
            )
            ->map(fn(array $stat) => new GraphData(
                $stat['date'],
                $stat['score'],
            ));

        return new GraphDataCollection(
            $period,
            $this->getHeadersOrNull($trigger, $period),
            new DataCollection($stats)
        );
    }

    private function getHeadersOrNull(Trigger $trigger, Period $period): ?GraphHeaders
    {
        if (!$trigger->isVisitsType()) {
            return null;
        }

        return new GraphHeaders(
            unique: $this->total($trigger, $period, Trigger::UNIQUE_VISITS),
            visits: $this->total($trigger, $period, Trigger::NEW_VISITS),
            pageViews: $this->total($trigger, $period, Trigger::PAGE_VIEWS),
        );
    }

    public function total(Trigger $trigger, Period $period, string $key): int
    {
        return $trigger->visits($key)
            ->period($period->period->visitsPeriod())
            ->countAll(
                $period->fromDate(),
                $period->toDate(),
            )
            ->sum('score');
    }
}
