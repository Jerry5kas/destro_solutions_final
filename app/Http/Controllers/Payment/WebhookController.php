<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\PaymentHelper;
use App\Services\Payment\StripeService;
use App\Services\Payment\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function stripe(Request $request, StripeService $stripe)
    {
        $signature = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        if (!$stripe->verifyWebhook($payload, $signature)) {
            return response('Invalid signature', 400);
        }

        $event = json_decode($payload, true);
        if (($event['type'] ?? null) === 'payment_intent.succeeded') {
            $pi = $event['data']['object'] ?? [];
            $payment = Payment::where('gateway_payment_id', $pi['id'] ?? '')->latest()->first();
            if ($payment) {
                PaymentHelper::processSuccessfulPayment($payment);
            }
        }

        return response('OK');
    }

    public function razorpay(Request $request, RazorpayService $razorpay)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        if (!$razorpay->verifyWebhook($payload, $signature)) {
            return response('Invalid signature', 400);
        }

        $data = json_decode($payload, true);
        $entity = $data['payload']['payment']['entity'] ?? [];
        $paymentId = $entity['id'] ?? null;

        if ($paymentId && (($entity['status'] ?? null) === 'captured')) {
            $payment = Payment::where('gateway_payment_id', $paymentId)->latest()->first();
            if ($payment) {
                PaymentHelper::processSuccessfulPayment($payment);
            }
        }

        return response('OK');
    }
}
