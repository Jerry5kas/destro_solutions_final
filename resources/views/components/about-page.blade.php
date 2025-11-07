@php
    $slides = [
        [
            'title' => 'Gallery Image 1',
            'description' => 'Gallery showcase image',
            'image' => 'images/gallery1.webp'
        ],
        [
            'title' => 'Gallery Image 2',
            'description' => 'Gallery showcase image',
            'image' => 'images/gallery2.webp'
        ],
        [
            'title' => 'Gallery Image 3',
            'description' => 'Gallery showcase image',
            'image' => 'images/gallery3.webp'
        ],
        [
            'title' => 'Gallery Image 4',
            'description' => 'Gallery showcase image',
            'image' => 'images/gallery4.webp'
        ],
        [
            'title' => 'Gallery Image 5',
            'description' => 'Gallery showcase image',
            'image' => 'images/gallery5.webp'
        ]
    ];
@endphp

<section class="relative w-full py-12 md:py-16 lg:py-20 bg-white about-section" id="about">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
            
            <!-- Left Section: About Us Text -->
            <div class="about-content lg:sticky lg:top-24 flex flex-col gap-y-5">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 about-title">
                    {{ $title ?? __('About Us') }}
                </h2>
                <div class=" leading-loose space-y-4 about-text flex-1 text-gray-500 ">
                    <p>
                        {{ $description ?? __('At DestroSolutions, we enable the future of mobility by driving the transition to Software-Defined Vehicles (SDVs). Our expertise spans end-to-end automotive cybersecurity, software update management, functional safety, and E/E architecture transformation. Our commitment to Safety & security standards, expert training positions us as a trusted partner in delivering tomorrow\'s mobility—today.') }}
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
                                class="about-slide-image w-full h-full object-cover transition-transform duration-700 cursor-pointer"
                                data-image-index="{{ $index }}"
                                data-image-src="{{ str_starts_with($slide['image'], 'http') ? $slide['image'] : asset($slide['image']) }}"
                            />
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

