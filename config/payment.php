<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway that will be used
    | for processing payments. You can change this to 'razorpay' if needed.
    |
    */

    'default_gateway' => env('PAYMENT_DEFAULT_GATEWAY', 'stripe'),

    /*
    |--------------------------------------------------------------------------
    | Supported Payment Gateways
    |--------------------------------------------------------------------------
    |
    | List of supported payment gateways in the system.
    |
    */

    'gateways' => [
        'stripe' => [
            'name' => 'Stripe',
            'enabled' => env('STRIPE_ENABLED', true),
        ],
        'razorpay' => [
            'name' => 'Razorpay',
            'enabled' => env('RAZORPAY_ENABLED', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency and supported currencies for payments.
    |
    */

    'currency' => [
        'default' => env('PAYMENT_CURRENCY', 'USD'),
        'supported' => ['USD', 'EUR', 'GBP', 'INR'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    |
    | General payment processing settings.
    |
    */

    'settings' => [
        'min_amount' => env('PAYMENT_MIN_AMOUNT', 1.00),
        'max_amount' => env('PAYMENT_MAX_AMOUNT', 100000.00),
        'timeout_minutes' => env('PAYMENT_TIMEOUT_MINUTES', 30),
    ],
];

