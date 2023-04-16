<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PutTriggerRequest;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class PutTriggersController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger, PutTriggerRequest $request): JsonResponse
    {
        $trigger->update($request->validated());

        return $this->response(null, 204);
    }
}
