<?php

namespace MetricsWave\Channels\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Teams\Team;

class DeleteTeamChannelController extends ApiAuthJsonController
{
    public function __invoke(Team $team, TeamChannel $channel): JsonResponse
    {
        abort_unless(
            $this->user()->all_teams->where('id', $channel->team_id)->isNotEmpty(),
            403,
            'You do not have access to this team.'
        );

        $channel->delete();

        return $this->noContentResponse();
    }
}
