<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Services\Users\CreateDefaultsForUser;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class PostUserDefaultsController extends ApiAuthJsonController
{
    public function __construct(readonly private CreateDefaultsForUser $defaultCreator)
    {
        parent::__construct();
    }

    public function __invoke(): JsonResponse
    {
        if ($this->user()->ownedTeams()->count() > 0) {
            return $this->noContentResponse();
        }

        /** @var Team $team */
        $team = $this->user()->ownedTeams()->create([
            'domain' => 'default.dev',
            'initiated' => false,
        ]);

        ($this->defaultCreator)($team);

        return $this->createdResponse();
    }
}
