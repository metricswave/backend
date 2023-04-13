<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\PostTriggerRequest;
use Illuminate\Http\JsonResponse;

class PostTriggersController extends ApiAuthJsonController
{
    public function __invoke(PostTriggerRequest $request): JsonResponse
    {
        $this->user()->triggers()->create($request->validated());

        return $this->createdResponse();
    }
}
