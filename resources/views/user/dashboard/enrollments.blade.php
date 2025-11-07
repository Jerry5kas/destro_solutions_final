<x-user-layout title="My Enrollments - Destrosolutions">
    <div>
        <h1 class="page-title">My Enrollments</h1>

        @if(session('success'))
            <div class="dashboard-card" style="margin-bottom: 1.5rem; padding: 1rem; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        <div class="dashboard-card">
            @if($enrollments && $enrollments->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($enrollments as $enrollment)
                        <div style="padding: 1.25rem; border: 1px solid #f3f4f6; border-radius: 12px; background: #fff;">
                            <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                                        {{ $enrollment->training->title ?? 'Training' }}
                                    </h3>
                                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 0.75rem;">
                                        <div style="color: #6b7280; font-size: 0.875rem;">
                                            <span style="font-weight: 600;">Status:</span>
                                            <span style="color: {{ $enrollment->status === 'paid' ? '#10b981' : ($enrollment->status === 'pending' ? '#f59e0b' : '#ef4444') }}; font-weight: 600; margin-left: 0.25rem;">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </div>
                                        @if($enrollment->enrolled_at)
                                            <div style="color: #6b7280; font-size: 0.875rem;">
                                                <span style="font-weight: 600;">Enrolled:</span> {{ $enrollment->enrolled_at->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #0D0DE0;">
                                        {{ $enrollment->currency }} {{ number_format((float)$enrollment->amount, 2) }}
                                    </div>
                                    @if($enrollment->training)
                                        <a href="{{ route('trainings.show', $enrollment->training->slug) }}" 
                                           style="display: inline-block; margin-top: 0.5rem; color: #0D0DE0; font-weight: 600; text-decoration: none; font-size: 0.875rem;">
                                            View Details →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <p style="color: #6b7280; font-size: 1rem; margin-bottom: 1rem;">You have no enrollments yet.</p>
                    <a href="{{ route('training') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border-radius: 10px; font-weight: 600; text-decoration: none;">
                        Browse Trainings
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-user-layout>

