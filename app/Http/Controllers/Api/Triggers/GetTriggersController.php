<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class GetTriggersController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        return $this->response([
            'triggers' => $team->triggers()->with('triggerType')->get(),
        ]);
    }
}
