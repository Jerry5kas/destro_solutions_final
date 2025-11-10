@php
    use Illuminate\Support\Str;

    $imagePath = $contentItem->image_url ?? asset('images/blog.jpeg');
    $metaCategory = $contentItem->category->title ?? null;
    $metaType = $contentItem->type ? Str::headline($contentItem->type) : null;
    $metaDate = $contentItem->date ? $contentItem->date->format('d M Y') : optional($contentItem->created_at)->format('d M Y');
    $objectiveList = collect($contentItem->objective_list ?? [])->filter();
    $description = trim($contentItem->description ?? '');
@endphp

<x-layout :title="($contentItem->title ?? 'Content') . ' - Destrosolutions'">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
               :imagePath="$imagePath"
    />

    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ $contentItem->title }}
                    </h1>
                    @if($metaType)
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#0D0DE0]/10 text-[#0D0DE0] text-sm font-semibold uppercase tracking-wider">
                            {{ __($metaType) }}
                        </span>
                    @endif
                </div>
                @if($description)
                    <div class="space-y-6 text-base md:text-lg text-gray-600 leading-relaxed">
                        {!! nl2br(e($description)) !!}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="relative w-full py-6 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8">
            <div class="flex flex-wrap items-center gap-4 text-sm font-semibold uppercase tracking-widest text-gray-500">
                @if($metaCategory)
                    <span class="inline-flex items-center gap-2 text-[#0D0DE0]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        {{ $metaCategory }}
                    </span>
                @endif
                @if($metaDate)
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $metaDate }}
                    </span>
                @endif
                @if($metaType)
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ __($metaType) }}
                    </span>
                @endif
            </div>
        </div>
    </section>

    @if($objectiveList->isNotEmpty())
        <section class="relative w-full pb-16 pt-6 bg-[#F5F6F8]">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8">
                <div class="">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-6 md:mb-8" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Key Objectives') }}
                    </h2>
                    <ul class="space-y-4 sm:space-y-5">
                        @foreach($objectiveList as $objective)
                            <li class="flex items-start gap-3 text-gray-700">
                                <span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-[#0D0DE0] shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <span class="text-base leading-relaxed">
                                    {{ $objective }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif

    @if($contentItem->content ?? false)
        <section class="relative w-full py-16 bg-white">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8">
                <article class="prose prose-lg max-w-none text-gray-700">
                    {!! $contentItem->content !!}
                </article>
            </div>
        </section>
    @endif

    @if(isset($relatedItems) && $relatedItems->isNotEmpty())
        <section class="relative w-full pb-20 bg-white py-24">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8">
                <div class="flex items-center justify-between gap-4 mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-900" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Suggested ') }}{{ $metaType ? __($metaType) : __('Content') }}
                    </h2>
                </div>
                <div id="relatedCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach($relatedItems as $index => $related)
                        <article class="group bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col related-card" data-index="{{ $index }}" style="{{ $index < 3 ? '' : 'display:none;' }}">
                            <div class="relative h-48 overflow-hidden">
                                <img 
                                    src="{{ $related->image_url ?? asset('images/blog.jpeg') }}" 
                                    alt="{{ $related->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @if($related->category?->title)
                                    <span class="absolute bottom-3 left-3 inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-[#0D0DE0] shadow-md">
                                        {{ $related->category->title }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col gap-4 flex-1">
                                <div class="text-sm uppercase tracking-wider text-gray-500 font-semibold">
                                    @if($related->date)
                                        {{ $related->date->format('d M Y') }}
                                    @elseif($related->created_at)
                                        {{ $related->created_at->format('d M Y') }}
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-[#0D0DE0] transition-colors duration-300">
                                    {{ $related->title }}
                                </h3>
                                @if($related->description)
                                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($related->description), 140) }}
                                    </p>
                                @endif
                                <div class="mt-auto pt-2">
                                    <a href="{{ route('content.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#0D0DE0] hover:gap-3 transition-all duration-200">
                                        {{ __('Read More') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    @if($relatedItems->count() > 3)
                        <div id="relatedSeeMoreCard" class="product-card-item see-more-card" style="display: block;">
                            <button type="button" id="relatedSeeMoreBtn" class="see-more-card-button w-full h-full">
                                <div class="see-more-card-content">
                                    <div class="see-more-icon-wrapper">
                                        <svg class="see-more-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="see-more-text">
                                        {{ __('See More') }}
                                    </h3>
                                </div>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById('relatedCardsContainer');
                const seeMoreBtn = document.getElementById('relatedSeeMoreBtn');

                if (!container) return;

                const cards = Array.from(container.querySelectorAll('.related-card'));
                const batchSize = 3;
                let shownCount = cards.filter(card => card.style.display !== 'none').length;

                function animateCards(targetCards) {
                    if (!targetCards.length) return;

                    if (window.gsap) {
                        window.gsap.fromTo(targetCards, {
                            opacity: 0,
                            y: 36,
                            scale: 0.96
                        }, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 0.75,
                            ease: 'power2.out',
                            stagger: 0.1
                        });
                    } else {
                        targetCards.forEach((card, index) => {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(28px)';
                            requestAnimationFrame(() => {
                                setTimeout(() => {
                                    card.style.transition = 'opacity 0.7s ease-out, transform 0.7s ease-out';
                                    card.style.opacity = '1';
                                    card.style.transform = 'translateY(0)';
                                }, index * 90);
                            });
                        });
                    }
                }

                if (seeMoreBtn) {
                    seeMoreBtn.addEventListener('click', function () {
                        if (this.classList.contains('loading')) return;

                        this.classList.add('loading');

                        const nextCount = Math.min(shownCount + batchSize, cards.length);
                        const cardsToShow = cards.slice(shownCount, nextCount);

                        setTimeout(() => {
                            cardsToShow.forEach(card => {
                                card.style.display = '';
                            });

                            animateCards(cardsToShow);

                            shownCount = nextCount;

                            if (shownCount >= cards.length) {
                                const wrapper = document.getElementById('relatedSeeMoreCard');
                                if (wrapper) {
                                    wrapper.style.display = 'none';
                                } else {
                                    seeMoreBtn.style.display = 'none';
                                }
                            }

                            this.classList.remove('loading');
                        }, 180);
                    });
                }
            });
        </script>
    @endpush

@push('styles')
    <style>
        .related-card {
            border-radius: 32px;
        }

        .see-more-card {
            border: 2px dashed #0D0DE0;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 32px;
            display: flex;
            align-items: stretch;
            min-height: 100%;
        }

        .see-more-card:hover {
            border-color: #0D0DE0;
            background: #f8f9ff;
            transform: translateY(-6px);
            box-shadow: 0 22px 46px -24px rgba(13, 13, 224, 0.35);
        }

        .see-more-card-button {
            background: transparent;
            border: none;
            padding: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .see-more-card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem 1.5rem;
            width: 100%;
            min-height: 100%;
            gap: 1.25rem;
        }

        .see-more-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 2px solid #0D0DE0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .see-more-card:hover .see-more-icon-wrapper {
            background: #0D0DE0;
            transform: scale(1.08);
        }

        .see-more-card-icon {
            width: 32px;
            height: 32px;
            color: #0D0DE0;
            transition: all 0.3s ease;
        }

        .see-more-card:hover .see-more-card-icon {
            color: #ffffff;
            transform: rotate(90deg);
        }

        .see-more-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0D0DE0;
            margin: 0;
            transition: color 0.3s ease;
        }

        .see-more-card.loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }

        .see-more-card.loading .see-more-card-icon {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
@endpush
</x-layout>
