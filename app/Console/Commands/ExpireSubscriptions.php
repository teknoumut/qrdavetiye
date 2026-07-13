<?php

namespace App\Console\Commands;

use App\Http\Services\SubscriptionService;
use App\Models\User;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';

    protected $description = 'Süresi dolan abonelikleri expire et';

    public function handle(SubscriptionService $service): void
    {
        $expired = User::where('subscription_end', '<=', now())
            ->whereIn('subscription_status', [User::STATUS_ACTIVE, User::STATUS_CANCELLED])
            ->get();

        $count = 0;
        foreach ($expired as $user) {
            $service->expire($user);
            $count++;
        }

        $this->info("$count abonelik süresi doldu olarak işaretlendi.");
    }
}
