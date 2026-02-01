<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SignUpController extends JsonTokenResponseController
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->errorResponse(
            'MetricsWave is shutting down. New registrations are no longer accepted. The service will be discontinued in June 2025.',
            410,
        );
    }
}
