<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use InvalidArgumentException;
use RuntimeException;

class PaymentGatewayManager
{
    private array $gateways = [];

    public function register(string $name, PaymentGateway $gateway): void
    {
        $this->gateways[$name] = $gateway;
    }

    public function gateway(?string $name = null): PaymentGateway
    {
        $name ??= config('payment.gateway', 'manual');

        if (config('app.env') === 'production' && $name === 'manual') {
            throw new RuntimeException(
                'Manual payment gateway is disabled in production. Set PAYMENT_GATEWAY=iyzico in your .env file.'
            );
        }

        if (! isset($this->gateways[$name])) {
            throw new InvalidArgumentException("Payment gateway [{$name}] is not registered.");
        }

        return $this->gateways[$name];
    }

    public function all(): array
    {
        return $this->gateways;
    }
}
