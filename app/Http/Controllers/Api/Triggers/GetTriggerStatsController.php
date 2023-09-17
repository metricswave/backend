<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class GetTriggerStatsController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger): JsonResponse
    {
        abort_unless($this->user()->hasAccessToTeam($trigger->team), 404);

        return $this->response([
            'daily' => $trigger->visits()->period('day')->countAll(),
            'weekly' => $trigger->visits()->period('week')->countAll(),
            'monthly' => $trigger->visits()->period('month')->countAll(),
            'yearly' => $trigger->visits()->period('year')->countAll(),
        ]);
    }
}
