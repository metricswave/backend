<?php

namespace MetricsWave\Channels\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Channels\Http\Requests\CreateTeamChannelRequest;
use MetricsWave\Teams\Team;

class PostTeamChannelsController extends ApiAuthJsonController
{
    public function __invoke(Team $team, CreateTeamChannelRequest $request): JsonResponse
    {
        abort_unless(
            $this->user()->all_teams->where('id', $team->id)->isNotEmpty(),
            403,
            'You do not have access to this team.'
        );

        $team->channels()->create([
            'channel_id' => $request->channel_id,
            'data' => [
                'configuration' => $request->fields,
            ],
        ]);

        return $this->createdResponse();
    }
}
