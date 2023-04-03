<?php

namespace App\Http\Controllers\Api\Triggers;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;

class GetTriggersController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        return $this->response([
            'triggers' => $this->user()->triggers()->with('triggerType')->get(),
        ]);
    }
}
