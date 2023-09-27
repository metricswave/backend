<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use MetricsWave\Users\User;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function user(): User
    {
        return Auth::user();
    }
}
