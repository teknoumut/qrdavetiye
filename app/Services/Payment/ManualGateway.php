<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Plan;
use App\Models\User;

class ManualGateway implements PaymentGateway
{
    public function getName(): string
    {
        return 'manual';
    }

    public function initialize(User $user, Plan $plan, string $interval, ?float $customAmount = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'manual_'.uniqid(),
            message: 'Ödeme başarılı.',
        );
    }

    public function verify(array $data): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: $data['transaction_id'] ?? 'manual_verified',
        );
    }
}
