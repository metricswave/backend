<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\JsonController;
use App\Http\Requests\PeriodRequest;
use App\Models\Dashboard;
use App\Models\Trigger;
use App\Services\Triggers\TriggerStatsGetter;
use App\Transfers\Stats\Period;
use App\Transfers\Stats\PeriodEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetPublicGraphStatsController extends JsonController
{
    public function __construct(readonly private TriggerStatsGetter $statsGetter)
    {
    }

    public function __invoke(Dashboard $dashboard, Trigger $trigger, PeriodRequest $request): JsonResponse
    {
        abort_if(!$dashboard->public, 404);

        if ($dashboard->items->filter(fn($i) => $i->eventUuid === $trigger->uuid)->count() === 0) {
            abort(404);
        }

        $stats = $this->statsGetter->get(
            $trigger,
            $request->getPeriod(),
        );

        return $this->response(
            $stats->toArray()
        );
    }
}
