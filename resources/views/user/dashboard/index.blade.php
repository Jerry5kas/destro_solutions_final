<x-user-layout title="My Dashboard - Destrosolutions">
    <div>
        <h1 class="page-title">Welcome, {{ Auth::user()->name }}</h1>

        @if(session('success'))
            <div class="dashboard-card" style="margin-bottom: 1.5rem; padding: 1rem; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="dashboard-card">
                <h2 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Total Enrollments</h2>
                <div style="font-size: 2rem; font-weight: 700; color: #0D0DE0;">{{ Auth::user()->enrollments()->count() }}</div>
            </div>
            <div class="dashboard-card">
                <h2 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Active Enrollments</h2>
                <div style="font-size: 2rem; font-weight: 700; color: #10b981;">{{ Auth::user()->activeEnrollments()->count() }}</div>
            </div>
            <div class="dashboard-card">
                <h2 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Total Payments</h2>
                <div style="font-size: 2rem; font-weight: 700; color: #0D0DE0;">{{ Auth::user()->payments()->where('status', 'paid')->count() }}</div>
            </div>
        </div>

        <div class="dashboard-card">
            <div style="padding-bottom: 1.25rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #111827;">Recent Enrollments</h2>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('user.enrollments') }}" style="color: #0D0DE0; font-weight: 600; text-decoration: none; font-size: 0.875rem;">View All</a>
                    <a href="{{ route('training') }}" style="color: #0D0DE0; font-weight: 600; text-decoration: none; font-size: 0.875rem;">Browse Trainings</a>
                </div>
            </div>
            <div>
                @if($enrollments && $enrollments->count() > 0)
                    <div style="display: grid; gap: 0.75rem;">
                        @foreach($enrollments as $enrollment)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; border: 1px solid #f3f4f6; border-radius: 12px; background: #fafafa; transition: all 0.2s ease; {{ $enrollment->status === 'paid' ? 'border-left: 4px solid #10b981;' : '' }}">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <div style="font-weight: 600; color: #111827;">{{ $enrollment->training->title ?? 'Training' }}</div>
                                        @if($enrollment->status === 'paid')
                                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.5rem; background: #d1fae5; color: #065f46; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Access Granted
                                            </span>
                                        @elseif($enrollment->status === 'pending')
                                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.5rem; background: #fef3c7; color: #92400e; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Awaiting Payment
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.5rem; background: #fee2e2; color: #991b1b; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                No Access
                                            </span>
                                        @endif
                                    </div>
                                    <div style="color: #6b7280; font-size: 0.875rem;">
                                        @if($enrollment->status === 'paid' && $enrollment->enrolled_at)
                                            <span style="color: #10b981; font-weight: 500;">✓ Enrolled on {{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                                        @elseif($enrollment->status === 'pending')
                                            <span>⏳ Complete payment to get access</span>
                                        @else
                                            <span>Status: {{ ucfirst($enrollment->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div style="text-align: right; margin-left: 1rem;">
                                    <div style="font-size: 1.125rem; font-weight: 700; color: #0D0DE0;">
                                        {{ \App\Support\Money::format($enrollment->amount, $enrollment->currency) }}
                                    </div>
                                    @if($enrollment->status === 'paid')
                                        <a href="#" style="display: inline-block; margin-top: 0.5rem; padding: 0.5rem 1rem; background: #0D0DE0; color: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                                            Access Course →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem 1rem;">
                        <p style="color: #6b7280; font-size: 0.9375rem; margin-bottom: 1rem;">You have no enrollments yet.</p>
                        <a href="{{ route('training') }}" 
                           style="display: inline-block; padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border-radius: 10px; font-weight: 600; text-decoration: none;">
                            Browse Trainings
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-layout>
