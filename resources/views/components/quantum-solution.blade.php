@props([
    'contentItems' => collect(),
    'categories' => collect(),
    'selectedCategory' => null,
])

@php
    $contentItems = $contentItems instanceof \Illuminate\Support\Collection ? $contentItems : collect($contentItems);
    $categories = $categories instanceof \Illuminate\Support\Collection ? $categories : collect($categories);
    $totalItems = $contentItems->count();
    $featuredSolutions = $contentItems->take(2);
    $simpleSolutions = $contentItems->skip(2);
    $fallbackQuantumImage = asset('images/quantum.jpeg');
@endphp

<section class="relative w-full pb-24 pt-12 bg-white solutions-section" id="solutions">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        @if($categories->count() > 0)
            <div class="mb-10">
                <div class="flex flex-wrap gap-3 justify-center">
                    <a 
                        href="{{ route('quantum') }}" 
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$selectedCategory ? 'bg-[#0D0DE0] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        {{ __('All') }}
                    </a>
                    @foreach($categories as $category)
                        <a 
                            href="{{ route('quantum', ['category' => $category->slug]) }}" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-[#0D0DE0] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                        >
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Section Header -->
        <!-- <div class="text-center mb-12 md:mb-16 solutions-header">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 solutions-title">
                Our Software-defined Vehicle (SDV) Solutions
            </h2>
            <p class="text-base md:text-lg text-gray-600 max-w-6xl mx-auto leading-relaxed solutions-description">
                Driving the shift towards Software-Defined Vehicles (SDVs). DestroSolutions offers a comprehensive suite of SDV-focused solutions—spanning cloud, edge, in-vehicle systems, and the complete DevSecOps lifecycle—to enable next-generation mobility. We support OEMs and Tier-1s in building modular, scalable, and secure SDV platforms.
            </p>
        </div> -->

        <!-- Featured Solutions (Grid Col-1, Side-by-Side Layout) -->
        <div class=" mb-8">
            @forelse($featuredSolutions as $index => $solution)
                <div class="featured-solution-item flex flex-col md:flex-row {{ $index % 2 === 1 ? 'md:flex-row-reverse' : '' }} gap-6 md:gap-8 items-stretch p-6 md:p-8 overflow-hidden">
                    <!-- Left Side: Content -->
                    <div class="w-full md:w-1/3 flex flex-col justify-center featured-content">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 featured-title">
                            {{ $solution->title }}
                        </h3>
                        <p class="text-base md:text-lg text-gray-600 leading-relaxed mb-6 featured-description line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($solution->description ?? ''), 200) }}
                        </p>
                        <a href="{{ route('content.show', $solution->slug) }}" class="max-w-max border-2 border-[#0D0DE0] text-[#0D0DE0] px-6 py-2.5 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 text-sm md:text-base featured-button">
                            Learn More
                        </a>
                    </div>

                    <!-- Right Side: Image -->
                    <div class="w-full md:w-2/3 featured-image-wrapper flex items-stretch">
                        <div class="relative overflow-hidden w-full featured-image-container rounded-md">
                            <img 
                                src="{{ $solution->image_url ?? $fallbackQuantumImage }}" 
                                alt="{{ $solution->title }}"
                                class="w-full h-full object-cover featured-image rounded-md"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    {{ __('No featured quantum solutions available at the moment.') }}
                </div>
            @endforelse
        </div>

        <!-- Simple Solutions (Grid Col-3) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 md:gap-x-12 gap-y-12 md:gap-y-16 simple-solutions-grid">
            @forelse($simpleSolutions as $solution)
                <x-card-1 
                    :title="$solution->title"
                    :description="\Illuminate\Support\Str::limit(strip_tags($solution->description ?? ''), 180)"
                    buttonText="Learn More"
                    :buttonLink="route('content.show', $solution->slug)"
                />
            @empty
                @if($totalItems === 0)
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12 text-gray-500">
                        {{ __('No quantum solutions available at the moment.') }}
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</section>

<style>
    .solutions-section {
        position: relative;
    }

    .solutions-header {
        will-change: transform, opacity;
    }

    .solutions-title,
    .solutions-description {
        will-change: transform, opacity;
    }

    .featured-solution-item {
        opacity: 0;
        will-change: transform, opacity;
        transform: translateY(30px);
    }

    .featured-image {
        will-change: transform;
        transition: transform 0.5s ease;
    }

    .featured-solution-item:hover .featured-image {
        transform: scale(1.05);
    }

    .featured-image-wrapper {
        position: relative;
        display: flex;
    }

    .featured-image-container {
        width: 100%;
        height: 100%;
        min-height: 150px;
        max-height: 260px;
    }

    @media (min-width: 768px) {
        .featured-solution-item {
            align-items: stretch;
        }

        .featured-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-image-wrapper {
            display: flex;
            align-items: stretch;
            max-height: 260px;
        }

            .featured-image-container {
            min-height: 280px;
            max-height: 420px;
            display: flex;
        }
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .featured-solution-item {
            padding: 1.5rem;
        }

        .featured-image-container {
            min-height: 280px;
        }

        .simple-solutions-grid {
            gap: 2rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const solutionsSection = document.querySelector('.solutions-section');
        const featuredItems = document.querySelectorAll('.featured-solution-item');
        const simpleItems = document.querySelectorAll('.card-1-item');
        const solutionsHeader = document.querySelector('.solutions-header');
        const solutionsTitle = document.querySelector('.solutions-title');
        const solutionsDescription = document.querySelector('.solutions-description');

        if (!solutionsSection) return;

        // Function to match content and image heights
        function matchFeaturedHeights() {
            if (window.innerWidth >= 768) {
                featuredItems.forEach(item => {
                    const content = item.querySelector('.featured-content');
                    const imageWrapper = item.querySelector('.featured-image-wrapper');
                    
                    if (content && imageWrapper) {
                        // Reset heights first
                        imageWrapper.style.height = '';
                        const imageContainer = imageWrapper.querySelector('.featured-image-container');
                        if (imageContainer) {
                            imageContainer.style.height = '';
                        }
                        
                        // Get content height
                        const contentHeight = content.offsetHeight;
                        
                        // Limit image height to max 260px or match content if smaller
                        const targetHeight = Math.min(contentHeight, 260);
                        
                        // Set image wrapper to match content height (capped at 260px)
                        if (contentHeight > 0) {
                            imageWrapper.style.height = targetHeight + 'px';
                            imageWrapper.style.maxHeight = '260px';
                            if (imageContainer) {
                                imageContainer.style.height = targetHeight + 'px';
                                imageContainer.style.maxHeight = '260px';
                            }
                        }
                    }
                });
            } else {
                // Reset on mobile
                featuredItems.forEach(item => {
                    const imageWrapper = item.querySelector('.featured-image-wrapper');
                    const imageContainer = imageWrapper?.querySelector('.featured-image-container');
                    if (imageWrapper) imageWrapper.style.height = '';
                    if (imageContainer) imageContainer.style.height = '';
                });
            }
        }

        // Match heights on load and resize
        matchFeaturedHeights();
        
        // Use ResizeObserver for accurate height matching
        if (window.ResizeObserver && featuredItems.length > 0) {
            featuredItems.forEach(item => {
                const content = item.querySelector('.featured-content');
                if (content) {
                    const resizeObserver = new ResizeObserver(() => {
                        matchFeaturedHeights();
                    });
                    resizeObserver.observe(content);
                }
            });
        } else {
            window.addEventListener('resize', matchFeaturedHeights);
        }
        
        // Also match after images load
        const featuredImages = document.querySelectorAll('.featured-image');
        let loadedCount = 0;
        featuredImages.forEach(img => {
            if (img.complete) {
                loadedCount++;
            } else {
                img.addEventListener('load', () => {
                    loadedCount++;
                    if (loadedCount === featuredImages.length) {
                        setTimeout(matchFeaturedHeights, 100);
                    }
                });
            }
        });
        
        if (loadedCount === featuredImages.length) {
            setTimeout(matchFeaturedHeights, 100);
        }
        
        // Also match after a short delay to ensure layout is complete
        setTimeout(matchFeaturedHeights, 200);
        setTimeout(matchFeaturedHeights, 500);

        // Intersection Observer for scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        // GSAP Animation function
        function animateWithGSAP() {
            if (typeof gsap === 'undefined') return false;

            // Animate header first
            if (solutionsTitle && solutionsDescription) {
                gsap.set([solutionsTitle, solutionsDescription], { opacity: 0, y: 30 });
                gsap.to([solutionsTitle, solutionsDescription], {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power2.out',
                    stagger: 0.2
                });
            }

            // Animate featured solutions
            if (featuredItems.length > 0) {
                gsap.fromTo(featuredItems, {
                    opacity: 0,
                    y: 50,
                    scale: 0.95
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.8,
                    stagger: 0.2,
                    ease: 'power2.out',
                    delay: 0.3
                });
            }

            // Animate simple solutions
            if (simpleItems.length > 0) {
                gsap.fromTo(simpleItems, {
                    opacity: 0,
                    y: 30,
                    scale: 0.98
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power2.out',
                    delay: 0.7
                });
            }

            return true;
        }

        // Simple animation function (fallback)
        function animateSimple() {
            if (solutionsHeader) {
                solutionsHeader.style.opacity = '1';
                solutionsHeader.style.transform = 'translateY(0)';
                solutionsHeader.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            }

            featuredItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                    item.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                }, index * 200 + 300);
            });

            simpleItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                    item.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                }, index * 100 + 700);
            });
        }

        // Observer for scroll-triggered animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                    
                    // Try GSAP first, fallback to simple animation
                    if (!animateWithGSAP()) {
                        animateSimple();
                    }
                }
            });
        }, observerOptions);

        observer.observe(solutionsSection);

        // Image error handling
        const solutionImages = document.querySelectorAll('.featured-image');
        solutionImages.forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=400&fit=crop&auto=format';
            });
        });
    });
</script>

