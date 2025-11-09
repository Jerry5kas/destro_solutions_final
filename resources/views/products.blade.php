<x-layout title="Destrosolutions - Products">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Products')" 
        :description="__('Explore our productized accelerators for SDV, cybersecurity, and OTA.')"
        imagePath="images/products.jpeg"/>
    
    <!-- Products Intro Section -->
    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6 products-intro-lead">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Accelerators Built for Software-Defined Vehicles') }}
                    </h2>
                </div>
                <div class="space-y-6 products-intro-content">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('Explore our productized accelerators designed to fast-track your Software-Defined Vehicle (SDV) initiatives. From cybersecurity toolkits to OTA command and control, each solution packages deep domain expertise with ready-to-integrate components that shorten time-to-market.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('Built on industry standards including ASPICE, AUTOSAR, CSMS, and SUMS, our products help you deliver secure, safe, and connected vehicles efficiently—while preserving your ability to differentiate at the application and service layers.') }}
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
        $productsCollection = $contentItems instanceof \Illuminate\Support\Collection ? $contentItems : collect($contentItems);
        $productsCategories = $categories instanceof \Illuminate\Support\Collection ? $categories : collect($categories);
        $fallbackProductImage = asset('images/products.jpeg');
    @endphp

    <section class="relative w-full py-24 bg-gray-50 products-section" id="products-list">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">

            @if($productsCategories->count() > 0)
                <div class="mb-10">
                    <div class="flex flex-wrap gap-3 items-center">
                        <a 
                            href="{{ route('products') }}" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$selectedCategory ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                        >
                            {{ __('All') }}
                        </a>
                        @foreach($productsCategories as $category)
                            <a 
                                href="{{ route('products', ['category' => $category->slug]) }}" 
                                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                            >
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 products-grid py-12" id="productsCardsContainer">
                @forelse($productsCollection as $index => $product)
                    <div 
                        class="product-card bg-white overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col product-item product-card-item" 
                        data-index="{{ $index }}"
                        data-type="product"
                        style="display: {{ $index < 7 ? 'block' : 'none' }};"
                    >
                        <div class="product-image-wrapper relative h-48 md:h-56 overflow-hidden bg-gray-200">
                            <img 
                                src="{{ $product->image_url ?? $fallbackProductImage }}" 
                                alt="{{ $product->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 product-image"
                                loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 product-title">
                                {{ $product->title }}
                            </h3>
                            @if($product->description)
                                <p class="text-sm text-gray-600 leading-relaxed mb-4 flex-1 product-description">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 140) }}
                                </p>
                            @endif
                            
                            <button type="button" class="max-w-max border-2 border-[#0D0DE0] text-[#0D0DE0] px-4 py-2 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 text-sm md:text-base product-button">
                                {{ __('Know More') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12 text-gray-500">
                        {{ __('No products available at the moment.') }}
                    </div>
                @endforelse

                @if($productsCollection->count() > 7)
                    <div class="product-card-item see-more-card" data-type="see-more" id="productsSeeMoreCard" style="display: block;">
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
        .products-section {
            position: relative;
        }

        .products-grid {
            row-gap: clamp(3rem, 5vw, 4rem);
            column-gap: clamp(1.75rem, 3vw, 2.5rem);
        }

        .product-item {
            opacity: 0;
            transform: translateY(30px);
            will-change: transform, opacity;
        }

        .product-card {
            border-radius: 3rem;
        }

        .product-image {
            will-change: transform;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .product-card-item.see-more-card {
            border: 2px dashed #0D0DE0;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 3rem;
            display: flex;
            align-items: stretch;
        }

        .product-card-item.see-more-card:hover {
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

        .product-card-item.see-more-card:hover .see-more-icon-wrapper {
            background: #0D0DE0;
            transform: scale(1.1);
        }

        .see-more-card-icon {
            width: 32px;
            height: 32px;
            color: #0D0DE0;
            transition: all 0.3s ease;
        }

        .product-card-item.see-more-card:hover .see-more-card-icon {
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

        .product-card-item.see-more-card.loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }

        .product-card-item.see-more-card.loading .see-more-card-icon {
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

        .product-card-item.fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        @media (max-width: 768px) {
            .products-grid {
                row-gap: clamp(2.5rem, 8vw, 3.25rem);
                column-gap: 1.5rem;
            }

            .product-card {
                max-width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productsSection = document.querySelector('.products-section');
            const container = document.getElementById('productsCardsContainer');

            if (!productsSection || !container) return;

            const productCards = Array.from(container.querySelectorAll('.product-card-item[data-type="product"]'));
            const seeMoreCard = document.getElementById('productsSeeMoreCard');
            const totalProducts = productCards.length;
            const cardsPerPage = 7;
            let shownCount = Math.min(cardsPerPage, totalProducts);
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
                animateCards(productCards.slice(0, shownCount));
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

                observer.observe(productsSection);
            } else {
                triggerInitialAnimation();
            }

            if (seeMoreCard) {
                seeMoreCard.addEventListener('click', function () {
                    if (this.classList.contains('loading')) return;

                    this.classList.add('loading');

                    const nextBatch = Math.min(shownCount + cardsPerPage, totalProducts);
                    const cardsToShow = productCards.slice(shownCount, nextBatch);

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

                        if (shownCount >= totalProducts) {
                            this.style.display = 'none';
                        }

                        this.classList.remove('loading');
                    }, 200);
                });
            }
        });
    </script>
</x-layout>


