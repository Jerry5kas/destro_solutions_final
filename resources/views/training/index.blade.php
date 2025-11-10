<x-layout title="Trainings - Destrosolutions">
    <main style="padding: 2rem 1rem; background:#f9fafb; min-height: calc(100vh - 200px);">
        <div style="max-width: 1100px; margin: 0 auto;">
            <h1 style="font-size:1.5rem; font-weight:600; color:#111827; margin-bottom:1rem;">Upcoming Trainings</h1>

            @if($trainings->isEmpty())
                <p style="color:#6b7280;">No trainings available at the moment. Please check back later.</p>
            @else
                <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                    @foreach($trainings as $training)
                        @php
                            $currencyCode = $training->resolvedCurrencyCode();
                            $formattedPrice = \App\Support\Money::format($training->price, $currencyCode);
                        @endphp
                        <a href="{{ route('training.show', $training->slug) }}" style="text-decoration:none;">
                            <div style="background:white; border:1px solid #eef2ff; border-radius:16px; overflow:hidden; box-shadow: 0 10px 30px rgba(13,13,224,0.06);">
                                <div style="height: 160px; background:#f3f4f6;">
                                    @if($training->image)
                                        <img src="{{ $training->image_url }}" alt="{{ $training->title }}" style="width:100%; height:100%; object-fit:cover;">
                                    @endif
                                </div>
                                <div style="padding: 1rem;">
                                    <div style="font-weight:600; color:#111827;">{{ $training->title }}</div>
                                    <div style="color:#6b7280; font-size:.9rem; margin-top:.25rem;">{{ $training->start_date?->format('M d, Y') }} @if($training->duration_days) · {{ $training->duration_days }} days @endif</div>
                                    @if(!is_null($training->price))
                                        <div style="margin-top:.5rem; font-weight:600; color:#0D0DE0;">{{ $formattedPrice }}</div>
                                    @else
                                        <div style="margin-top:.5rem; font-weight:500; color:#6b7280;">{{ __('Contact for pricing') }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</x-layout>
