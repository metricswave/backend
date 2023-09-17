<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PostTriggerRequest;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class PostTriggersController extends ApiAuthJsonController
{
    public function __invoke(Team $team, PostTriggerRequest $request): JsonResponse
    {
        $team->triggers()->create($request->validated());

        return $this->createdResponse();
    }
}
