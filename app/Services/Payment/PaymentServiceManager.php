<?php

namespace App\Services\Payment;

use App\Models\PaymentSetting;

class PaymentServiceManager
{
    /**
     * Get payment gateway service instance
     */
    public static function gateway(string $gateway = null): PaymentGatewayInterface
    {
        $settings = PaymentSetting::current();
        $gateway = $gateway ?? ($settings->default_gateway ?? config('payment.default_gateway', 'stripe'));

        return match (strtolower($gateway)) {
            'stripe' => new StripeService(),
            'razorpay' => new RazorpayService(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}"),
        };
    }

    /**
     * Check if gateway is enabled
     */
    public static function isGatewayEnabled(string $gateway): bool
    {
        $settings = PaymentSetting::current();
        return match (strtolower($gateway)) {
            'stripe' => (bool) $settings->stripe_enabled,
            'razorpay' => (bool) $settings->razorpay_enabled,
            default => false,
        };
    }

    /**
     * Get available gateways
     */
    public static function getAvailableGateways(): array
    {
        $settings = PaymentSetting::current();
        $available = [];
        if ($settings->stripe_enabled) { $available['stripe'] = ['name' => 'Stripe']; }
        if ($settings->razorpay_enabled) { $available['razorpay'] = ['name' => 'Razorpay']; }
        return $available;
    }
}

