@php
    $slides = [
        [
            'title' => 'End To End Security',
            'description' => 'Secure-by-design solutions across the full vehicle lifecycle—from development to decommissioning.',
            'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&h=600&fit=crop&auto=format'
        ],
        [
            'title' => 'Standards-Aligned Engineering',
            'description' => 'Built to meet ASPICE, AUTOSAR, CSMS, SUMS, FuSa & SOTIF',
            'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&h=600&fit=crop&auto=format'
        ],
        [
            'title' => 'Expert Training & Consulting',
            'description' => 'Upskill your team skills and expertise to drive innovation in the SDV era',
            'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&auto=format'
        ],
        [
            'title' => 'Accelerating the SDV Shift',
            'description' => 'Pioneering Software-Defined Vehicle (SDV) transformations with E/E Systems, OTA',
            'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800&h=600&fit=crop&auto=format'
        ]
    ];
@endphp

<section class="relative w-full py-12 sm:py-24 bg-white about-section" id="about">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
            
            <!-- Left Section: About Us Text -->
            <div class="about-content lg:sticky lg:top-24 flex flex-col gap-y-5">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 about-title">
                    {{ __('About Us') }}
                </h2>
                <div class=" leading-loose space-y-4 about-text flex-1 text-gray-500 ">
                    <p>
                        {{ __('At DestroSolutions, we enable the future of mobility by driving the transition to Software-Defined Vehicles (SDVs). Our expertise spans end-to-end automotive cybersecurity, software update management, functional safety, and E/E architecture transformation. Our commitment to Safety & security standards, expert training positions us as a trusted partner in delivering tomorrow\'s mobility—today.') }}
                    </p>
                </div>

                <button class="max-w-max border-2 border-[#0D0DE0] text-[#0D0DE0] px-4 py-2 rounded-md hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300">
                    {{ __('Learn More') }}
                </button>
            </div>

            <!-- Right Section: Image Slider -->
            <div class="about-slider-wrapper relative flex flex-col h-full">
                <div class="about-slider-container relative flex-1 rounded-lg overflow-hidden shadow-lg">
                    @foreach($slides as $index => $slide)
                        <div class="about-slide absolute inset-0 {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}" id="slide-{{ $index }}">
                            <img 
                                src="{{ str_starts_with($slide['image'], 'http') ? $slide['image'] : asset($slide['image']) }}"
                                alt="{{ $slide['title'] }}"
                                id="slide-image-{{ $index }}"
                                class="w-full h-full object-cover transition-transform duration-700"
                            />
                            <!-- Gradient Overlay - Always Visible -->
                            <!-- <div class="about-overlay absolute inset-0 bg-gradient-to-t from-blue-900/80 via-blue-900/50 to-transparent pointer-events-none z-10"></div> -->
                             
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 pb-16 text-white z-20 bg-gradient-to-t from-blue-900/80 via-blue-900/50 to-transparent">
                                <h3 class="text-xl md:text-2xl font-bold mb-2 drop-shadow-lg">{{ $slide['title'] }}</h3>
                                <p class="text-sm md:text-base leading-relaxed opacity-95 drop-shadow-md">{{ $slide['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Slider Indicators - Inside the image container, positioned at bottom -->
                    <div class="about-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex justify-center gap-2 z-30 pointer-events-auto">
                        @foreach($slides as $index => $slide)
                            <button 
                                class="about-indicator w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'active' : 'bg-white/50' }}"
                                data-slide="{{ $index }}"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .about-section {
        position: relative;
    }

    .about-content {
        will-change: transform, opacity;
    }

    .about-slider-wrapper {
        display: flex;
        flex-direction: column;
    }

    .about-slider-container {
        position: relative;
    }
    
    @media (min-width: 1024px) {
        .about-slider-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .about-slider-container {
            flex: 1;
            min-height: 0;
        }
    }

    .about-title,
    .about-text {
        will-change: transform, opacity;
    }

    .about-slide {
        opacity: 0;
        z-index: 1;
        will-change: transform, opacity;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .about-slide.active {
        opacity: 1;
        z-index: 2;
    }

    .about-overlay {
        opacity: 1 !important;
        z-index: 10;
        background: linear-gradient(to top, 
            rgba(0, 0, 0, 0.85) 0%, 
            rgba(0, 0, 0, 0.75) 30%, 
            rgba(0, 0, 0, 0.5) 60%, 
            rgba(0, 0, 0, 0.2) 100%
        );
        transition: background 0.3s ease;
    }

    .about-slide:hover .about-overlay {
        background: linear-gradient(to top, 
            rgba(0, 0, 0, 0.9) 0%, 
            rgba(0, 0, 0, 0.8) 30%, 
            rgba(0, 0, 0, 0.6) 60%, 
            rgba(0, 0, 0, 0.3) 100%
        );
    }

    .about-slide:hover img {
        transform: scale(1.05);
    }
    
    .about-slide:not(:hover) .about-overlay {
        background: linear-gradient(to top, 
            rgba(0, 0, 0, 0.85) 0%, 
            rgba(0, 0, 0, 0.75) 30%, 
            rgba(0, 0, 0, 0.5) 60%, 
            rgba(0, 0, 0, 0.2) 100%
        );
    }

    .about-indicator {
        cursor: pointer;
        will-change: width, background-color;
    }

    .about-indicator.active {
        width: 2rem;
        background-color: white;
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
    }

    .about-indicator:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.8);
        width: 1.5rem;
    }

    /* Mobile responsiveness */
    @media (max-width: 1024px) {
        .about-content {
            position: static;
        }
        
        .grid {
            grid-template-columns: 1fr;
        }
        
        .about-content {
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 640px) {
        .about-slider-container {
            min-height: 300px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sliderContainer = document.querySelector('.about-slider-container');
        const slides = document.querySelectorAll('.about-slide');
        const indicators = document.querySelectorAll('.about-indicator');
        const aboutContent = document.querySelector('.about-content');
        const sliderWrapper = document.querySelector('.about-slider-wrapper');
        
        if (!sliderContainer || slides.length === 0) return;

        // Match heights: make slider wrapper match content height
        function matchHeights() {
            if (window.innerWidth >= 1024 && aboutContent && sliderWrapper) {
                // Wait for next frame to ensure layout is complete
                requestAnimationFrame(() => {
                    // Get the content height
                    const contentHeight = aboutContent.offsetHeight;
                    
                    // Set slider wrapper to match content height exactly
                    // Indicators are now inside the image, so no need to subtract their height
                    if (contentHeight > 0) {
                        sliderWrapper.style.height = contentHeight + 'px';
                        sliderContainer.style.height = contentHeight + 'px';
                    }
                });
            } else {
                // Reset height on mobile
                sliderWrapper.style.height = '';
                sliderContainer.style.height = '';
            }
        }

        // Match heights with multiple attempts to ensure it works
        function ensureHeightsMatch() {
            matchHeights();
            // Try again after a short delay to ensure content is rendered
            setTimeout(matchHeights, 50);
            setTimeout(matchHeights, 200);
            setTimeout(matchHeights, 500);
        }

        // Match heights on load and resize
        ensureHeightsMatch();
        
        // Use ResizeObserver for more accurate height matching
        if (window.ResizeObserver && aboutContent) {
            const resizeObserver = new ResizeObserver(() => {
                matchHeights();
            });
            resizeObserver.observe(aboutContent);
        } else {
            window.addEventListener('resize', matchHeights);
        }
        
        // Also match after images load
        const images = sliderContainer.querySelectorAll('img');
        let loadedImages = 0;
        images.forEach(img => {
            if (img.complete) {
                loadedImages++;
            } else {
                img.addEventListener('load', () => {
                    loadedImages++;
                    if (loadedImages === images.length) {
                        setTimeout(matchHeights, 100);
                    }
                });
            }
        });
        
        if (loadedImages === images.length) {
            setTimeout(ensureHeightsMatch, 100);
        }
        
        // Also trigger after fonts load
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => {
                setTimeout(matchHeights, 100);
            });
        }

        let currentSlide = 0;
        let autoSlideInterval = null;
        const slideInterval = 4000; // 4 seconds

        // Initialize GSAP animations
        if (typeof gsap !== 'undefined') {
            // Animate about section on scroll
            const aboutSection = document.querySelector('.about-section');
            const aboutContent = document.querySelector('.about-content');
            const aboutTitle = document.querySelector('.about-title');
            const aboutText = document.querySelector('.about-text');
            const aboutSlider = document.querySelector('.about-slider-wrapper');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                        entry.target.classList.add('animated');

                        const tl = gsap.timeline({ delay: 0.2 });

                        // Animate title
                        if (aboutTitle) {
                            gsap.set(aboutTitle, { opacity: 0, y: 30 });
                            tl.to(aboutTitle, {
                                opacity: 1,
                                y: 0,
                                duration: 0.8,
                                ease: 'power2.out'
                            });
                        }

                        // Animate text
                        if (aboutText) {
                            gsap.set(aboutText, { opacity: 0, y: 30 });
                            tl.to(aboutText, {
                                opacity: 1,
                                y: 0,
                                duration: 0.8,
                                ease: 'power2.out'
                            }, '-=0.4');
                        }

                        // Animate slider
                        if (aboutSlider) {
                            gsap.set(aboutSlider, { opacity: 0, x: 30 });
                            tl.to(aboutSlider, {
                                opacity: 1,
                                x: 0,
                                duration: 0.8,
                                ease: 'power2.out'
                            }, '-=0.6');
                        }
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            });

            observer.observe(aboutSection);
        }

        // Function to go to a specific slide
        function goToSlide(index) {
            if (index < 0 || index >= slides.length) return;
            
            // Don't do anything if already on this slide
            if (currentSlide === index) return;

            const prevSlideIndex = currentSlide;
            const prevSlide = slides[prevSlideIndex];
            const nextSlide = slides[index];

            // Update current slide index
            currentSlide = index;

            // Add active class to new slide and indicator
            if (typeof gsap !== 'undefined') {
                // Animate previous slide out
                if (prevSlide && prevSlide !== nextSlide) {
                    gsap.to(prevSlide, {
                        opacity: 0,
                        x: -100,
                        duration: 0.6,
                        ease: 'power2.inOut',
                        onComplete: () => {
                            prevSlide.classList.remove('active');
                        }
                    });
                }

                // Animate new slide in
                gsap.fromTo(nextSlide, {
                    opacity: 0,
                    x: 100
                }, {
                    opacity: 1,
                    x: 0,
                    duration: 0.6,
                    ease: 'power2.inOut',
                    onStart: () => {
                        nextSlide.classList.add('active');
                    }
                });
            } else {
                // Fallback CSS transition
                slides.forEach(slide => slide.classList.remove('active'));
                nextSlide.classList.add('active');
            }

            // Update indicators
            indicators.forEach((indicator, idx) => {
                if (idx === index) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });

            // Reset auto-slide timer
            resetAutoSlide();
        }

        // Auto-slide functionality
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                const nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }, slideInterval);
        }

        function resetAutoSlide() {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
            }
            startAutoSlide();
        }

        // Indicator click handlers
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                goToSlide(index);
            });
        });

        // Pause auto-slide on hover
        sliderContainer.addEventListener('mouseenter', () => {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
            }
        });

        sliderContainer.addEventListener('mouseleave', () => {
            startAutoSlide();
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        sliderContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        sliderContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    goToSlide((currentSlide + 1) % slides.length);
                } else {
                    // Swipe right - previous slide
                    goToSlide((currentSlide - 1 + slides.length) % slides.length);
                }
            }
        }

        // Start auto-slide
        startAutoSlide();
    });
</script>

