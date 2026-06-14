<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    public function upgrade(User $user, Plan $newPlan): void
    {
        $now = Carbon::now();

        $user->update([
            'plan_id' => $newPlan->id,
            'subscription_start' => $user->subscription_start ?? $now,
            'subscription_status' => User::STATUS_ACTIVE,
            'cancelled_at' => null,
            'is_active' => true,
        ]);
    }

    public function activate(User $user, Plan $plan, string $interval = 'monthly'): void
    {
        if ($user->subscription_status === User::STATUS_ACTIVE
            && $user->subscription_end
            && Carbon::parse($user->subscription_end)->isFuture()
        ) {
            throw new \RuntimeException('Mevcut aboneliğiniz devam ederken yeni bir paket satın alamazsınız. Lütfen önce mevcut aboneliğinizi iptal edin.');
        }

        $now = Carbon::now();
        $days = $interval === 'yearly' ? 365 : 30;
        $end = $now->copy()->addDays($days);

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
