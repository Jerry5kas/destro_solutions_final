<x-user-layout title="My Payments - Destrosolutions">
    <div>
        <h1 class="page-title">My Payments</h1>

        @if(session('success'))
            <div class="dashboard-card" style="margin-bottom: 1.5rem; padding: 1rem; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        <div class="dashboard-card">
            @if($payments && $payments->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($payments as $payment)
                        <div style="padding: 1.25rem; border: 1px solid #f3f4f6; border-radius: 12px; background: #fff;">
                            <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                                            {{ $payment->enrollment->training->title ?? 'Training Payment' }}
                                        </h3>
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
                                            background: {{ $payment->status === 'paid' ? '#d1fae5' : ($payment->status === 'pending' ? '#fef3c7' : '#fee2e2') }};
                                            color: {{ $payment->status === 'paid' ? '#065f46' : ($payment->status === 'pending' ? '#92400e' : '#991b1b') }};
                                        ">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </div>
                                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 0.75rem; color: #6b7280; font-size: 0.875rem;">
                                        <div>
                                            <span style="font-weight: 600;">Gateway:</span> {{ ucfirst($payment->gateway) }}
                                        </div>
                                        @if($payment->paid_at)
                                            <div>
                                                <span style="font-weight: 600;">Paid:</span> {{ $payment->paid_at->format('M d, Y H:i') }}
                                            </div>
                                        @endif
                                        @if($payment->gateway_payment_id)
                                            <div>
                                                <span style="font-weight: 600;">Transaction ID:</span> 
                                                <span style="font-family: monospace; font-size: 0.8125rem;">{{ $payment->gateway_payment_id }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($payment->failure_reason)
                                        <div style="margin-top: 0.75rem; padding: 0.75rem; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 0.875rem;">
                                            <strong>Failure Reason:</strong> {{ $payment->failure_reason }}
                                        </div>
                                    @endif
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #0D0DE0;">
                                        {{ \App\Support\Money::format($payment->amount, $payment->currency) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <p style="color: #6b7280; font-size: 1rem; margin-bottom: 1rem;">You have no payment records yet.</p>
                    <a href="{{ route('training') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border-radius: 10px; font-weight: 600; text-decoration: none;">
                        Browse Trainings
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-user-layout>

