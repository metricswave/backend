<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use App\Services\Triggers\TriggerParameterStatsGetter;
use App\Transfers\Stats\ParentPeriod;
use App\Transfers\Stats\PeriodEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetParametersGraphStatsController extends ApiAuthJsonController
{
    public function __construct(readonly private TriggerParameterStatsGetter $statsGetter)
    {
        parent::__construct();
    }

    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->user_id !== $this->user()->id) {
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
