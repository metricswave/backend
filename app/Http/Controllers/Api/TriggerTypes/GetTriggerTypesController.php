<?php

namespace App\Http\Controllers\Api\TriggerTypes;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\TriggerType;
use Illuminate\Http\JsonResponse;

class GetTriggerTypesController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response([
            'trigger_types' => TriggerType::all(),
        ]);
    }
}
