<?php

namespace MetricsWave\Teams\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Services\Users\CreateDefaultsForUser;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Http\Controllers\Requests\CreateTeamRequest;
use MetricsWave\Teams\Team;

class PostTeamsController extends ApiAuthJsonController
{
    public function __construct(readonly private CreateDefaultsForUser $defaultCreator)
    {
        parent::__construct();
    }

    public function __invoke(CreateTeamRequest $request): JsonResponse
    {
        /** @var Team $team */
        $team = $this->user()->ownedTeams()->create([
            ...$request->validated(),
            'initiated' => false,
        ]);

        ($this->defaultCreator)($team, $request->domain);

        return $this->createdResponse();
    }
}