<!-- Lightbox Modal -->
<div id="about-lightbox" class="about-lightbox fixed inset-0 hidden items-center justify-center bg-black/90 backdrop-blur-sm" style="z-index: 10001 !important;">
    <!-- Top Right Controls -->
    <div class="absolute top-4 right-4 flex gap-2 z-[10002]" style="z-index: 10002 !important;">
        <!-- Share Button with Dropdown -->
        <div class="relative share-menu-container">
            <button id="about-lightbox-share" class="text-white hover:text-gray-300 transition-colors p-2 rounded-full hover:bg-white/10" title="Share">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
            </button>
            <!-- Share Dropdown Menu -->
            <div id="about-lightbox-share-menu" class="share-dropdown absolute right-0 top-full mt-2 bg-white rounded-lg shadow-xl border border-gray-200 hidden overflow-hidden min-w-[200px]">
                <a href="#" class="share-option flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors" data-platform="facebook">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span class="text-gray-700">Facebook</span>
                </a>
                <a href="#" class="share-option flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors" data-platform="twitter">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    <span class="text-gray-700">Twitter</span>
                </a>
                <a href="#" class="share-option flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors" data-platform="linkedin">
                    <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <span class="text-gray-700">LinkedIn</span>
                </a>
                <a href="#" class="share-option flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors" data-platform="whatsapp">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span class="text-gray-700">WhatsApp</span>
                </a>
                <a href="#" class="share-option flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors" data-platform="copy">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-gray-700">Copy Link</span>
                </a>
                <div class="border-t border-gray-200"></div>
                <a href="#" id="about-lightbox-download" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors text-gray-700">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>Download</span>
                </a>
            </div>
        </div>
        <!-- Close Button -->
        <button id="about-lightbox-close" class="text-white hover:text-gray-300 transition-colors p-2 rounded-full hover:bg-white/10" title="Close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <img id="about-lightbox-image" src="" alt="" class="about-lightbox-img max-w-[90vw] max-h-[90vh] object-contain rounded-lg relative z-[10001]">
    <button id="about-lightbox-prev" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-[10002]" style="z-index: 10002 !important;">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button id="about-lightbox-next" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-[10002]" style="z-index: 10002 !important;">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>

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

    .about-slide-image {
        cursor: pointer;
    }

    .about-slide:hover .about-slide-image {
        transform: scale(1.05);
    }

    /* Lightbox Styles */
    .about-lightbox {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .about-lightbox:not(.hidden) {
        display: flex;
    }

    .about-lightbox.show {
        opacity: 1;
    }

    .about-lightbox-img {
        animation: lightboxFadeIn 0.3s ease;
    }

    @keyframes lightboxFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Share Dropdown Styles */
    .share-menu-container {
        position: relative;
    }

    .share-dropdown {
        z-index: 10003;
        animation: dropdownFadeIn 0.2s ease;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

        // Lightbox functionality
        const lightbox = document.getElementById('about-lightbox');
        const lightboxImage = document.getElementById('about-lightbox-image');
        const lightboxClose = document.getElementById('about-lightbox-close');
        const lightboxPrev = document.getElementById('about-lightbox-prev');
        const lightboxNext = document.getElementById('about-lightbox-next');
        const slideImages = document.querySelectorAll('.about-slide-image');
        let currentLightboxIndex = 0;

        // Open lightbox with specific image
        function openLightbox(index) {
            if (index < 0 || index >= slides.length) return;
            currentLightboxIndex = index;
            const imageSrc = slideImages[index].getAttribute('data-image-src');
            const imageAlt = slideImages[index].getAttribute('alt');
            lightboxImage.src = imageSrc;
            lightboxImage.alt = imageAlt;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close lightbox
        function closeLightbox() {
            lightbox.classList.remove('show');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }, 300);
        }

        // Navigate to previous image in lightbox
        function showPrevImage() {
            const prevIndex = (currentLightboxIndex - 1 + slides.length) % slides.length;
            openLightbox(prevIndex);
        }

        // Navigate to next image in lightbox
        function showNextImage() {
            const nextIndex = (currentLightboxIndex + 1) % slides.length;
            openLightbox(nextIndex);
        }

        // Add click handlers to images
        slideImages.forEach((img, index) => {
            img.addEventListener('click', (e) => {
                e.stopPropagation();
                openLightbox(index);
            });
        });

        // Close button
        lightboxClose.addEventListener('click', closeLightbox);

        // Navigation buttons
        lightboxPrev.addEventListener('click', (e) => {
            e.stopPropagation();
            showPrevImage();
        });

        lightboxNext.addEventListener('click', (e) => {
            e.stopPropagation();
            showNextImage();
        });

        // Close on background click
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('hidden') && lightbox.classList.contains('show')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    showPrevImage();
                } else if (e.key === 'ArrowRight') {
                    showNextImage();
                }
            }
        });

        // Share functionality
        const shareButton = document.getElementById('about-lightbox-share');
        const shareMenu = document.getElementById('about-lightbox-share-menu');
        const shareOptions = document.querySelectorAll('.share-option');
        const downloadButton = document.getElementById('about-lightbox-download');

        // Toggle share menu
        shareButton.addEventListener('click', (e) => {
            e.stopPropagation();
            shareMenu.classList.toggle('hidden');
        });

        // Close share menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!shareMenu.contains(e.target) && !shareButton.contains(e.target)) {
                shareMenu.classList.add('hidden');
            }
        });

        // Get current page URL and image URL
        function getCurrentImageUrl() {
            return lightboxImage.src;
        }

        function getCurrentPageUrl() {
            return window.location.href;
        }

        // Share on social media
        shareOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const platform = option.getAttribute('data-platform');
                const imageUrl = getCurrentImageUrl();
                const pageUrl = getCurrentPageUrl();
                const imageAlt = lightboxImage.alt || 'Image';

                let shareUrl = '';

                switch(platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(imageAlt)}`;
                        break;
                    case 'linkedin':
                        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(pageUrl)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(pageUrl + ' - ' + imageAlt)}`;
                        break;
                    case 'copy':
                        // Copy link to clipboard
                        navigator.clipboard.writeText(pageUrl).then(() => {
                            // Show feedback
                            const originalText = option.querySelector('span').textContent;
                            option.querySelector('span').textContent = 'Copied!';
                            setTimeout(() => {
                                option.querySelector('span').textContent = originalText;
                            }, 2000);
                        }).catch(err => {
                            console.error('Failed to copy:', err);
                            // Fallback for older browsers
                            const textArea = document.createElement('textarea');
                            textArea.value = pageUrl;
                            document.body.appendChild(textArea);
                            textArea.select();
                            try {
                                document.execCommand('copy');
                                const originalText = option.querySelector('span').textContent;
                                option.querySelector('span').textContent = 'Copied!';
                                setTimeout(() => {
                                    option.querySelector('span').textContent = originalText;
                                }, 2000);
                            } catch (err) {
                                console.error('Fallback copy failed:', err);
                            }
                            document.body.removeChild(textArea);
                        });
                        shareMenu.classList.add('hidden');
                        return;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                    shareMenu.classList.add('hidden');
                }
            });
        });

        // Download functionality
        downloadButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const imageUrl = getCurrentImageUrl();
            const imageAlt = lightboxImage.alt || 'image';

            // Create a temporary anchor element
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = imageAlt.replace(/\s+/g, '-').toLowerCase() + '.' + (imageUrl.split('.').pop().split('?')[0] || 'jpg');
            link.target = '_blank';

            // Handle CORS issues by fetching the image
            fetch(imageUrl)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    link.href = url;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                    shareMenu.classList.add('hidden');
                })
                .catch(err => {
                    console.error('Download error:', err);
                    // Fallback: open in new tab
                    window.open(imageUrl, '_blank');
                    shareMenu.classList.add('hidden');
                });
        });
    });
</script>

