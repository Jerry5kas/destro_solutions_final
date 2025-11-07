@php
    $services = [
        [
            'title' => __('Cybersecurity Management Systems'),
            'icon' => 'security',
            'description' => __('Comprehensive security solutions for vehicle systems')
        ],
        [
            'title' => __('Functional Safety'),
            'icon' => 'safety',
            'description' => __('Ensuring safety standards and compliance')
        ],
        [
            'title' => __('Software Update Management Systems'),
            'icon' => 'updates',
            'description' => __('OTA and software lifecycle management')
        ],
        [
            'title' => __('ASPICE (Automotive SPICE)'),
            'icon' => 'aspice',
            'description' => __('Process improvement and assessment')
        ],
        [
            'title' => __('Autosar'),
            'icon' => 'autosar',
            'description' => __('Automotive software architecture standards')
        ],
    ];
@endphp

<section class="services-section relative w-full py-16 md:py-20 lg:py-24 bg-[#0D0DE0]" id="services">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        <!-- Section Title -->
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                {{ __('Services') }}
            </h2>
            <p class="text-lg md:text-xl text-white/90 max-w-4xl mx-auto leading-relaxed">
                {{ __('At DestroSolutions, we provide expert consulting and engineering services to support OEMs and Tier-1 suppliers in delivering secure, compliant, and future-ready vehicle platforms.') }}
            </p>
        </div>

        <!-- Services Slider Container -->
        <div class="services-slider-container relative">
            <!-- Navigation Arrow - Left -->
            <button 
                id="services-slider-prev" 
                class="services-nav-btn absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 z-10 w-12 h-12 md:w-14 md:h-14 bg-white rounded-lg flex items-center justify-center hover:bg-white/90 transition-colors duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                aria-label="Previous service"
            >
                <svg class="w-6 h-6 text-[#0D0DE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Services Slides -->
            <div class="services-slides-wrapper overflow-hidden mx-4 md:mx-8">
                <div id="services-slides" class="services-slides flex transition-transform duration-500 ease-in-out">
                    @foreach($services as $index => $service)
                    <div class="services-slide flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-3 md:px-4" data-slide-index="{{ $index }}">
                        <div class="service-card bg-transparent rounded-lg p-6 md:p-8 text-center h-full flex flex-col">
                            <!-- Service Icon -->
                            <div class="service-icon-wrapper mb-6 flex justify-center flex-shrink-0">
                                <div class="service-icon w-20 h-20 md:w-24 md:h-24 mx-auto text-white">
                                    @if($service['icon'] === 'security')
                                        @include('components.services-icons.security')
                                    @elseif($service['icon'] === 'safety')
                                        @include('components.services-icons.safety')
                                    @elseif($service['icon'] === 'updates')
                                        @include('components.services-icons.updates')
                                    @elseif($service['icon'] === 'aspice')
                                        @include('components.services-icons.aspice')
                                    @elseif($service['icon'] === 'autosar')
                                        @include('components.services-icons.autosar')
                                    @endif
                                </div>
                            </div>

                            <!-- Service Title -->
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-4 flex-shrink-0">
                                {{ $service['title'] }}
                            </h3>

                            <!-- Service Description -->
                            <p class="text-white/80 text-sm md:text-base mb-6 flex-grow">
                                {{ $service['description'] }}
                            </p>

                            <!-- More Button -->
                            <button class="service-more-btn bg-[#0D0DE0] border-2 border-white text-white px-6 py-2.5 rounded-md hover:bg-white hover:text-[#0D0DE0] transition-all duration-300 font-semibold text-sm md:text-base flex-shrink-0">
                                {{ __('More') }}
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrow - Right -->
            <button 
                id="services-slider-next" 
                class="services-nav-btn absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 z-10 w-12 h-12 md:w-14 md:h-14 bg-white rounded-lg flex items-center justify-center hover:bg-white/90 transition-colors duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                aria-label="Next service"
            >
                <svg class="w-6 h-6 text-[#0D0DE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Slider Indicators - Dynamic (max 5) -->
        <div id="services-indicators-container" class="services-indicators flex justify-center items-center gap-2 mt-8 md:mt-12">
            <!-- Indicators will be generated dynamically by JavaScript -->
        </div>
    </div>
</section>

