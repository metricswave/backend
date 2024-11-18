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
        $userParameter = $request->get('user_parameter', false);

        return $team->owner
            ->notifications()
            ->forceIndex(
                $userParameter ? 'all_index' : 'notifications_notifiable_type_notifiable_id_created_at_index'
            )
            ->where('team_id', $team->id)
            ->when(
                $userParameter,
                function (Builder $query) use ($userParameter) {
                    $query->where('user_parameter', $userParameter);
                }
            )
            ->paginate(30);
    }
}
