<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetTriggerParameterStatsController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger): JsonResponse
    {
        abort_unless($this->user()->hasAccessToTeam($trigger->team), 404);

        $parameters = $trigger->configuration['fields']['parameters'] ?? [];

        $period = request()->query('period') ?? 'day';

        if (request()->query('date')) {
            $date = Carbon::createFromFormat('Y-m-d', request()->query('date'))
                ->add($period, 1)
                ->startOf($period);
        } else {
            $date = Carbon::now()->add($period, 1)->startOf($period);
        }

        $response = [];
        foreach ($parameters as $parameter) {
            $response[$parameter] = $trigger->visits()->period($period)->countAllByParam($parameter, $date);
        }

        return $this->response($response);
    }
}
