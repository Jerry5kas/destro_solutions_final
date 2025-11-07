<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Create a payment intent/order
     *
     * @param float $amount
     * @param string $currency
     * @param array $metadata
     * @return array
     */
    public function createPayment(float $amount, string $currency, array $metadata = []): array;

    /**
     * Verify a payment
     *
     * @param string $paymentId
     * @param array $data
     * @return array
     */
    public function verifyPayment(string $paymentId, array $data = []): array;

    /**
     * Refund a payment
     *
     * @param string $paymentId
     * @param float|null $amount
     * @return array
     */
    public function refundPayment(string $paymentId, ?float $amount = null): array;

    /**
     * Get payment status
     *
     * @param string $paymentId
     * @return array
     */
    public function getPaymentStatus(string $paymentId): array;
}

