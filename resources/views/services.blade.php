<x-layout title="Destrosolutions - Services">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Services')" 
        :description="__('Comprehensive security, safety, and SDV services for OEMs and Tier-1s.')"
        imagePath="images/service.png"/>
    
    <!-- Services Intro Section -->
    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6 services-intro-lead">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('End-to-End Services for Secure, Connected Mobility') }}
                    </h2>
                </div>
                <div class="space-y-6 services-intro-content">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('We deliver comprehensive security, safety, and Software-Defined Vehicle (SDV) services tailored for OEMs and Tier-1 suppliers. Our teams integrate seamlessly with your engineering programs to embed best practices across cybersecurity, functional safety, and compliance frameworks such as ISO/SAE 21434, ASPICE, and ISO 26262.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('From chip-to-cloud hardening to OTA release orchestration, we accelerate your SDV roadmap with proven methodologies, specialized accelerators, and managed services that keep your fleets secure, resilient, and launch-ready.') }}
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('contact') }}" class="inline-block border-2 border-[#0D0DE0] text-[#0D0DE0] px-6 py-3 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 font-medium">
                            {{ __('Talk to an Expert') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $servicesCollection = $contentItems instanceof \Illuminate\Support\Collection ? $contentItems : collect($contentItems);
        $servicesCategories = $categories instanceof \Illuminate\Support\Collection ? $categories : collect($categories);
        $featuredService = $servicesCollection->first();
        $regularServices = $servicesCollection->slice(1)->values();
        $fallbackServiceImage = asset('images/service.png');
    @endphp

    <section class="relative w-full py-24 bg-gray-50 services-section" id="services-list">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">

            @if($servicesCategories->count() > 0)
                <div class="mb-12">
                    <div class="flex flex-wrap gap-3 items-center justify-center md:justify-start">
                        <a 
                            href="{{ route('services') }}" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$selectedCategory ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                        >
                            {{ __('All') }}
                        </a>
                        @foreach($servicesCategories as $category)
                            <a 
                                href="{{ route('services', ['category' => $category->slug]) }}" 
                                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                            >
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($featuredService)
                <div class="featured-service-card flex flex-col md:flex-row gap-6 md:gap-8 items-stretch overflow-hidden mb-16 lg:mb-20">
                    <div class="featured-service-content w-full md:w-2/5">
                        <h3 class="featured-title mb-4">
                            {{ $featuredService->title }}
                        </h3>
                        @if($featuredService->description)
                            <p class="featured-description mb-6">
                                {{ \Illuminate\Support\Str::limit(strip_tags($featuredService->description), 220) }}
                            </p>
                        @endif
                        <div class="featured-actions">
                            <a 
                                href="{{ route('services', ['category' => $featuredService->category->slug ?? null]) }}" 
                                class="featured-primary-btn"
                            >
                                {{ __('Read More') }}
                            </a>
                        </div>
                    </div>
                    <div class="featured-service-media w-full md:w-3/5">
                        <div class="featured-media-wrapper rounded-3xl">
                            <img 
                                src="{{ $featuredService->image_url ?? $fallbackServiceImage }}" 
                                alt="{{ $featuredService->title }}"
                                loading="eager"
                            />
                            <div class="featured-media-overlay"></div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 services-grid" id="servicesCardsContainer">
                @forelse($regularServices as $index => $service)
                    <div 
                        class="service-card product-card-item bg-white border border-gray-100 shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col service-card-item" 
                        data-index="{{ $index }}"
                        data-type="service"
                        style="display: {{ $index < 7 ? 'block' : 'none' }};"
                    >
                        @if($service->image_url)
                            <div class="service-image-wrapper">
                                <img 
                                    src="{{ $service->image_url ?? $fallbackServiceImage }}" 
                                    alt="{{ $service->title }}"
                                    loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                                />
                                <div class="service-image-overlay"></div>
                            </div>
                        @endif

                        <div class="service-card-content">
                            @if($service->category)
                                <span class="max-w-max service-category">
                                    {{ $service->category->title }}
                                </span>
                            @endif
                            <h4 class="service-card-title">
                                {{ $service->title }}
                            </h4>
                            @if($service->description)
                                <p class="service-card-description">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($service->description), 160) }}
                                </p>
                            @endif
                            <a 
                                href="{{ route('services', ['category' => $service->category->slug ?? null]) }}" 
                                class="service-card-button"
                            >
                                {{ __('Discover More') }}
                                <svg class="service-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12 text-gray-500">
                        {{ __('No services available at the moment.') }}
                    </div>
                @endforelse

                @if($regularServices->count() > 7)
                    <div class="service-card-item see-more-card" data-type="see-more" id="servicesSeeMoreCard" style="display: block;">
                        <button type="button" class="see-more-card-button w-full h-full">
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

    <style>
        .services-section {
            position: relative;
        }

        .featured-service-card {
            /* background: #ffffff; */
            border-radius: 32px;
            color: #0f172a;
            /* box-shadow: 0 24px 60px -24px rgba(15, 23, 42, 0.12); */
            /* border: 1px solid rgba(15, 23, 42, 0.08); */
            min-height: clamp(11.5rem, 18vw, 14.5rem);
        }

        .featured-service-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: rgba(13, 13, 224, 0.1);
            border-radius: 999px;
            padding: 0.45rem 0.9rem;
            width: max-content;
        }

        .featured-title {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 700;
            line-height: 1.15;
        }

        .featured-description {
            color: rgba(71, 85, 105, 0.9);
            font-size: clamp(0.95rem, 2.2vw, 1rem);
            line-height: 1.7;
        }

        .featured-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .featured-primary-btn,
        .featured-secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .featured-primary-btn {
            background: #0D0DE0;
            color: #ffffff;
            box-shadow: 0 18px 36px -16px rgba(13, 13, 224, 0.35);
        }

        .featured-primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 48px -18px rgba(13, 13, 224, 0.45);
        }

        .featured-service-media {
            display: flex;
            align-items: stretch;
            justify-content: center;
        }

        .featured-media-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: clamp(4.3rem, 8.5vw, 6.8rem);
            overflow: hidden;
        }

        .featured-media-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
            transition: transform 0.6s ease;
        }

        .featured-media-wrapper:hover img {
            transform: scale(1.05);
        }

        .featured-media-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top right, rgba(13, 13, 224, 0.18), transparent 55%);
        }

        .services-grid {
            row-gap: clamp(3.25rem, 6vw, 4.5rem);
            column-gap: clamp(1.75rem, 3vw, 2.5rem);
        }

        .service-card {
            border-radius: 28px;
            overflow: hidden;
            background: linear-gradient(180deg, #ffffff 0%, #f9fafc 100%);
        }

        .service-image-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .service-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .service-card:hover .service-image-wrapper img {
            transform: scale(1.06);
        }

        .service-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(14, 23, 42, 0.35), transparent 55%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .service-card:hover .service-image-overlay {
            opacity: 1;
        }

        .service-card-content {
            padding: clamp(1.5rem, 3vw, 2rem);
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            flex: 1;
        }

        .service-category {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0D0DE0;
            background: rgba(13, 13, 224, 0.12);
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .service-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.35;
        }

        .service-card-description {
            color: #475569;
            font-size: 0.9375rem;
            line-height: 1.7;
            flex: 1;
        }

        .service-card-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            border-radius: 999px;
            border: 2px solid #0D0DE0;
            color: #0D0DE0;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
            width: max-content;
        }

        .service-card-button:hover {
            background: #0D0DE0;
            color: #ffffff;
            transform: translateX(4px);
            box-shadow: 0 14px 32px -16px rgba(13, 13, 224, 0.5);
        }

        .service-button-icon {
            width: 1rem;
            height: 1rem;
        }

        .service-card-item.see-more-card {
            border: 2px dashed #0D0DE0;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 28px;
            display: flex;
            align-items: stretch;
        }

        .service-card-item.see-more-card:hover {
            border-color: #0D0DE0;
            background: #f8f9ff;
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(13, 13, 224, 0.12);
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

        .service-card-item.see-more-card:hover .see-more-icon-wrapper {
            background: #0D0DE0;
            transform: scale(1.1);
        }

        .see-more-card-icon {
            width: 32px;
            height: 32px;
            color: #0D0DE0;
            transition: all 0.3s ease;
        }

        .service-card-item.see-more-card:hover .see-more-card-icon {
            color: white;
            transform: rotate(90deg);
        }

        .see-more-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0D0DE0;
            margin: 0;
            transition: color 0.3s ease;
        }

        .service-card-item.see-more-card.loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }

        .service-card-item.see-more-card.loading .see-more-card-icon {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-card-item.fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        @media (max-width: 1024px) {
            .featured-service-card {
                text-align: center;
            }

            .featured-service-content {
                align-items: center;
            }

            .featured-actions {
                justify-content: center;
            }

            .featured-service-media {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .services-grid {
                row-gap: clamp(2.5rem, 8vw, 3.25rem);
                column-gap: 1.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const servicesSection = document.querySelector('.services-section');
            const container = document.getElementById('servicesCardsContainer');

            if (!servicesSection || !container) return;

            const serviceCards = Array.from(container.querySelectorAll('.service-card-item[data-type="service"]'));
            const seeMoreCard = document.getElementById('servicesSeeMoreCard');
            const totalServices = serviceCards.length;
            const cardsPerPage = 7;
            let shownCount = Math.min(cardsPerPage, totalServices);
            let initialAnimated = false;

            function animateCards(cards) {
                const validCards = cards.filter(Boolean);
                if (!validCards.length) return;

                if (typeof window.gsap !== 'undefined') {
                    gsap.fromTo(validCards, {
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
                    validCards.forEach((card, index) => {
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
                if (initialAnimated) return;
                initialAnimated = true;
                animateCards(serviceCards.slice(0, shownCount));
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            triggerInitialAnimation();
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.25
                });

                observer.observe(servicesSection);
            } else {
                triggerInitialAnimation();
            }

            if (seeMoreCard) {
                seeMoreCard.addEventListener('click', function () {
                    if (this.classList.contains('loading')) return;

                    this.classList.add('loading');

                    const nextBatch = Math.min(shownCount + cardsPerPage, totalServices);
                    const cardsToShow = serviceCards.slice(shownCount, nextBatch);

                    setTimeout(() => {
                        cardsToShow.forEach(card => {
                            card.style.display = 'block';

                            const img = card.querySelector('img');
                            if (img) {
                                img.loading = 'lazy';
                            }
                        });

                        animateCards(cardsToShow);

                        shownCount = nextBatch;

                        if (shownCount >= totalServices) {
                            this.style.display = 'none';
                        }

                        this.classList.remove('loading');
                    }, 200);
                });
            }
        });
    </script>
</x-layout>


