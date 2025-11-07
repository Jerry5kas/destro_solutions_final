<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'training', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by training
        if ($request->filled('training_id')) {
            $query->where('training_id', $request->training_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by user email or training title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('email', 'like', "%{$search}%")
                              ->orWhere('name', 'like', "%{$search}%");
                })->orWhereHas('training', function ($trainingQuery) use ($search) {
                    $trainingQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        $enrollments = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Enrollment::count(),
            'paid' => Enrollment::where('status', 'paid')->count(),
            'pending' => Enrollment::where('status', 'pending')->count(),
            'failed' => Enrollment::where('status', 'failed')->count(),
            'total_revenue' => Enrollment::where('status', 'paid')->sum('amount'),
        ];

        // Get trainings for filter dropdown
        $trainings = \App\Models\ContentItem::where('type', 'training')
            ->where('status', 'active')
            ->orderBy('title')
            ->get();

        return view('admin.enrollments.index', compact('enrollments', 'stats', 'trainings'));
    }

    /**
     * Display the specified enrollment.
     */
    public function show($id)
    {
        $enrollment = Enrollment::with(['user', 'training', 'payment'])->findOrFail($id);
        
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Update enrollment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:paid,pending,failed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $enrollment = Enrollment::with('payment')->findOrFail($id);
        
        $enrollment->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $enrollment->notes,
        ]);

        // If status changed to paid, set enrolled_at
        if ($request->status === 'paid' && !$enrollment->enrolled_at) {
            $enrollment->update(['enrolled_at' => now()]);
        }

        // Sync payment status with enrollment status
        if ($enrollment->payment) {
            $paymentStatusMap = [
                'paid' => 'succeeded',
                'pending' => 'pending',
                'failed' => 'failed',
                'cancelled' => 'failed', // Cancelled enrollment = failed payment
            ];

            $newPaymentStatus = $paymentStatusMap[$request->status] ?? $enrollment->payment->status;
            
            $paymentUpdate = ['status' => $newPaymentStatus];
            
            // If enrollment is paid, set paid_at on payment
            if ($request->status === 'paid' && !$enrollment->payment->paid_at) {
                $paymentUpdate['paid_at'] = now();
            }

            $enrollment->payment->update($paymentUpdate);
        }

        return redirect()->route('admin.enrollments.show', $enrollment->id)
            ->with('success', 'Enrollment status updated successfully. Payment status has been synced.');
    }

    /**
     * Cancel enrollment.
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $enrollment = Enrollment::with('payment')->findOrFail($id);

        if ($enrollment->status === 'cancelled') {
            return redirect()->route('admin.enrollments.show', $enrollment->id)
                ->with('error', 'Enrollment is already cancelled.');
        }

        $enrollment->update([
            'status' => 'cancelled',
            'notes' => ($enrollment->notes ? $enrollment->notes . "\n\n" : '') . 
                      'Cancelled: ' . ($request->reason ?? 'No reason provided') . 
                      ' (' . now()->format('Y-m-d H:i:s') . ')',
        ]);

        // Update payment status if payment exists
        if ($enrollment->payment && $enrollment->payment->status === 'succeeded') {
            // Don't automatically change succeeded payment to failed
            // Admin should process refund separately if needed
            // Just add a note to payment metadata
            $metadata = $enrollment->payment->metadata ?? [];
            $metadata['enrollment_cancelled'] = true;
            $metadata['cancellation_reason'] = $request->reason;
            $metadata['cancelled_at'] = now()->toDateTimeString();
            
            $enrollment->payment->update(['metadata' => $metadata]);
        }

        return redirect()->route('admin.enrollments.show', $enrollment->id)
            ->with('success', 'Enrollment cancelled successfully.');
    }
}

