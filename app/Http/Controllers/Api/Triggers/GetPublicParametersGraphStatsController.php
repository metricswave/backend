<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Dashboard;
use App\Models\Trigger;
use App\Services\Triggers\TriggerParameterStatsGetter;
use App\Transfers\Stats\ParentPeriod;
use App\Transfers\Stats\PeriodEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetPublicParametersGraphStatsController extends ApiAuthJsonController
{
    public function __construct(readonly private TriggerParameterStatsGetter $statsGetter)
    {
        parent::__construct();
    }

    public function __invoke(Dashboard $dashboard, Trigger $trigger): JsonResponse
    {
        abort_if(!$dashboard->public, 404);

        if ($dashboard->items->filter(fn($i) => $i->eventUuid === $trigger->uuid)->count() === 0) {
            abort(404);
        }

        $date = Carbon::createFromFormat('Y-m-d', request()->query('date', now()->format('Y-m-d')));
        $stats = $this->statsGetter->get(
            $trigger,
            new ParentPeriod(
                date: $date,
                period: PeriodEnum::from(request()->query('period', '30d')),
            )
        );

        return $this->response(
            $stats->toArray()
        );
    }
}
