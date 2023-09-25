<?php

namespace App\Http\Controllers\Api\Open;

use App\Http\Controllers\Api\JsonController;
use App\Http\Controllers\Open\HasOpenData;
use Illuminate\Http\JsonResponse;

class GetOpenDataController extends JsonController
{
    use HasOpenData;

    public function __invoke(): JsonResponse
    {
        return $this->response($this->getOpenData());
    }
}
