<?php

namespace App\Services\Payment;

use App\Models\PaymentSetting;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Log;

class RazorpayService implements PaymentGatewayInterface
{
    protected Api $api;
    protected string $keyId;
    protected string $keySecret;

    public function __construct()
    {
        $settings = PaymentSetting::current();
        $this->keyId = $settings->razorpay_key ?: config('services.razorpay.key');
        $this->keySecret = $settings->razorpay_secret ?: config('services.razorpay.secret');
        
        $this->api = new Api($this->keyId, $this->keySecret);
    }

    /**
     * Create a payment order
     */
    public function createPayment(float $amount, string $currency, array $metadata = []): array
    {
        try {
            $amountInPaise = (int)($amount * 100); // Convert to paise (smallest currency unit)

            $orderData = [
                'receipt' => 'order_' . time(),
                'amount' => $amountInPaise,
                'currency' => strtoupper($currency),
                'notes' => $metadata,
            ];

            $order = $this->api->order->create($orderData);

            return [
                'success' => true,
                'payment_id' => $order['id'],
                'order_id' => $order['id'],
                'amount' => $order['amount'] / 100, // Convert from paise
                'currency' => $order['currency'],
                'key_id' => $this->keyId,
                'data' => $order,
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify a payment
     */
    public function verifyPayment(string $paymentId, array $data = []): array
    {
        try {
            // For Razorpay, we need payment_id and signature to verify
            if (empty($data['razorpay_payment_id']) || empty($data['razorpay_signature'])) {
                return [
                    'success' => false,
                    'error' => 'Payment ID and signature are required for verification',
                ];
            }

            $attributes = [
                'razorpay_order_id' => $paymentId,
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature' => $data['razorpay_signature'],
            ];

            // Verify signature
            $this->api->utility->verifyPaymentSignature($attributes);

            // Get payment details
            $payment = $this->api->payment->fetch($data['razorpay_payment_id']);

            return [
                'success' => true,
                'payment_id' => $payment['id'],
                'order_id' => $payment['order_id'],
                'status' => $payment['status'],
                'amount' => $payment['amount'] / 100, // Convert from paise
                'currency' => strtoupper($payment['currency']),
                'payment_method' => $payment['method'] ?? 'unknown',
                'metadata' => $payment['notes'] ?? [],
                'data' => $payment->toArray(),
            ];
        } catch (SignatureVerificationError $e) {
            Log::error('Razorpay signature verification failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Payment signature verification failed',
                'error_code' => 'SIGNATURE_VERIFICATION_FAILED',
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay payment verification failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $paymentId, ?float $amount = null): array
    {
        try {
            $params = [];

            if ($amount !== null) {
                $params['amount'] = (int)($amount * 100); // Convert to paise
            }

            $refund = $this->api->payment->fetch($paymentId)->refund($params);

            return [
                'success' => true,
                'refund_id' => $refund['id'],
                'amount' => $refund['amount'] / 100, // Convert from paise
                'status' => $refund['status'],
                'data' => $refund->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay refund failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);

            return [
                'success' => true,
                'payment_id' => $payment['id'],
                'status' => $payment['status'],
                'amount' => $payment['amount'] / 100, // Convert from paise
                'currency' => strtoupper($payment['currency']),
                'payment_method' => $payment['method'] ?? 'unknown',
                'data' => $payment->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay payment status check failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhook(string $payload, string $signature): bool
    {
        $settings = PaymentSetting::current();
        $webhookSecret = $settings->razorpay_webhook_secret ?: config('services.razorpay.webhook_secret');
        
        if (!$webhookSecret) {
            return false;
        }

        try {
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
            return hash_equals($expectedSignature, $signature);
        } catch (\Exception $e) {
            Log::error('Razorpay webhook verification failed: ' . $e->getMessage());
            return false;
        }
    }
}

