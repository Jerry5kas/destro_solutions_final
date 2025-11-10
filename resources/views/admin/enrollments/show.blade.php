<x-admin-layout title="Enrollment Details - Destrosolutions">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 class="page-title">Enrollment Details</h1>
        <a href="{{ route('admin.enrollments.index') }}" style="color: #0D0DE0; font-weight: 600; text-decoration: none;">
            ← Back to Enrollments
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
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Enrollment Information</h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Enrollment ID:</div>
                        <div style="font-family: monospace; color: #111827;">#{{ $enrollment->id }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Status:</div>
                        <div>
                            @php
                                $statusColors = [
                                    'paid' => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
                                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fde68a'],
                                    'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca'],
                                    'cancelled' => ['bg' => '#e5e7eb', 'text' => '#374151', 'border' => '#d1d5db'],
                                ];
                                $color = $statusColors[$enrollment->status] ?? $statusColors['pending'];
                            @endphp
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; border-radius: 8px; font-weight: 600; text-transform: capitalize;">
                                {{ $enrollment->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Training:</div>
                        <div style="color: #111827; font-weight: 500;">{{ $enrollment->training->title ?? 'N/A' }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Amount:</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #0D0DE0;">
                            {{ \App\Support\Money::format($enrollment->amount, $enrollment->currency) }}
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Payment Method:</div>
                        <div style="color: #111827;">{{ ucfirst($enrollment->payment_method ?? 'N/A') }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Created At:</div>
                        <div style="color: #111827;">{{ $enrollment->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    
                    @if($enrollment->enrolled_at)
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Enrolled At:</div>
                        <div style="color: #111827;">{{ $enrollment->enrolled_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    @endif
                    
                    @if($enrollment->terms_accepted)
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Terms Accepted:</div>
                        <div style="color: #111827;">
                            Yes ({{ $enrollment->terms_accepted_at->format('M d, Y H:i:s') }})
                        </div>
                    </div>
                    @endif
                    
                    @if($enrollment->notes)
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Notes:</div>
                        <div style="color: #111827; white-space: pre-wrap;">{{ $enrollment->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Information -->
            @if($enrollment->user)
            <div class="dashboard-card" style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">User Information</h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Name:</div>
                        <div style="color: #111827;">{{ $enrollment->user->name }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Email:</div>
                        <div style="color: #111827;">{{ $enrollment->user->email }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Information -->
            @if($enrollment->payment)
            <div class="dashboard-card" style="border-left: 4px solid #10b981;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">Payment Information</h2>
                    <span style="font-size: 0.75rem; color: #6b7280; background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px;">Linked</span>
                </div>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Payment ID:</div>
                        <div style="color: #111827;">
                            <a href="{{ route('admin.payments.show', $enrollment->payment->id) }}" style="color: #0D0DE0; text-decoration: none; font-weight: 600;">
                                {{ Str::limit($enrollment->payment->gateway_payment_id, 30) }}
                            </a>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Payment Status:</div>
                        <div>
                            @php
                                $paymentStatusColors = [
                                    'succeeded' => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
                                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fde68a'],
                                    'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca'],
                                ];
                                $paymentColor = $paymentStatusColors[$enrollment->payment->status] ?? $paymentStatusColors['pending'];
                            @endphp
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: {{ $paymentColor['bg'] }}; color: {{ $paymentColor['text'] }}; border: 1px solid {{ $paymentColor['border'] }}; border-radius: 8px; font-weight: 600; text-transform: capitalize;">
                                {{ $enrollment->payment->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280;">Gateway:</div>
                        <div>
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: #eef2ff; color: #0D0DE0; border-radius: 8px; font-weight: 600; text-transform: uppercase;">
                                {{ $enrollment->payment->gateway }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div>
            <div class="dashboard-card" style="position: sticky; top: 100px;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Actions</h2>
                
                <div style="display: grid; gap: 0.75rem;">
                    <button type="button" onclick="document.getElementById('status-form').style.display = 'block';" style="width: 100%; padding: 0.75rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Update Status
                    </button>
                    
                    @if($enrollment->status !== 'cancelled')
                    <button type="button" onclick="document.getElementById('cancel-form').style.display = 'block';" style="width: 100%; padding: 0.75rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Cancel Enrollment
                    </button>
                    @endif
                    
                    <!-- Status Update Form -->
                    <div id="status-form" style="display: none; margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <form method="POST" action="{{ route('admin.enrollments.updateStatus', $enrollment->id) }}">
                            @csrf
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Status</label>
                                <select name="status" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
                                    <option value="pending" {{ $enrollment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $enrollment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $enrollment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="cancelled" {{ $enrollment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @if($enrollment->payment)
                                <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                                    Note: Payment status will be automatically synced (paid→succeeded, pending→pending, failed→failed, cancelled→failed)
                                </p>
                                @endif
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Notes (optional)</label>
                                <textarea name="notes" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">{{ $enrollment->notes }}</textarea>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" style="flex: 1; padding: 0.5rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Update
                                </button>
                                <button type="button" onclick="document.getElementById('status-form').style.display = 'none';" style="flex: 1; padding: 0.5rem; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Cancel Form -->
                    <div id="cancel-form" style="display: none; margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <form method="POST" action="{{ route('admin.enrollments.cancel', $enrollment->id) }}">
                            @csrf
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Reason (optional)</label>
                                <textarea name="reason" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;"></textarea>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" style="flex: 1; padding: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Confirm Cancel
                                </button>
                                <button type="button" onclick="document.getElementById('cancel-form').style.display = 'none';" style="flex: 1; padding: 0.5rem; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

