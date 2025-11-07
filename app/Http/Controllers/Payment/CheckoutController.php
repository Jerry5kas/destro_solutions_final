<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\PaymentHelper;
use App\Services\Payment\PaymentServiceManager;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function success(Request $request)
    {
        $paymentId = $request->get('payment_id') ?? $request->get('razorpay_payment_id');
        $orderId = $request->get('order_id') ?? $request->get('razorpay_order_id');
        $gateway = $request->get('gateway');

        if (!$paymentId || !$gateway) {
            return redirect()->route('user.dashboard')->with('error', 'Missing payment details.');
        }

        $payment = Payment::where('gateway_payment_id', $orderId ?: $paymentId)->orWhere('gateway_payment_id', $paymentId)->latest()->first();
        if (!$payment) {
            return redirect()->route('user.dashboard')->with('error', 'Payment not found.');
        }

        $service = PaymentServiceManager::gateway($gateway);
        $verification = $service->verifyPayment($orderId ?: $paymentId, $request->all());

        if (($verification['success'] ?? false) && in_array(($verification['status'] ?? ''), ['succeeded', 'captured', 'paid'], true)) {
            PaymentHelper::processSuccessfulPayment($payment);
            return redirect()->route('user.dashboard')->with('success', 'Payment successful. Enrollment activated.');
        }

        return redirect()->route('user.dashboard')->with('error', 'Payment verification failed.');
    }

    public function failed(Request $request)
    {
        $paymentId = $request->get('payment_id') ?? $request->get('razorpay_payment_id');
        $gateway = $request->get('gateway');

        if ($paymentId) {
            $payment = Payment::where('gateway_payment_id', $paymentId)->latest()->first();
            if ($payment) {
                PaymentHelper::processFailedPayment($payment, $request->get('reason'));
            }
        }

        return redirect()->route('user.dashboard')->with('error', 'Payment failed or was cancelled.');
    }
}
