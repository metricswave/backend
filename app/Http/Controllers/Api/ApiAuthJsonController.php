<?php

namespace App\Http\Controllers\Api;

use App\Models\TokenAbility;

class ApiAuthJsonController extends JsonController
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:'.TokenAbility::API]);
    }
}
