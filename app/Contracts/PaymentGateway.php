<?php

namespace App\Contracts;

use App\Models\Plan;
use App\Models\User;

class PaymentResult
{
    public function __construct(
        public bool $success,
        public ?string $redirectUrl = null,
        public ?string $message = null,
        public ?string $transactionId = null,
    ) {}
}

interface PaymentGateway
{
    public function getName(): string;

    public function initialize(User $user, Plan $plan, string $interval, ?float $customAmount = null): PaymentResult;

    public function verify(array $data): PaymentResult;
}
