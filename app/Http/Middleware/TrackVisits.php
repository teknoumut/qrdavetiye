<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is('admin/*') && ! $request->is('_debugbar/*') && ! $request->ajax()) {
            $ip = $request->ip();

            $location = cache()->remember('ip_loc_'.str_replace('.', '_', $ip), 86400, function () use ($ip) {
                try {
                    $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country,city,isp,query");
                    if ($response->successful() && $response->json('status') === 'success') {
                        return [
                            'country' => $response->json('country'),
                            'city' => $response->json('city'),
                            'isp' => $response->json('isp'),
                        ];
                    }
                } catch (\Throwable $e) {
                    // Silently fail
                }

                return null;
            });

            $existing = PageVisit::where('ip', $ip)->whereDate('created_at', today())->exists();

            if (! $existing) {
                PageVisit::create([
                    'ip' => $ip,
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'country' => $location['country'] ?? null,
                    'city' => $location['city'] ?? null,
                    'isp' => $location['isp'] ?? null,
                ]);
            }
        }

        return $next($request);
    }
}
