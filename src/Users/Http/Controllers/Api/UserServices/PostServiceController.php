<?php

namespace MetricsWave\Users\Http\Controllers\Api\UserServices;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\CreateUserServiceRequest;
use Illuminate\Http\JsonResponse;

class PostServiceController extends ApiAuthJsonController
{
    public function __invoke(CreateUserServiceRequest $request): JsonResponse
    {
        $this->user()->services()->create([
            'service_id' => $request->input('service_id'),
            'service_data' => [
                'configuration' => $request->input('fields'),
            ],
        ]);

        return $this->createdResponse();
    }
}
