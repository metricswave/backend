<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectOldNotifyWaveDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getHost() === 'notifywave.com') {
            return redirect()->to('https://metricswave.com'.$request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
