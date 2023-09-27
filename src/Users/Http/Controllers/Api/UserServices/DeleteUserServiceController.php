<?php

namespace MetricsWave\Users\Http\Controllers\Api\UserServices;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\DeleteUserServiceRequest;
use Illuminate\Http\JsonResponse;
use MetricsWave\Users\UserService;

class DeleteUserServiceController extends ApiAuthJsonController
{
    public function __invoke(DeleteUserServiceRequest $request, UserService $userService): JsonResponse
    {
        $userService->delete();

        return $this->noContentResponse();
    }
}
