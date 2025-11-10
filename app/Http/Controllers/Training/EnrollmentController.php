<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Services\Payment\PaymentHelper;
use App\Models\PaymentSetting;
use App\Support\Money;
use App\Support\AdminNotifier;
use App\Notifications\Admin\NewEnrollmentNotification;
use App\Notifications\Admin\PaymentStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $request->validate([
            'gateway' => 'required|in:stripe,razorpay',
            'accept_terms' => 'accepted',
        ], [
            'accept_terms.accepted' => 'You must accept terms and policies to continue.'
        ]);

        $training = ContentItem::where('type', 'training')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        if (!$training->isEnrollable() || !$training->hasAvailableSpots()) {
            return back()->withErrors(['training' => 'This training is not available for enrollment.']);
        }

        $user = Auth::user();

        // Create enrollment with pending status
        $currencyCode = $training->resolvedCurrencyCode() ?: (PaymentSetting::current()->currency ?? Money::defaultCode());

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'training_id' => $training->id,
            'payment_method' => $request->gateway,
            'amount' => $training->price ?? 0,
            'currency' => $currencyCode,
            'status' => 'pending',
            'terms_accepted' => true,
            'terms_accepted_at' => now(),
        ]);

        AdminNotifier::notify(new NewEnrollmentNotification($enrollment));

        // Initiate payment via selected gateway
        $gateway = PaymentHelper::gateway($request->gateway);
        $paymentInit = $gateway->createPayment((float)$enrollment->amount, $enrollment->currency, [
            'enrollment_id' => $enrollment->id,
            'user_id' => $user->id,
            'training_id' => $training->id,
        ]);

        if (!($paymentInit['success'] ?? false)) {
            return back()->withErrors(['payment' => $paymentInit['error'] ?? 'Payment initialization failed.']);
        }

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'enrollment_id' => $enrollment->id,
            'gateway' => $request->gateway,
            'gateway_payment_id' => $paymentInit['payment_id'] ?? ($paymentInit['order_id'] ?? ''),
            'amount' => $enrollment->amount,
            'currency' => $enrollment->currency,
            'status' => 'pending',
            'payment_method' => null,
            'metadata' => $paymentInit['data'] ?? [],
        ]);

        AdminNotifier::notify(new PaymentStatusNotification($payment, 'Pending', 'Awaiting gateway confirmation.'));

        // Render checkout with appropriate params
        return view('payment.checkout', [
            'gateway' => $request->gateway,
            'training' => $training,
            'enrollment' => $enrollment,
            'payment' => $payment,
            'init' => $paymentInit,
        ]);
    }
}
