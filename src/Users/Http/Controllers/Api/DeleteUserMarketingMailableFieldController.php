<?php

namespace MetricsWave\Users\Http\Controllers\Api;

use App\Http\Controllers\Api\JsonController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MetricsWave\Users\Repositories\UserRepository;

class DeleteUserMarketingMailableFieldController extends JsonController
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $token = $request->input('token');

        $user = $this->repository->userByToken($token);

        $user->update([
            'marketing_mailable' => false,
        ]);

        return $this->noContentResponse();
    }
}
