<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'stripe_enabled',
        'razorpay_enabled',
        'default_gateway',
        'stripe_key',
        'stripe_secret',
        'stripe_webhook_secret',
        'razorpay_key',
        'razorpay_secret',
        'razorpay_webhook_secret',
        'currency',
    ];

    protected $casts = [
        'stripe_enabled' => 'boolean',
        'razorpay_enabled' => 'boolean',
        'stripe_secret' => 'encrypted',
        'stripe_webhook_secret' => 'encrypted',
        'razorpay_secret' => 'encrypted',
        'razorpay_webhook_secret' => 'encrypted',
    ];

    public static function current(): self
    {
        return self::query()->first() ?? new self([
            'stripe_enabled' => config('payment.gateways.stripe.enabled', true),
            'razorpay_enabled' => config('payment.gateways.razorpay.enabled', true),
            'default_gateway' => config('payment.default_gateway', 'stripe'),
            'currency' => config('payment.currency.default', 'USD'),
        ]);
    }
}
