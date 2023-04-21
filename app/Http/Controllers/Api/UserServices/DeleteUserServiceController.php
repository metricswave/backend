<?php

namespace App\Http\Controllers\Api\UserServices;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\DeleteUserServiceRequest;
use App\Models\UserService;
use Illuminate\Http\JsonResponse;

class DeleteUserServiceController extends ApiAuthJsonController
{
    public function __invoke(DeleteUserServiceRequest $request, UserService $userService): JsonResponse
    {
        $userService->delete();

        return $this->noContentResponse();
    }
}
