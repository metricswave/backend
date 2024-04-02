<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\JsonController;
use App\Models\Dashboard;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class GetPublicDashboardTriggerParameterStatsController extends JsonController
{
    public function __invoke(Dashboard $dashboard, Trigger $trigger): JsonResponse
    {
        abort_if(! $dashboard->public, 404);

        if ($dashboard->items->filter(fn ($i) => $i->eventUuid === $trigger->uuid)->count() === 0) {
            abort(404);
        }

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
