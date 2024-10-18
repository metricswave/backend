<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Api\ApiAuthJsonController;
use Illuminate\Http\JsonResponse;
use MetricsWave\Teams\Team;

class GetPortalPathController extends ApiAuthJsonController
{
    public function __invoke(Team $team): JsonResponse
    {
        $redirectParam = request()->query('redirect-to', '/');
        $redirectTo = config('app.web_app_url').$redirectParam.'?fromBillingPortal=true';

        return $this->response([
            'path' => $team->billingPortalUrl($redirectTo),
        ]);
    }
}
