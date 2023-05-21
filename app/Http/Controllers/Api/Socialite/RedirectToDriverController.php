<?php

namespace App\Http\Controllers\Api\Socialite;

use App\Http\Controllers\Api\JsonController;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Socialite;

class RedirectToDriverController extends JsonController
{
    public function __invoke(Service $service): JsonResponse
    {
        $creating = null === request()->header('Authorization');
        $scopes = $service->scopesFor($creating);

        /** @var RedirectResponse $path */
        $path = Socialite::driver($service->driver)
            ->stateless()
            ->scopes($scopes)
            ->redirect();

        return $this->response([
            'path' => $path->getTargetUrl(),
        ]);
    }
}
