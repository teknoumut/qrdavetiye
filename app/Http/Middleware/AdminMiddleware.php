<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(! auth()->check() || ! auth()->user()->is_admin, 403, 'Unauthorized');

        return $next($request);
    }
}
