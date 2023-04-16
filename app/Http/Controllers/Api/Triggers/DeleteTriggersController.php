<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\DeleteTriggerRequest;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class DeleteTriggersController extends ApiAuthJsonController
{
    public function __invoke(Trigger $trigger, DeleteTriggerRequest $request): JsonResponse
    {
        $trigger->delete();

        return $this->noContentResponse();
    }
}
