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
            'daily' => $trigger->visits()->period('day')->countAll(),
            'monthly' => $trigger->visits()->period('month')->countAll(),
        ]);
    }
}