<style>
    .services-section {
        position: relative;
        overflow: hidden;
    }

    .services-slider-container {
        position: relative;
        padding: 0;
    }

    .services-slides-wrapper {
        position: relative;
    }

    .services-slides {
        will-change: transform;
    }

    .services-slide {
        opacity: 0.7;
        transition: opacity 0.5s ease;
    }

    .services-slide.active {
        opacity: 1;
    }

    .service-icon {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .service-icon svg {
        width: 100%;
        height: 100%;
    }

    .service-more-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .services-indicator {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .services-indicator:hover {
        transform: scale(1.2);
    }

    .services-indicator.active {
        background-color: white !important;
        transform: scale(1.3);
    }

    @media (max-width: 768px) {
        .services-slider-container {
            padding: 0 50px;
        }

        .services-nav-btn {
            width: 40px;
            height: 40px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slidesContainer = document.getElementById('services-slides');
        const slides = document.querySelectorAll('.services-slide');
        const indicatorsContainer = document.getElementById('services-indicators-container');
        const prevBtn = document.getElementById('services-slider-prev');
        const nextBtn = document.getElementById('services-slider-next');

        if (!slidesContainer || slides.length === 0) return;

        let currentSlide = 0;
        const totalSlides = slides.length;
        
        function getItemsPerView() {
            return window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
        }

        function getIndicatorCount() {
            const itemsPerView = getItemsPerView();
            // Calculate how many slide positions are available
            // Each position represents a starting point for showing items
            const maxSlideIndex = Math.max(0, totalSlides - itemsPerView);
            return maxSlideIndex + 1;
        }

        let itemsPerView = getItemsPerView();
        let isTransitioning = false;

        // Create dynamic indicators based on items per view
        function createIndicators() {
            indicatorsContainer.innerHTML = '';
            const indicatorCount = getIndicatorCount();
            
            for (let i = 0; i < indicatorCount; i++) {
                const indicator = document.createElement('button');
                indicator.className = 'services-indicator w-3 h-3 rounded-full transition-all duration-300 bg-white/30';
                indicator.setAttribute('data-indicator-index', i);
                indicator.setAttribute('aria-label', `Go to slide ${i + 1}`);
                indicator.addEventListener('click', () => {
                    goToSlide(i);
                });
                indicatorsContainer.appendChild(indicator);
            }
        }

        function updateIndicators() {
            const indicators = indicatorsContainer.querySelectorAll('.services-indicator');
            if (indicators.length === 0) {
                // Recreate indicators if count changed (e.g., on resize)
                createIndicators();
                const newIndicators = indicatorsContainer.querySelectorAll('.services-indicator');
                if (newIndicators.length === 0) return;
                updateIndicatorStyles(newIndicators);
                return;
            }

            // Check if indicator count needs to be updated
            const expectedCount = getIndicatorCount();
            if (indicators.length !== expectedCount) {
                createIndicators();
                const newIndicators = indicatorsContainer.querySelectorAll('.services-indicator');
                updateIndicatorStyles(newIndicators);
                return;
            }

            updateIndicatorStyles(indicators);
        }

        function updateIndicatorStyles(indicators) {
            const slidePosition = currentSlide;
            
            indicators.forEach((indicator, index) => {
                const isActive = index === slidePosition;
                indicator.classList.toggle('active', isActive);
                if (isActive) {
                    indicator.style.backgroundColor = 'white';
                    indicator.style.width = '12px';
                    indicator.style.height = '12px';
                } else {
                    indicator.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                    indicator.style.width = '10px';
                    indicator.style.height = '10px';
                }
            });
        }

        function updateSlider() {
            if (isTransitioning) return;
            
            itemsPerView = getItemsPerView();
            
            // Update slides visibility
            slides.forEach((slide, index) => {
                const isVisible = index >= currentSlide && index < currentSlide + itemsPerView;
                slide.classList.toggle('active', isVisible);
                slide.style.opacity = isVisible ? '1' : '0.5';
            });

            // Calculate transform based on current slide
            const slideWidth = 100 / itemsPerView;
            const translateX = -(currentSlide * slideWidth);
            slidesContainer.style.transform = `translateX(${translateX}%)`;

            // Update indicators
            updateIndicators();

            // Buttons are never disabled in infinite loop mode
            prevBtn.style.opacity = '1';
            prevBtn.style.cursor = 'pointer';
            nextBtn.style.opacity = '1';
            nextBtn.style.cursor = 'pointer';
        }

        function goToSlide(index) {
            itemsPerView = getItemsPerView();
            const maxSlideIndex = totalSlides - itemsPerView;
            currentSlide = Math.max(0, Math.min(index, maxSlideIndex));
            updateSlider();
        }

        function nextSlide() {
            itemsPerView = getItemsPerView();
            const maxSlideIndex = totalSlides - itemsPerView;
            
            if (currentSlide < maxSlideIndex) {
                currentSlide++;
            } else {
                // Loop to beginning
                currentSlide = 0;
                // Smooth transition by temporarily disabling transition
                slidesContainer.style.transition = 'none';
                slidesContainer.style.transform = `translateX(0%)`;
                setTimeout(() => {
                    slidesContainer.style.transition = '';
                    updateSlider();
                }, 50);
                return;
            }
            updateSlider();
        }

        function prevSlide() {
            itemsPerView = getItemsPerView();
            const maxSlideIndex = totalSlides - itemsPerView;
            
            if (currentSlide > 0) {
                currentSlide--;
            } else {
                // Loop to end
                currentSlide = maxSlideIndex;
                // Smooth transition
                slidesContainer.style.transition = 'none';
                const slideWidth = 100 / itemsPerView;
                const translateX = -(maxSlideIndex * slideWidth);
                slidesContainer.style.transform = `translateX(${translateX}%)`;
                setTimeout(() => {
                    slidesContainer.style.transition = '';
                    updateSlider();
                }, 50);
                return;
            }
            updateSlider();
        }

        // Event listeners
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newItemsPerView = getItemsPerView();
                if (newItemsPerView !== itemsPerView) {
                    itemsPerView = newItemsPerView;
                    // Reset to valid position
                    const maxSlideIndex = totalSlides - itemsPerView;
                    if (currentSlide >= maxSlideIndex) {
                        currentSlide = Math.max(0, maxSlideIndex);
                    }
                    // Recreate indicators with new count
                    createIndicators();
                    updateSlider();
                }
            }, 250);
        });

        // Initialize
        createIndicators();
        updateSlider();
    });
</script>

