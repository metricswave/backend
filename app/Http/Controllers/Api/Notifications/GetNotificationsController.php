<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use MetricsWave\Teams\Team;

class GetNotificationsController extends ApiAuthJsonController
{
    public function __invoke(Team $team): LengthAwarePaginator
    {
        return $team->owner->notifications()->paginate(30);
    }
}
