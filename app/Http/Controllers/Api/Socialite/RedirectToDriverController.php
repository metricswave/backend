<?php

namespace App\Http\Controllers\Api\Socialite;

use App\Http\Controllers\Api\JsonController;
use App\Models\Service;
use App\Transfers\ServiceId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Socialite;

class RedirectToDriverController extends JsonController
{
    public function __invoke(Service $service): JsonResponse
    {
        $creating = null === request()->header('Authorization');
        $scopes = $service->scopesFor($creating);

        $driver = Socialite::driver($service->driver)
            ->stateless()
            ->scopes($scopes);

        if ($service->id === ServiceId::Google->value) {
            $driver->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
        }

        /** @var RedirectResponse $path */
        $path = $driver->redirect();

        return $this->response([
            'path' => $path->getTargetUrl(),
        ]);
    }
}
