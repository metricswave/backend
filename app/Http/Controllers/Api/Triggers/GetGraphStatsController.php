<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PeriodRequest;
use App\Models\Trigger;
use App\Services\Triggers\TriggerStatsGetter;
use Illuminate\Http\JsonResponse;

class GetGraphStatsController extends ApiAuthJsonController
{
    public function __construct(readonly private TriggerStatsGetter $statsGetter)
    {
        parent::__construct();
    }

    public function __invoke(Trigger $trigger, PeriodRequest $request): JsonResponse
    {
        abort_unless($this->user()->hasAccessToTeam($trigger->team), 404);

        $stats = $this->statsGetter->get(
            $trigger,
            $request->getPeriod(),
        );

        return $this->response(
            $stats->toArray()
        );
    }
}
