<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\JsonController;
use App\Models\Dashboard;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class GetPublicDashboardTriggerStatsController extends JsonController
{
    public function __invoke(Dashboard $dashboard, Trigger $trigger): JsonResponse
    {
        abort_if(!$dashboard->public, 404);

        if ($dashboard->items->filter(fn($i) => $i->eventUuid === $trigger->uuid)->count() === 0) {
            abort(404);
        }

        return $this->response([
            'new_visits' => [
                'monthly' => $trigger->visits(Trigger::NEW_VISITS)->period('month')->countAll(),
                'yearly' => $trigger->visits(Trigger::NEW_VISITS)->period('year')->countAll(),
            ],
            'unique_visits' => [
                'monthly' => $trigger->visits(Trigger::UNIQUE_VISITS)->period('month')->countAll(),
                'yearly' => $trigger->visits(Trigger::UNIQUE_VISITS)->period('year')->countAll(),
            ],
            'daily' => $trigger->visits()->period('day')->countAll(),
            'weekly' => $trigger->visits()->period('week')->countAll(),
            'monthly' => $trigger->visits()->period('month')->countAll(),
            'yearly' => $trigger->visits()->period('year')->countAll(),
        ]);
    }
}
