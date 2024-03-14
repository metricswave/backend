<?php

namespace MetricsWave\Users\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;
use MetricsWave\Users\Services\CreateDefaultsForUser;

class PostUserDefaultsController extends ApiAuthJsonController
{
    public function __construct(readonly private CreateDefaultsForUser $defaultCreator)
    {
        parent::__construct();
    }

    public function __invoke(): JsonResponse
    {
        if ($this->user()->ownedTeams()->count() > 0) {
            $team = $this->user()->ownedTeams()->first();
        } else {
            /** @var Team $team */
            $team = $this->user()->ownedTeams()->create([
                'domain' => 'default.dev',
                'initiated' => false,
            ]);
        }

        ($this->defaultCreator)($team);

        return $this->createdResponse();
    }
}
