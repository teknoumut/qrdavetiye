<?php

namespace App\Http\Middleware;

use App\Http\Services\SubscriptionService;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->is_active && ! $user->is_admin) {
            return redirect()->route('home')->with('error', 'Hesabınız pasif durumda. Lütfen yöneticinizle iletişime geçin.');
        }

        // Auto-expire if subscription_end has passed
        if ($user->subscription_end && now()->greaterThan($user->subscription_end)) {
            if (in_array($user->subscription_status, [User::STATUS_ACTIVE, User::STATUS_CANCELLED])) {
                $service = new SubscriptionService;
                $service->expire($user);
                $user->refresh();
            }
        }

        $expired = $user->subscription_status !== User::STATUS_ACTIVE
            || ($user->subscription_end && now()->greaterThan($user->subscription_end));

        if ($expired && ! $user->is_admin) {
            $request->attributes->set('subscription_expired', true);
        }

        if (! $user->plan_id && ! $user->is_admin) {
            $request->attributes->set('needs_subscription', true);
        }

        return $next($request);
    }
}
