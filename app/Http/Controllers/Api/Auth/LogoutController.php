<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\JsonController;
use App\Http\Requests\LogoutRequest;
use App\Models\TokenAbility;
use Illuminate\Http\JsonResponse;

class LogoutController extends JsonController
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:' . TokenAbility::API]);
    }

    public function __invoke(LogoutRequest $request): JsonResponse
    {
        $this->user()->tokens()->where('name', $request->device_name)->delete();
        return $this->response(["message" => 'User logged out successfully.']);
    }

}
