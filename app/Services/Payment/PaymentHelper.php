<?php

namespace App\Services\Payment;

use App\Models\Payment as PaymentModel;
use App\Models\Enrollment;
use App\Models\PaymentSetting;
use App\Support\Money;
use Illuminate\Support\Facades\DB;
use App\Support\AdminNotifier;
use App\Notifications\Admin\PaymentStatusNotification;

class PaymentHelper
{
    /**
     * Get payment gateway service instance
     */
    public static function gateway(string $gateway = null): PaymentGatewayInterface
    {
        return PaymentServiceManager::gateway($gateway);
    }

    /**
     * Create payment record in database
     */
    public static function createPaymentRecord(array $data): PaymentModel
    {
        $defaultCurrency = PaymentSetting::current()->currency ?? config('payment.currency.default', 'INR');

        return PaymentModel::create([
            'user_id' => $data['user_id'],
            'enrollment_id' => $data['enrollment_id'] ?? null,
            'gateway' => $data['gateway'],
            'gateway_payment_id' => $data['gateway_payment_id'],
            'amount' => $data['amount'],
            'currency' => strtoupper($data['currency'] ?? $defaultCurrency),
            'status' => $data['status'] ?? 'pending',
            'payment_method' => $data['payment_method'] ?? null,
            'metadata' => $data['metadata'] ?? [],
        ]);
    }

    /**
     * Update payment status
     */
    public static function updatePaymentStatus(
        PaymentModel $payment,
        string $status,
        array $additionalData = []
    ): bool {
        $updateData = array_merge([
            'status' => $status,
        ], $additionalData);

        if ($status === 'succeeded' && !$payment->paid_at) {
            $updateData['paid_at'] = now();
        }

        return $payment->update($updateData);
    }

    /**
     * Process successful payment
     */
    public static function processSuccessfulPayment(PaymentModel $payment): bool
    {
        return DB::transaction(function () use ($payment) {
            // Update payment status
            self::updatePaymentStatus($payment, 'succeeded');

            // Update enrollment status if exists
            if ($payment->enrollment_id) {
                $enrollment = Enrollment::find($payment->enrollment_id);
                if ($enrollment) {
                    $enrollment->update([
                        'status' => 'paid',
                        'enrolled_at' => now(),
                        'payment_id' => $payment->gateway_payment_id,
                    ]);
                }
            }

            AdminNotifier::notify(new PaymentStatusNotification($payment->fresh(), 'Succeeded', 'Payment captured successfully.'));

            return true;
        });
    }

    /**
     * Process failed payment
     */
    public static function processFailedPayment(PaymentModel $payment, string $reason = null): bool
    {
        return DB::transaction(function () use ($payment, $reason) {
            // Update payment status
            self::updatePaymentStatus($payment, 'failed', [
                'failure_reason' => $reason,
            ]);

            // Update enrollment status if exists
            if ($payment->enrollment_id) {
                $enrollment = Enrollment::find($payment->enrollment_id);
                if ($enrollment) {
                    $enrollment->update([
                        'status' => 'failed',
                    ]);
                }
            }

            $note = $reason ? sprintf('Reason: %s', $reason) : null;
            AdminNotifier::notify(new PaymentStatusNotification($payment->fresh(), 'Failed', $note));

            return true;
        });
    }

    /**
     * Format amount for display
     */
    public static function formatAmount(float $amount, string $currency = 'INR'): string
    {
        return Money::format($amount, $currency);
    }
}

