<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class GetTriggersController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        return $this->response([
            'triggers' => $team->triggers()->with('triggerType')->get(),
        ]);
    }
}
