<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Services\Payment\PaymentServiceManager;
use App\Services\Payment\PaymentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'enrollment.training']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by gateway
        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by user email or payment ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('gateway_payment_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Payment::count(),
            'succeeded' => Payment::where('status', 'succeeded')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'total_revenue' => Payment::where('status', 'succeeded')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['user', 'enrollment.training'])->findOrFail($id);
        
        // Get payment status from gateway if needed
        $gatewayStatus = null;
        if ($payment->status === 'pending') {
            try {
                $gateway = PaymentServiceManager::gateway($payment->gateway);
                $status = $gateway->getPaymentStatus($payment->gateway_payment_id);
                $gatewayStatus = $status;
            } catch (\Exception $e) {
                // Gateway check failed, use stored status
            }
        }

        return view('admin.payments.show', compact('payment', 'gatewayStatus'));
    }

    /**
     * Verify payment manually.
     */
    public function verify($id)
    {
        $payment = Payment::findOrFail($id);

        try {
            $gateway = PaymentServiceManager::gateway($payment->gateway);
            $verification = $gateway->getPaymentStatus($payment->gateway_payment_id);

            if (($verification['success'] ?? false) && in_array(($verification['status'] ?? ''), ['succeeded', 'captured', 'paid'], true)) {
                PaymentHelper::processSuccessfulPayment($payment);
                return redirect()->route('admin.payments.show', $payment->id)
                    ->with('success', 'Payment verified and updated successfully.');
            } else {
                return redirect()->route('admin.payments.show', $payment->id)
                    ->with('error', 'Payment verification failed. Status: ' . ($verification['status'] ?? 'unknown'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.show', $payment->id)
                ->with('error', 'Verification error: ' . $e->getMessage());
        }
    }

    /**
     * Process refund.
     */
    public function refund(Request $request, $id)
    {
        $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
            'reason' => 'nullable|string|max:500',
        ]);

        $payment = Payment::with('enrollment')->findOrFail($id);

        if ($payment->status !== 'succeeded') {
            return redirect()->route('admin.payments.show', $payment->id)
                ->with('error', 'Only succeeded payments can be refunded.');
        }

        try {
            $gateway = PaymentServiceManager::gateway($payment->gateway);
            $refundAmount = $request->amount ?? $payment->amount;
            
            $refund = $gateway->refundPayment($payment->gateway_payment_id, $refundAmount);

            if ($refund['success'] ?? false) {
                // Update payment status
                $payment->update([
                    'status' => 'refunded',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'refund_id' => $refund['refund_id'] ?? null,
                        'refund_amount' => $refund['amount'] ?? $refundAmount,
                        'refund_reason' => $request->reason,
                        'refunded_at' => now()->toDateTimeString(),
                    ]),
                ]);

                // Update enrollment if full refund
                if ($refundAmount >= $payment->amount && $payment->enrollment) {
                    $payment->enrollment->update(['status' => 'refunded']);
                }

                return redirect()->route('admin.payments.show', $payment->id)
                    ->with('success', 'Refund processed successfully.');
            } else {
                return redirect()->route('admin.payments.show', $payment->id)
                    ->with('error', 'Refund failed: ' . ($refund['error'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.show', $payment->id)
                ->with('error', 'Refund error: ' . $e->getMessage());
        }
    }
}

