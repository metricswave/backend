<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        App::setLocale($request->route('locale', 'en'));

        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
