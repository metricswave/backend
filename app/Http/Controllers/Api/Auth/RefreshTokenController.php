<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\AuthRefreshRequest;
use App\Models\TokenAbility;
use Illuminate\Http\JsonResponse;

class RefreshTokenController extends JsonTokenResponse
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:'.TokenAbility::REFRESH]);
    }

    public function __invoke(AuthRefreshRequest $request): JsonResponse
    {
        $this->user()->tokens()->where('name', $request->device_name)->delete();

        return $this->tokenResponse(
            user: $this->user(),
            deviceName: $request->device_name,
        );
    }
}
