<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\ImpersonateRequest;
use App\Models\TokenAbility;
use Illuminate\Http\JsonResponse;
use MetricsWave\Users\User;

class PostImpersonateController extends JsonTokenResponseController
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:'.TokenAbility::API]);
    }

    public function __invoke(ImpersonateRequest $request): JsonResponse
    {
        abort_if($this->user()->id !== 1, 404);

        return $this->tokenResponse(
            user: User::find($request->user_id),
            deviceName: $request->device_name,
        );
    }
}
