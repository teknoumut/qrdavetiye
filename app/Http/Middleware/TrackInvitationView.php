<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackInvitationView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->route() && $request->route()->hasParameter('invitation')) {
            $invitation = $request->route()->parameter('invitation');
            if ($invitation && method_exists($invitation, 'increment')) {
                $invitation->increment('views');
            }
        }

        return $response;
    }
}
