<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Http\Requests\LogoutRequest;
use Illuminate\Http\JsonResponse;

class LogoutController extends ApiAuthJsonController
{
    public function __invoke(LogoutRequest $request): JsonResponse
    {
        $this->user()->tokens()->where('name', $request->device_name)->delete();

        return $this->response(['message' => 'User logged out successfully.']);
    }
}
