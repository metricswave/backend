<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MetricsWave\Teams\Team;

class GetNotificationsController extends ApiAuthJsonController
{
    public function __invoke(Team $team, Request $request): LengthAwarePaginator
    {
        return $team->owner
            ->notifications()
            ->forceIndex('notifications_notifiable_type_notifiable_id_created_at_index')
            ->where('team_id', $team->id)
            ->when(
                $request->get('user_parameter', false),
                function (Builder $query) use ($request) {
                    $query->where('user_parameter', $request->get('user_parameter'));
                }
            )
            ->paginate(30);
    }
}
