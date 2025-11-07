<x-layout title="Destrosolutions - Training">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Training')" 
        :description="__('Hands-on trainings in cybersecurity, functional safety, and ASPICE.')"
        imagePath="images/training.jpeg"/>
    
    <!-- Training Introduction Section -->
    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white" style="z-index: 1;">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6 training-intro-lead">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Expert Training Programs') }}
                    </h2>
                </div>

                <div class="space-y-6 training-intro-content">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('Empower your team with hands-on training in automotive cybersecurity, functional safety, and ASPICE standards. Our expert-led programs cover the latest technologies and methodologies in Software-Defined Vehicles (SDVs), helping your organization build internal capabilities and drive innovation.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('From foundational courses to advanced certifications, we provide comprehensive learning paths tailored to your needs. Each program is designed to deliver practical, real-world skills that your team can immediately apply to accelerate your SDV journey.') }}
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('trainings.index') }}" class="inline-block border-2 border-[#0D0DE0] text-[#0D0DE0] px-6 py-3 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 font-medium">
                            {{ __('Browse All Trainings') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter Section -->
    @if(isset($categories) && $categories->count() > 0)
        <section class="relative w-full py-6 bg-gray-50">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
                <div class="flex flex-wrap gap-3 items-center">
                    <span class="text-sm font-semibold text-gray-700">{{ __('Filter by Category') }}:</span>
                    <a 
                        href="{{ route('training') }}" 
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$selectedCategory ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                    >
                        {{ __('All') }}
                    </a>
                    @foreach($categories as $category)
                        <a 
                            href="{{ route('training', ['category' => $category->slug]) }}" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-[#0D0DE0] text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                        >
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Training Cards Grid Section -->
    @if(isset($trainings) && !empty($trainings))
        <section class="relative w-full py-12 md:py-16 bg-white training-cards-section" id="training-cards">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
                
                <!-- Training Cards Grid -->
                <div class="training-cards-container" id="trainingCardsContainer">
                    @foreach($trainings as $index => $training)
                        <!-- Training Card -->
                        <div class="training-card-item" data-index="{{ $index }}" data-type="training" style="display: {{ $index < 9 ? 'block' : 'none' }};">
                            <div class="training-card-wrapper">
                                <!-- Full Height Image -->
                                <div class="training-card-image">
                                    <img 
                                        src="{{ $training['image'] }}" 
                                        alt="{{ $training['title'] }}"
                                        loading="{{ $index < 9 ? 'eager' : 'lazy' }}"
                                    />
                                    @if($training['category'])
                                        <div class="training-card-badge">
                                            {{ $training['category'] }}
                                        </div>
                                    @endif
                                    
                                    <!-- Title and Date Overlay (Always visible at bottom) -->
                                    <div class="training-card-title-overlay">
                                        <h3 class="training-card-title">
                                            {{ $training['title'] }}
                                        </h3>
                                        @if($training['start_date'] || $training['duration_days'])
                                            <div class="training-card-date">
                                                <svg class="training-date-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>
                                                    @if($training['start_date'])
                                                        {{ $training['start_date'] }}
                                                    @endif
                                                    @if($training['duration_days'])
                                                        @if($training['start_date']) · @endif
                                                        {{ $training['duration_days'] }} {{ __('days') }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Hover Overlay with Description (Slides up on hover) -->
                                    <div class="training-card-hover-overlay">
                                        <div class="training-card-hover-content">
                                            <p class="training-card-hover-description">
                                                {{ Str::limit(strip_tags($training['description'] ?? ''), 150) }}
                                            </p>
                                            <a href="{{ $training['link'] }}" class="training-card-enroll-btn">
                                                <span>{{ __('Enroll Now') }}</span>
                                                <svg class="training-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- See More Card (10th card) -->
                    @if(count($trainings) > 9)
                        <div class="training-card-item see-more-card" data-type="see-more" id="seeMoreCard" style="display: block;">
                            <button type="button" class="see-more-card-button w-full h-full">
                                <div class="training-card-content see-more-content">
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
    @else
        <section class="relative w-full py-12 bg-white">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full text-center">
                <p class="text-gray-600">{{ __('No training programs available at the moment. Please check back later.') }}</p>
            </div>
        </section>
    @endif

    <style>
        /* Training Cards Container */
        .training-cards-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 2rem;
        }

        @media (min-width: 640px) {
            .training-cards-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .training-cards-container {
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
            }
        }

        @media (min-width: 1280px) {
            .training-cards-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Training Card Item */
        .training-card-item {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f3f4f6;
            height: 100%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .training-card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
            border-color: #e5e7eb;
        }

        .training-card-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        /* Full Height Image */
        .training-card-image {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 400px;
            overflow: hidden;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 24px;
        }

        .training-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .training-card-item:hover .training-card-image img {
            transform: scale(1.05);
        }

        /* Title and Date Overlay (Always visible at bottom) */
        .training-card-title-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.94) 60%, rgba(255, 255, 255, 0.88) 100%);
            color: #0f172a;
            padding: 1.25rem 1.5rem;
            z-index: 2;
            transition: opacity 0.3s ease, transform 0.3s ease;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .training-card-item:hover .training-card-title-overlay {
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
        }

        .training-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.4;
            margin: 0 0 0.5rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .training-card-date {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            color: rgba(15, 23, 42, 0.7);
        }

        .training-date-icon {
            width: 0.875rem;
            height: 0.875rem;
            flex-shrink: 0;
        }

        /* Hover Overlay with Description (Slides up on hover) */
        .training-card-hover-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.96) 0%, rgba(255, 255, 255, 0.92) 55%, rgba(255, 255, 255, 0.85) 100%);
            color: #0f172a;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 3;
            max-height: 70%;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .training-card-item:hover .training-card-hover-overlay {
            transform: translateY(0);
        }

        .training-card-hover-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .training-card-hover-description {
            font-size: 0.875rem;
            line-height: 1.6;
            color: rgba(15, 23, 42, 0.75);
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-height: 90px;
        }

        .training-card-enroll-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: transparent;
            color: #0D0DE0;
            border-radius: 999px;
            border: 2px solid #0D0DE0;
            font-weight: 600;
            font-size: 0.8125rem;
            text-decoration: none;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .training-card-enroll-btn:hover {
            background: #0D0DE0;
            color: white;
            transform: translateX(4px);
            box-shadow: 0 10px 20px -12px rgba(13, 13, 224, 0.45);
        }

        .training-card-enroll-btn .training-button-icon {
            width: 1rem;
            height: 1rem;
        }

        .training-card-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(13, 13, 224, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            z-index: 4;
        }

        /* See More Card */
        .see-more-card {
            border: 2px dashed #0D0DE0;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 100%;
        }

        .see-more-card:hover {
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
            min-height: 100%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .see-more-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem 1.5rem;
            width: 100%;
            min-height: 100%;
        }

        .see-more-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 2px solid #0D0DE0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .see-more-card:hover .see-more-icon-wrapper {
            background: #0D0DE0;
            transform: scale(1.1);
        }

        .see-more-card-icon {
            width: 32px;
            height: 32px;
            color: #0D0DE0;
            transition: all 0.3s ease;
        }

        .see-more-card:hover .see-more-card-icon {
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

        .see-more-card:hover .see-more-text {
            color: #0D0DE0;
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

        /* Fade in animation for new cards */
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

        .training-card-item.fade-in {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seeMoreCard = document.getElementById('seeMoreCard');
            const container = document.getElementById('trainingCardsContainer');
            const trainingCards = container.querySelectorAll('.training-card-item[data-type="training"]');
            const totalTrainings = {{ count($trainings) }};
            const cardsPerPage = 9; // Show 9 training cards + 1 See More card = 10 total
            let shownCount = 9; // Initially showing first 9 training cards

            if (!seeMoreCard || trainingCards.length === 0) return;

            seeMoreCard.addEventListener('click', function() {
                if (this.classList.contains('loading')) return;

                this.classList.add('loading');
                
                // Calculate next batch
                const nextBatch = Math.min(shownCount + cardsPerPage, totalTrainings);
                const cardsToShow = nextBatch - shownCount;
                
                // Show next set of training cards
                setTimeout(() => {
                    let cardsShown = 0;
                    for (let i = shownCount; i < nextBatch; i++) {
                        if (trainingCards[i]) {
                            trainingCards[i].style.display = 'block';
                            trainingCards[i].classList.add('fade-in');
                            
                            // Lazy load images
                            const img = trainingCards[i].querySelector('img');
                            if (img) {
                                img.loading = 'lazy';
                            }
                            
                            cardsShown++;
                        }
                    }
                    
                    shownCount = nextBatch;
                    
                    // Hide See More card if all trainings are shown
                    if (shownCount >= totalTrainings) {
                        seeMoreCard.style.display = 'none';
                    }
                    
                    // If we showed less than 9 cards, we need to add a new See More card
                    // But since we're reusing the same card, we just need to reposition it
                    // The card will automatically be in the right position in the grid
                    
                    this.classList.remove('loading');
                }, 300);
            });
        });
    </script>
  
</x-layout>


