<?php

namespace App\Services\Payment;

use App\Models\PaymentSetting;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeService implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $publicKey;

    public function __construct()
    {
        $settings = PaymentSetting::current();
        $dbSecret = $settings->stripe_secret;
        $dbKey = $settings->stripe_key;

        $this->secretKey = $dbSecret ?: config('services.stripe.secret');
        $this->publicKey = $dbKey ?: config('services.stripe.key');
        
        Stripe::setApiKey($this->secretKey);
    }

    /**
     * Create a payment intent
     */
    public function createPayment(float $amount, string $currency, array $metadata = []): array
    {
        try {
            $amountInCents = (int)($amount * 100); // Convert to cents

            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => strtolower($currency),
                'metadata' => $metadata,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'success' => true,
                'payment_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
                'public_key' => $this->publicKey,
                'data' => $paymentIntent->toArray(),
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment creation failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getStripeCode(),
            ];
        }
    }

    /**
     * Verify a payment
     */
    public function verifyPayment(string $paymentId, array $data = []): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentId);

            return [
                'success' => true,
                'payment_id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100, // Convert from cents
                'currency' => strtoupper($paymentIntent->currency),
                'payment_method' => $paymentIntent->payment_method_types[0] ?? 'card',
                'metadata' => $paymentIntent->metadata->toArray(),
                'data' => $paymentIntent->toArray(),
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment verification failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getStripeCode(),
            ];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $paymentId, ?float $amount = null): array
    {
        try {
            $params = [
                'payment_intent' => $paymentId,
            ];

            if ($amount !== null) {
                $params['amount'] = (int)($amount * 100); // Convert to cents
            }

            $refund = Refund::create($params);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100, // Convert from cents
                'status' => $refund->status,
                'data' => $refund->toArray(),
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe refund failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getStripeCode(),
            ];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array
    {
        return $this->verifyPayment($paymentId);
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhook(string $payload, string $signature): bool
    {
        $settings = PaymentSetting::current();
        $webhookSecret = $settings->stripe_webhook_secret ?: config('services.stripe.webhook_secret');
        
        if (!$webhookSecret) {
            return false;
        }

        try {
            \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );
            return true;
        } catch (\Exception $e) {
            Log::error('Stripe webhook verification failed: ' . $e->getMessage());
            return false;
        }
    }
}

