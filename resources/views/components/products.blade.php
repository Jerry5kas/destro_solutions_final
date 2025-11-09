@props(['productsData' => null])

@php
    $defaultProducts = [
        [
            'title' => 'Automator AI',
            'description' => 'Automator lets OEMs use automation policies to instantly create new vehicle functions',
            'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=600&h=400&fit=crop&auto=format'
        ],
        [
            'title' => 'IDPS (Intrusion Detection and Prevention System)',
            'description' => 'Our IDPS continuously monitors in-vehicle networks and prevent Cyber attacks today and Quantum Era',
            'image' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=600&h=400&fit=crop&auto=format'
        ],
        [
            'title' => 'AI Data Collector',
            'description' => 'Collector is a data acquisition and analytics tool that Collects & Process data for Vehicle Performance with integrated FIR',
            'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&auto=format'
        ],
        [
            'title' => 'SBOM (Software Bill of Materials)',
            'description' => 'SBOM ensure Visibility, Security, Compliance across your Supply chain',
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&auto=format'
        ],
        [
            'title' => 'Vehicle Security Operation Center (vSOC)',
            'description' => 'vSOC is a centralized hub for monitoring, detecting, and responding to cyber threats across Fleet',
            'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600&h=400&fit=crop&auto=format'
        ],
        [
            'title' => 'OTA Updater',
            'description' => 'OTA Updater enables secure over-the-air software updates, with end-to-end Tracebility',
            'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=600&h=400&fit=crop&auto=format'
        ]
    ];

    $products = collect($productsData ?? $defaultProducts)
        ->take(6)
        ->values();
@endphp

<section class="relative w-full py-24 bg-gray-50 products-section" id="products">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        
        <!-- Section Header -->
        <div class="text-center mb-12 md:mb-16 products-header">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold products-title">
                Products
            </h2>
            <p class="text-base md:text-lg text-gray-600 max-w-6xl mx-auto leading-relaxed products-description">
                DestroSolutions delivers a robust portfolio of products engineered for the Software-Defined Vehicle era. Designed for security, compliance, and performance, our solutions seamlessly integrate into modern E/E architectures while aligning with global automotive standards.
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 products-grid">
            @foreach($products as $index => $product)
                <div class="product-card bg-white overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col product-item" data-index="{{ $index }}">
                    <!-- Product Image -->
                    <div class="product-image-wrapper relative h-48 md:h-56 overflow-hidden bg-gray-200">
                        <img 
                            src="{{ $product['image'] }}" 
                            alt="{{ $product['title'] }}"
                            class="w-full h-full object-cover transition-transform duration-500 product-image"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Product Content -->
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 product-title">
                            {{ $product['title'] }}
                        </h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4 flex-1 product-description">
                            {{ $product['description'] }}
                        </p>
                        
                        <!-- Know More Button -->
                        <button class="max-w-max border-2 border-[#0D0DE0] text-[#0D0DE0] px-4 py-2 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 text-sm md:text-base product-button">
                            Know More
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .products-section {
        position: relative;
    }

    .products-header {
        display: flex;
        flex-direction: column;
        gap: clamp(1.75rem, 4vw, 2.75rem);
        align-items: center;
        text-align: center;
        will-change: transform, opacity;
    }

    .products-title,
    .products-description {
        will-change: transform, opacity;
    }

    .product-item {
        opacity: 0;
        will-change: transform, opacity;
        transform: translateY(30px);
    }

    .product-image {
        will-change: transform;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .product-card {
        border-radius: 3rem;
    }

    .products-grid {
        row-gap: clamp(3.25rem, 5vw, 4.5rem);
        column-gap: clamp(1.75rem, 3vw, 2.5rem);
    }

    /* Mobile responsiveness */
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
        const productItems = document.querySelectorAll('.product-item');
        const productsHeader = document.querySelector('.products-header');
        const productsTitle = document.querySelector('.products-title');
        const productsDescription = document.querySelector('.products-description');

        if (!productsSection || productItems.length === 0) return;

        // Intersection Observer for scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        // GSAP Animation function
        function animateWithGSAP() {
            if (typeof gsap === 'undefined') return false;

            // Animate header first
            if (productsTitle && productsDescription) {
                gsap.set([productsTitle, productsDescription], { opacity: 0, y: 30 });
                gsap.to([productsTitle, productsDescription], {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power2.out',
                    stagger: 0.2
                });
            }

            // Animate product cards with stagger
            if (productItems.length > 0) {
                gsap.fromTo(productItems, {
                    opacity: 0,
                    y: 50,
                    scale: 0.95
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power2.out',
                    delay: 0.3
                });
            }

            return true;
        }

        // Simple animation function (fallback)
        function animateSimple() {
            if (productsHeader) {
                productsHeader.style.opacity = '1';
                productsHeader.style.transform = 'translateY(0)';
                productsHeader.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            }

            productItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                    item.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                }, index * 100 + 300);
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

        observer.observe(productsSection);

        // Image error handling - replace broken images with fallback
        const productImages = document.querySelectorAll('.product-image');
        productImages.forEach(img => {
            img.addEventListener('error', function() {
                // Replace with a fallback image if the original fails to load
                this.src = 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=600&h=400&fit=crop&auto=format';
            });
        });
    });
</script>

