<?php

namespace App\Http\Middleware;

use App\Http\Services\SubscriptionService;
use App\Models\Plan;
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

        if ($user->is_admin) {
            return $next($request);
        }

        if (! $user->plan_id) {
            $trialPlan = Plan::where('name', 'Deneme')->first();

            if (! $trialPlan) {
                $trialPlan = Plan::create([
                    'name' => 'Deneme',
                    'description' => '3 günlük ücretsiz deneme. Sınırlı özellik, 1 davetiye.',
                    'monthly_price' => 0,
                    'yearly_price' => 0,
                    'max_invitations' => 1,
                    'max_images_per_invitation' => 3,
                    'music_feature' => false,
                    'video_feature' => false,
                    'cover_video_feature' => false,
                    'rsvp_feature' => true,
                    'qr_download' => true,
                    'is_active' => true,
                ]);
            }

            $user->update([
                'plan_id' => $trialPlan->id,
                'subscription_start' => now(),
                'subscription_end' => now()->addDays(3),
                'subscription_status' => User::STATUS_ACTIVE,
            ]);

            $user->refresh();
        }

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

        return $next($request);
    }
}
