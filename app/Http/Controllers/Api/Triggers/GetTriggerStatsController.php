<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class GetTriggerStatsController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->user_id !== $this->user()->id) {
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
