<?php

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Services\Payment\IyzipayGateway;
use App\Services\Payment\ManualGateway;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentGatewayManager::class, function ($app) {
            $manager = new PaymentGatewayManager;

            $manager->register('iyzico', new IyzipayGateway);

            if (! $app->environment('production')) {
                $manager->register('manual', new ManualGateway);
            }

            return $manager;
        });

        $this->app->bind(PaymentGateway::class, function ($app) {
            return $app->make(PaymentGatewayManager::class)->gateway();
        });
    }

    public function boot(): void
    {
        //
    }
}
