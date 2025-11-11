<x-layout title="Destrosolutions - Blog">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page :banner="$banner"/>

    @php
        $blogItems = $blogs instanceof \Illuminate\Support\Collection ? $blogs : collect($blogs ?? []);
        $displayPosts = $blogItems->values();

        $featuredPost = $displayPosts->first();
        $firstRowPosts = [
            'left' => $displayPosts->get(1),
            'feature' => $featuredPost,
            'right' => $displayPosts->get(2),
        ];
        $remainingPosts = $displayPosts->slice(3)->values();

        $initialBatchSize = 9;
        $firstRowCount = collect($firstRowPosts)->filter()->count();
        $initialRemainingVisible = max(0, min($initialBatchSize - $firstRowCount, $remainingPosts->count()));
        $hasMorePosts = $displayPosts->count() > $initialBatchSize;

        $formatDate = static function ($item): ?string {
            $rawDate = $item->date ?? $item->created_at;
            if (!$rawDate) {
                return null;
            }

            try {
                return \Illuminate\Support\Carbon::parse($rawDate)->format('d.m.Y');
            } catch (\Throwable $e) {
                return null;
            }
        };

        $excerpt = static function ($item, int $limit = 180): string {
            return \Illuminate\Support\Str::limit(strip_tags($item->description ?? ''), $limit);
        };

        $categoryTitle = static function ($item): ?string {
            return optional($item->category)->title;
        };

        $postLink = static function ($item): string {
            if ($item?->slug && \Illuminate\Support\Facades\Route::has('content.show')) {
                return route('content.show', $item->slug);
            }

            return '#';
        };

        $typeLabel = static function ($item): string {
            $type = $item->type ?? 'Blog';
            return __(\Illuminate\Support\Str::headline($type));
        };
    @endphp

    <section class="relative w-full py-14 md:py-16 lg:py-20 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-center">
                <div class="space-y-6">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Fresh intelligence for secure, software-defined mobility') }}
                    </h2>
                </div>
                <div class="space-y-6">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('Stay ahead of the shifts shaping software-defined vehicles, safety, and cybersecurity. Our experts share field-tested practices, lessons from transformation programmes, and the latest regulatory developments to keep your mobility strategy resilient and launch-ready.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('From architecture deep dives to executive playbooks, explore perspectives that help engineering, product, and security leaders deliver trusted digital experiences at automotive scale.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative w-full py-20 bg-[#F5F6F8] blog-list-section">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8">
            <div class="space-y-16">
                @if($displayPosts->isEmpty())
                    <div class="text-center py-16 text-gray-500 text-lg">
                        {{ __('No blog posts available at the moment.') }}
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                        @if($firstRowPosts['left'])
                            <div class="lg:col-span-3">
                                @include('partials.blog.card', [
                                    'post' => $firstRowPosts['left'],
                                    'formatDate' => $formatDate,
                                    'excerpt' => $excerpt,
                                    'categoryTitle' => $categoryTitle,
                                    'postLink' => $postLink,
                                    'typeLabel' => $typeLabel,
                                    'imageLoading' => 'eager',
                                ])
                            </div>
                        @endif

                        @if($firstRowPosts['feature'])
                            <article class="blog-feature-card lg:col-span-6">
                                <img 
                                    class="blog-feature-image" 
                                    src="{{ $firstRowPosts['feature']->image_url ?? asset('images/blog.jpeg') }}" 
                                    alt="{{ $firstRowPosts['feature']->title }}"
                                    loading="eager"
                                    decoding="sync"
                                >
                                <div class="blog-feature-overlay"></div>
                                <div class="blog-feature-content">
                                    <div class="blog-feature-meta">
                                        @if($categoryTitle($firstRowPosts['feature']))
                                            <span class="blog-feature-category">{{ $categoryTitle($firstRowPosts['feature']) }}</span>
                                        @endif
                                        @if($formatDate($firstRowPosts['feature']))
                                            <span class="blog-feature-date">{{ $formatDate($firstRowPosts['feature']) }} | {{ $typeLabel($firstRowPosts['feature']) }}</span>
                                        @endif
                                    </div>
                                    <h2 class="blog-feature-title">{{ $firstRowPosts['feature']->title }}</h2>
                                    @if($firstRowPosts['feature']->description)
                                        <p class="blog-feature-description">{{ $excerpt($firstRowPosts['feature'], 220) }}</p>
                                    @endif
                                    <a href="{{ $postLink($firstRowPosts['feature']) }}" class="blog-feature-link">
                                        {{ __('Read more') }}
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M5 12h14"></path>
                                            <path d="M13 6l6 6-6 6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endif

                        @if($firstRowPosts['right'])
                            <div class="lg:col-span-3">
                                @include('partials.blog.card', [
                                    'post' => $firstRowPosts['right'],
                                    'formatDate' => $formatDate,
                                    'excerpt' => $excerpt,
                                    'categoryTitle' => $categoryTitle,
                                    'postLink' => $postLink,
                                    'typeLabel' => $typeLabel,
                                    'imageLoading' => 'eager',
                                ])
                            </div>
                        @endif
                    </div>

                    @if($remainingPosts->isNotEmpty())
                        <div 
                            id="blogCardsContainer" 
                            class="blog-grid-list grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8"
                            data-initial-visible="{{ $initialRemainingVisible }}"
                            data-batch-size="{{ $initialBatchSize }}"
                        >
                            @foreach($remainingPosts as $index => $post)
                                @include('partials.blog.card', [
                                    'post' => $post,
                                    'formatDate' => $formatDate,
                                    'excerpt' => $excerpt,
                                    'categoryTitle' => $categoryTitle,
                                    'postLink' => $postLink,
                                    'typeLabel' => $typeLabel,
                                    'imageLoading' => 'lazy',
                                    'cardAttributes' => [
                                        'data-card-index' => $index,
                                        'data-card-visible' => $index < $initialRemainingVisible ? 'true' : 'false',
                                        'style' => $index < $initialRemainingVisible ? '' : 'display: none;',
                                    ],
                                ])
                            @endforeach

                            @if($hasMorePosts)
                                <div class="blog-see-more-card" id="blogSeeMoreCard">
                                    <button type="button" class="blog-see-more-button">
                                        <div class="blog-see-more-content">
                                            <div class="blog-see-more-icon-wrapper">
                                                <svg class="blog-see-more-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </div>
                                            <h3 class="blog-see-more-text">
                                                {{ __('See More') }}
                                            </h3>
                                        </div>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <style>
        .blog-grid-card {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.08);
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }

        .blog-grid-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 44px -20px rgba(15, 23, 42, 0.28);
        }

        .blog-card-image {
            position: relative;
            height: clamp(190px, 28vw, 240px);
            overflow: hidden;
        }

        .blog-card-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
            transition: transform 0.6s ease;
        }

        .blog-grid-card:hover .blog-card-image img {
            transform: scale(1.08);
        }

        .blog-card-body {
            position: relative;
            z-index: 1;
            flex: 1;
            padding: 1.75rem 1.75rem 2.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .blog-card-date {
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #475569;
        }

        .blog-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
            color: #0f172a;
            word-break: break-word;
        }

        .blog-card-link {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-weight: 600;
            color: #0D0DE0;
            text-decoration: none;
            transition: gap 0.3s ease;
        }

        .blog-card-link svg {
            width: 1.25rem;
            height: 1.25rem;
            stroke-width: 2;
        }

        .blog-card-link:hover {
            gap: 1rem;
        }

        .blog-card-overlay {
            position: absolute;
            inset: 0;
            padding: clamp(1.75rem, 3.5vw, 2.75rem);
            background: #ffffff;
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.35s ease, transform 0.35s ease;
            text-align: left;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            pointer-events: none;
        }

        .blog-card-overlay-content {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            width: 100%;
        }

        .blog-card-overlay-category {
            display: inline-flex;
            align-items: center;
            width: max-content;
            padding: 0.28rem 0.75rem;
            border-radius: 999px;
            background: rgba(13, 13, 224, 0.12);
            color: #0D0DE0;
            font-weight: 600;
            font-size: 0.65rem;
            letter-spacing: 0.14em;
        }

        .blog-card-overlay-date {
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #475569;
        }

        .blog-card-overlay-title {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.35;
            color: #0f172a;
            word-break: break-word;
        }

        .blog-card-overlay p {
            color: #1f2937;
            font-size: 0.95rem;
            line-height: 1.7;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .blog-grid-card:hover .blog-card-overlay {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .blog-feature-card {
            position: relative;
            display: flex;
            align-items: flex-end;
            min-height: clamp(22rem, 55vw, 28rem);
            border-radius: 36px;
            overflow: hidden;
            color: #ffffff;
        }

        .blog-feature-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-feature-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(140deg, rgba(13, 13, 224, 0.74) 0%, rgba(13, 13, 224, 0.38) 45%, rgba(15, 23, 42, 0.8) 100%);
        }

        .blog-feature-content {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: clamp(2rem, 5vw, 4rem);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            justify-content: flex-end;
        }

        .blog-feature-meta {
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .blog-feature-category {
            display: inline-flex;
            align-items: center;
            width: max-content;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.16);
        }

        .blog-feature-title {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 700;
            line-height: 1.1;
        }

        .blog-feature-description {
            font-size: clamp(1rem, 2vw, 1.1rem);
            line-height: 1.7;
            color: rgba(226, 232, 240, 0.92);
        }

        .blog-feature-link {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            width: max-content;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .blog-feature-link svg {
            width: 1.35rem;
            height: 1.35rem;
            stroke-width: 2;
        }

        .blog-feature-link:hover {
            background: #ffffff;
            color: #0D0DE0;
            transform: translateY(-2px);
        }

        .blog-grid-list {
            row-gap: clamp(2.5rem, 5vw, 3.5rem);
        }

        .blog-see-more-card {
            border: 2px dashed #0D0DE0;
            border-radius: 3rem;
            background: #ffffff;
            min-height: clamp(16rem, 32vw, 19rem);
            display: flex;
            align-items: stretch;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .blog-see-more-card:hover {
            border-color: #0D0DE0;
            background: #f8f9ff;
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(13, 13, 224, 0.12);
        }

        .blog-see-more-button {
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

        .blog-see-more-content {
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

        .blog-see-more-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 2px solid #0D0DE0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .blog-see-more-card:hover .blog-see-more-icon-wrapper {
            background: #0D0DE0;
            transform: scale(1.1);
        }

        .blog-see-more-icon {
            width: 32px;
            height: 32px;
            color: #0D0DE0;
            transition: all 0.3s ease;
        }

        .blog-see-more-card:hover .blog-see-more-icon {
            color: #ffffff;
            transform: rotate(90deg);
        }

        .blog-see-more-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0D0DE0;
            margin: 0;
            transition: color 0.3s ease;
        }

        .blog-see-more-card.loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }

        .blog-see-more-card.loading .blog-see-more-icon {
            animation: spin 1s linear infinite;
        }

        @media (max-width: 767px) {
            .blog-feature-card {
                min-height: 420px;
            }

            .blog-card-body {
                padding: 1.5rem 1.5rem 2rem;
            }

            .blog-card-title,
            .blog-card-overlay-title {
                font-size: 1.15rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const blogSection = document.querySelector('.blog-list-section');
            const container = document.getElementById('blogCardsContainer');
            if (!blogSection || !container) {
                return;
            }

            const cards = Array.from(container.querySelectorAll('.blog-grid-card[data-card-index]'));
            const seeMoreCard = document.getElementById('blogSeeMoreCard');
            const batchSize = parseInt(container.dataset.batchSize || '9', 10);
            const initialVisible = parseInt(container.dataset.initialVisible || '0', 10);
            const totalCards = cards.length;
            let shownCount = Math.min(initialVisible, totalCards);
            let initialAnimated = false;

            cards.forEach((card, index) => {
                if (index < shownCount) {
                    card.style.display = '';
                    card.setAttribute('data-card-visible', 'true');
                } else {
                    card.style.display = 'none';
                    card.setAttribute('data-card-visible', 'false');
                }
            });

            function animateCards(targetCards) {
                const visibleCards = targetCards.filter(Boolean);
                if (!visibleCards.length) {
                    return;
                }

                if (typeof window.gsap !== 'undefined') {
                    window.gsap.fromTo(visibleCards, {
                        opacity: 0,
                        y: 36,
                        scale: 0.96
                    }, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.75,
                        ease: 'power2.out',
                        stagger: 0.12
                    });
                } else {
                    visibleCards.forEach((card, index) => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(28px)';
                        requestAnimationFrame(() => {
                            setTimeout(() => {
                                card.style.transition = 'opacity 0.7s ease-out, transform 0.7s ease-out';
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                    });
                }
            }

            function triggerInitialAnimation() {
                if (initialAnimated) {
                    return;
                }

                initialAnimated = true;
                if (shownCount > 0) {
                    animateCards(cards.slice(0, shownCount));
                }
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            triggerInitialAnimation();
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.25 });

                observer.observe(blogSection);
            } else {
                triggerInitialAnimation();
            }

            if (seeMoreCard) {
                const seeMoreButton = seeMoreCard.querySelector('.blog-see-more-button') || seeMoreCard;

                seeMoreButton.addEventListener('click', function () {
                    if (seeMoreCard.classList.contains('loading')) {
                        return;
                    }

                    seeMoreCard.classList.add('loading');
                    if (seeMoreButton !== seeMoreCard) {
                        seeMoreButton.classList.add('loading');
                    }

                    const nextCount = Math.min(shownCount + batchSize, totalCards);
                    const cardsToShow = cards.slice(shownCount, nextCount);

                    setTimeout(() => {
                        cardsToShow.forEach(card => {
                            card.style.display = '';
                            card.setAttribute('data-card-visible', 'true');
                            const img = card.querySelector('img');
                            if (img) {
                                img.loading = 'lazy';
                            }
                        });

                        animateCards(cardsToShow);

                        shownCount = nextCount;

                        if (shownCount >= totalCards) {
                            seeMoreCard.style.display = 'none';
                        }

                        seeMoreCard.classList.remove('loading');
                        if (seeMoreButton !== seeMoreCard) {
                            seeMoreButton.classList.remove('loading');
                        }
                    }, 200);
                });
            }
        });
    </script>
</x-layout>


