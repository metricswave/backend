<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Api\JsonController;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class GetServicesController extends JsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response([
            'services' => Service::all(),
        ]);
    }
}
