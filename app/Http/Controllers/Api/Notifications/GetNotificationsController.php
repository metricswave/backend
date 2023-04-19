<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetNotificationsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response($this->user()->notifications->toArray());
    }
}
