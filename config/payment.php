<?php

return [
    'gateway' => env('PAYMENT_GATEWAY', 'manual'),

    'production_gateway' => env('PAYMENT_GATEWAY', 'iyzico'),

    'gateways' => [
        'manual' => [
            'driver' => 'manual',
        ],
        'iyzico' => [
            'driver' => 'iyzico',
            'api_key' => env('IYZICO_API_KEY', ''),
            'secret_key' => env('IYZICO_SECRET_KEY', ''),
            'base_url' => env('IYZICO_BASE_URL', 'https://sandbox-api.iyzipay.com'),
            'identity_number' => env('IYZICO_IDENTITY_NUMBER', '11111111111'),
        ],
    ],
];
