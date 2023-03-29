<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\JsonController;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class JsonTokenResponse extends JsonController
{
    protected function tokenResponse(User $user, string $deviceName, int $code = 200): JsonResponse
    {
        return $this->response($user->createTokens($deviceName), $code);
    }
}
