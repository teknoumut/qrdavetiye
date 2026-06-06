<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    public function activate(User $user, Plan $plan, string $interval = 'monthly'): void
    {
        $now = Carbon::now();
        $start = $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()
            ? Carbon::parse($user->subscription_end)
            : $now;

        $days = $interval === 'yearly' ? 365 : 30;
        $end = $start->copy()->addDays($days);

        $user->update([
            'plan_id' => $plan->id,
            'subscription_start' => $user->subscription_start ?? $now,
            'subscription_end' => $end,
            'subscription_status' => User::STATUS_ACTIVE,
            'renews_at' => $end,
            'cancelled_at' => null,
            'is_active' => true,
        ]);
    }

    public function cancel(User $user): void
    {
        if ($user->subscription_status !== User::STATUS_ACTIVE) {
            return;
        }

        $user->update([
            'subscription_status' => User::STATUS_CANCELLED,
            'cancelled_at' => Carbon::now(),
            'renews_at' => null,
        ]);
    }

    public function expire(User $user): void
    {
        if (! in_array($user->subscription_status, [User::STATUS_ACTIVE, User::STATUS_CANCELLED])) {
            return;
        }

        $user->update([
            'subscription_status' => User::STATUS_EXPIRED,
        ]);
    }

    public function reactivate(User $user): void
    {
        if ($user->subscription_status !== User::STATUS_CANCELLED) {
            return;
        }

        if ($user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()) {
            $user->update([
                'subscription_status' => User::STATUS_ACTIVE,
                'cancelled_at' => null,
                'renews_at' => $user->subscription_end,
            ]);
        }
    }
}
