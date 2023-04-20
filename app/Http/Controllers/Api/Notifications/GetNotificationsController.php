<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetNotificationsController extends ApiAuthJsonController
{
    public function __invoke(): LengthAwarePaginator
    {
        return $this->user()->notifications()->paginate(30);
    }
}
