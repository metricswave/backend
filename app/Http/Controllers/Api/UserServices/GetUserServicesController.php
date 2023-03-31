<?php

namespace App\Http\Controllers\Api\UserServices;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetUserServicesController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response([
            'services' => $this->user()->services,
        ]);
    }
}
