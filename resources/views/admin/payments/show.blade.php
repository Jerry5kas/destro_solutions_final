<x-admin-layout title="Payment Details - Destrosolutions">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 class="page-title">Payment Details</h1>
        <a href="{{ route('admin.payments.index') }}" style="color: #0D0DE0; font-weight: 600; text-decoration: none;">
            ← Back to Payments
        </a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Main Details -->
        <div>
            <div class="dashboard-card" style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Payment Information</h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Payment ID:</div>
                        <div style="font-family: monospace; color: #111827;">{{ $payment->gateway_payment_id }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Status:</div>
                        <div>
                            @php
                                $statusColors = [
                                    'succeeded' => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
                                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fde68a'],
                                    'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca'],
                                    'refunded' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'border' => '#c7d2fe'],
                                ];
                                $color = $statusColors[$payment->status] ?? $statusColors['pending'];
                            @endphp
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; border-radius: 8px; font-weight: 600; text-transform: capitalize;">
                                {{ $payment->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Gateway:</div>
                        <div>
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: #eef2ff; color: #0D0DE0; border-radius: 8px; font-weight: 600; text-transform: uppercase;">
                                {{ $payment->gateway }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Amount:</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #0D0DE0;">
                            {{ $payment->currency }} {{ number_format((float)$payment->amount, 2) }}
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Payment Method:</div>
                        <div style="color: #111827;">{{ $payment->payment_method ?? 'N/A' }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Created At:</div>
                        <div style="color: #111827;">{{ $payment->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    
                    @if($payment->paid_at)
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Paid At:</div>
                        <div style="color: #111827;">{{ $payment->paid_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    @endif
                    
                    @if($payment->failure_reason)
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Failure Reason:</div>
                        <div style="color: #991b1b;">{{ $payment->failure_reason }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Information -->
            @if($payment->user)
            <div class="dashboard-card" style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">User Information</h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Name:</div>
                        <div style="color: #111827;">{{ $payment->user->name }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Email:</div>
                        <div style="color: #111827;">{{ $payment->user->email }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Enrollment Information -->
            @if($payment->enrollment)
            <div class="dashboard-card" style="border-left: 4px solid #0D0DE0;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">Enrollment Information</h2>
                    <span style="font-size: 0.75rem; color: #6b7280; background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px;">Linked</span>
                </div>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Training:</div>
                        <div style="color: #111827;">
                            <a href="{{ route('admin.enrollments.show', $payment->enrollment->id) }}" style="color: #0D0DE0; text-decoration: none; font-weight: 600;">
                                {{ $payment->enrollment->training->title ?? 'N/A' }}
                            </a>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Enrollment Status:</div>
                        <div>
                            @php
                                $enrollmentStatusColors = [
                                    'paid' => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
                                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fde68a'],
                                    'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca'],
                                ];
                                $enrollmentColor = $enrollmentStatusColors[$payment->enrollment->status] ?? $enrollmentStatusColors['pending'];
                            @endphp
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: {{ $enrollmentColor['bg'] }}; color: {{ $enrollmentColor['text'] }}; border: 1px solid {{ $enrollmentColor['border'] }}; border-radius: 8px; font-weight: 600; text-transform: capitalize;">
                                {{ $payment->enrollment->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Metadata -->
            @if($payment->metadata && count($payment->metadata) > 0)
            <div class="dashboard-card" style="margin-top: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Payment Metadata</h2>
                <pre style="background: #f9fafb; padding: 1rem; border-radius: 8px; overflow-x: auto; font-size: 0.875rem; color: #111827;">{{ json_encode($payment->metadata, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div>
            <div class="dashboard-card" style="position: sticky; top: 100px;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Actions</h2>
                
                <div style="display: grid; gap: 0.75rem;">
                    @if($payment->status === 'pending')
                    <form method="POST" action="{{ route('admin.payments.verify', $payment->id) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 0.75rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Verify Payment
                        </button>
                    </form>
                    @endif

                    @if($payment->status === 'succeeded')
                    <button type="button" onclick="document.getElementById('refund-form').style.display = 'block';" style="width: 100%; padding: 0.75rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Process Refund
                    </button>
                    
                    <div id="refund-form" style="display: none; margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <form method="POST" action="{{ route('admin.payments.refund', $payment->id) }}">
                            @csrf
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Refund Amount (leave empty for full refund)</label>
                                <input type="number" name="amount" step="0.01" min="0.01" max="{{ $payment->amount }}" placeholder="{{ $payment->amount }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Reason (optional)</label>
                                <textarea name="reason" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;"></textarea>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" style="flex: 1; padding: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Confirm Refund
                                </button>
                                <button type="button" onclick="document.getElementById('refund-form').style.display = 'none';" style="flex: 1; padding: 0.5rem; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if($gatewayStatus)
                    <div style="margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <div style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Gateway Status:</div>
                        <div style="font-size: 0.8125rem; color: #6b7280;">
                            {{ $gatewayStatus['status'] ?? 'Unknown' }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

