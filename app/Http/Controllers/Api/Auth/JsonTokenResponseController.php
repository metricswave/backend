<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\JsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Users\User;

class JsonTokenResponseController extends JsonController
{
    protected function tokenResponse(User $user, string $deviceName, int $code = 200): JsonResponse
    {
        return $this->response($user->createTokens($deviceName), $code);
    }
}
