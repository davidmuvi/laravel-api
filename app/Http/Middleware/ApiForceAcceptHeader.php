<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiForceAcceptHeader
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
{
    $acceptHeader = $request->header('Accept');

    if ($acceptHeader !== 'application/json') {
        $request->headers->set('Accept', 'application/json');
    }

    return $next($request);
}
}
