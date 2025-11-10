<x-admin-layout title="Payments - Destrosolutions">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
        <div>
            <h1 class="page-title" style="margin-bottom: 0.5rem;">Payments</h1>
            <p style="color: #6b7280; font-size: 0.875rem;">
                💳 <strong>Payment Transactions</strong> - View all payment transactions from Stripe and Razorpay. 
                Each payment is linked to an enrollment. When payment succeeds, enrollment is automatically activated.
            </p>
        </div>
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

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="dashboard-card">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Total Payments</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #111827;">{{ $stats['total'] }}</div>
        </div>
        <div class="dashboard-card">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Succeeded</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #10b981;">{{ $stats['succeeded'] }}</div>
        </div>
        <div class="dashboard-card">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Pending</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #f59e0b;">{{ $stats['pending'] }}</div>
        </div>
        <div class="dashboard-card">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Failed</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #ef4444;">{{ $stats['failed'] }}</div>
        </div>
        <div class="dashboard-card">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Total Revenue</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #0D0DE0;">{{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
    </div>

    <!-- Info Banner -->
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: start; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="#0D0DE0" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 0.125rem;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div style="flex: 1;">
            <div style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Understanding Payments vs Enrollments</div>
            <div style="font-size: 0.875rem; color: #1e3a8a; line-height: 1.5;">
                <strong>Payments</strong> = Financial transactions (money received from Stripe/Razorpay). <strong>Payment status = `succeeded` means money received.</strong><br>
                <strong>Enrollments</strong> = User registrations in training courses. <strong>Enrollment status = `paid` means user HAS ACCESS to course.</strong><br>
                <strong>Key:</strong> One enrollment has one payment. When payment succeeds → enrollment becomes paid → user gets access. 
                <a href="{{ route('admin.enrollments.index') }}" style="color: #0D0DE0; font-weight: 600; text-decoration: underline;">View Enrollments →</a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="dashboard-card" style="margin-bottom: 1.5rem;">
        <form method="GET" action="{{ route('admin.payments.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Status</label>
                <select name="status" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="succeeded" {{ request('status') === 'succeeded' ? 'selected' : '' }}>Succeeded</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Gateway</label>
                <select name="gateway" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">All Gateways</option>
                    <option value="stripe" {{ request('gateway') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="razorpay" {{ request('gateway') === 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="User email, name, or payment ID" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>
            <div style="display: flex; align-items: flex-end; gap: 0.5rem;">
                <button type="submit" style="padding: 0.5rem 1rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Filter</button>
                <a href="{{ route('admin.payments.index') }}" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block;">Clear</a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="dashboard-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 120px 100px; gap: 1.5rem; align-items: center;">
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Payment ID</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">User</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Gateway</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Amount</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Status</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Date</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Actions</div>
            </div>
        </div>
        
        <div>
            @forelse($payments as $payment)
                <div class="content-row" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 120px 100px; gap: 1.5rem; align-items: center; transition: background 0.2s ease;">
                    <div>
                        <div style="font-weight: 500; color: #111827; font-size: 0.875rem; font-family: monospace;">
                            {{ Str::limit($payment->gateway_payment_id, 20) }}
                        </div>
                    </div>
                    
                    <div>
                        <div style="font-weight: 500; color: #111827; margin-bottom: 0.25rem; font-size: 0.9375rem;">
                            {{ $payment->user->name ?? 'N/A' }}
                        </div>
                        <div style="font-size: 0.8125rem; color: #6b7280;">
                            {{ $payment->user->email ?? 'N/A' }}
                        </div>
                    </div>
                    
                    <div>
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #eef2ff; color: #0D0DE0; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; text-transform: uppercase;">
                            {{ $payment->gateway }}
                        </span>
                    </div>
                    
                    <div style="font-weight: 600; color: #111827;">
                        {{ \App\Support\Money::format($payment->amount, $payment->currency) }}
                    </div>
                    
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
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; text-transform: capitalize;">
                            {{ $payment->status }}
                        </span>
                    </div>
                    
                    <div style="font-size: 0.8125rem; color: #6b7280;">
                        {{ $payment->created_at->format('M d, Y') }}
                    </div>
                    
                    <div style="text-align: center;">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" 
                           style="color: #0D0DE0; font-weight: 600; text-decoration: none; font-size: 0.875rem;">
                            View
                        </a>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem 1.5rem; text-align: center; color: #6b7280;">
                    <p>No payments found.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $payments->links() }}
        </div>
    @endif
</x-admin-layout>

