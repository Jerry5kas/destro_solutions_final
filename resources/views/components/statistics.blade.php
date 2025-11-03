<section class="relative w-full py-8 md:py-10 bg-[#0D0DE0] statistics-section" id="statistics">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
            
            <!-- Stat 1: 50+ Deployments -->
            <div class="stat-item text-center">
                <div class="stat-number-wrapper mb-2">
                    <span class="stat-number text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight" data-target="50">
                        0
                    </span>
                    <span class="stat-plus text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight">+</span>
                </div>
                <h3 class="stat-label text-base md:text-lg font-semibold text-white mb-1.5">{{ __('Deployments') }}</h3>
                <p class="stat-description text-xs md:text-sm text-white/90 leading-relaxed max-w-xs mx-auto">
                    {{ __('Vehicle innovations now come from software-based features') }}
                </p>
            </div>

            <!-- Stat 2: 100% Efficiency Boost -->
            <div class="stat-item text-center">
                <div class="stat-number-wrapper mb-2">
                    <span class="stat-number text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight" data-target="100">
                        0
                    </span>
                    <span class="stat-percent text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight">%</span>
                </div>
                <h3 class="stat-label text-base md:text-lg font-semibold text-white mb-1.5">{{ __('Efficiency Boost') }}</h3>
                <p class="stat-description text-xs md:text-sm text-white/90 leading-relaxed max-w-xs mx-auto">
                    {{ __('SDV Transformation') }}
                </p>
            </div>

            <!-- Stat 3: 100+ Man Years -->
            <div class="stat-item text-center">
                <div class="stat-number-wrapper mb-2">
                    <span class="stat-number text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight" data-target="100">
                        0
                    </span>
                    <span class="stat-plus text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight">+</span>
                </div>
                <h3 class="stat-label text-base md:text-lg font-semibold text-white mb-1.5">{{ __('Man Years') }}</h3>
                <p class="stat-description text-xs md:text-sm text-white/90 leading-relaxed max-w-xs mx-auto">
                    {{ __('Expertise in developing next-generation vehicle solutions') }}
                </p>
            </div>

        </div>
    </div>
</section>

<style>
    .statistics-section {
        position: relative;
        /* CRITICAL: Don't use overflow-hidden as it breaks fixed navbar */
        /* Use overflow-x: hidden only if needed, but allow overflow-y */
        overflow-x: hidden;
        overflow-y: visible;
        z-index: 1 !important;
    }

    .stat-item {
        opacity: 0;
        will-change: transform, opacity;
    }

    .stat-number-wrapper {
        display: inline-flex;
        align-items: baseline;
        gap: 0.1em;
    }

    .stat-number {
        display: inline-block;
        min-width: 0.5em;
    }

    .stat-plus,
    .stat-percent {
        display: inline-block;
    }

    /* Mobile responsiveness */
    @media (max-width: 640px) {
        .statistics-section {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .stat-item {
            margin-bottom: 1.25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statsSection = document.querySelector('.statistics-section');
        const statItems = document.querySelectorAll('.stat-item');
        const statNumbers = document.querySelectorAll('.stat-number');

        if (!statsSection || statItems.length === 0) return;

        // Intersection Observer for scroll-triggered animations
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };

        // GSAP Animation function
        function animateWithGSAP() {
            if (typeof gsap === 'undefined') return false;

            // Create a timeline for the statistics animation
            const statsTL = gsap.timeline({ delay: 0.2 });

            // Animate each stat item with stagger
            statsTL.fromTo(statItems, {
                opacity: 0,
                y: 30,
                scale: 0.95
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: 'power2.out'
            });

            // Animate counter numbers - each gets its own counter object
            statNumbers.forEach((statNumber, index) => {
                const target = parseInt(statNumber.getAttribute('data-target')) || 0;
                const counter = { value: 0 };
                
                statsTL.to(counter, {
                    value: target,
                    duration: 1.5,
                    ease: 'power2.out',
                    onUpdate: function() {
                        // Round the value and update the display
                        const currentValue = Math.round(counter.value);
                        statNumber.textContent = currentValue;
                    }
                }, 0.3 + (index * 0.1)); // Start counters after items start animating
            });

            return true;
        }

        // Fallback counter animation if GSAP is not available
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const increment = target / (duration / 16); // 60fps
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Simple animation function (fallback)
        function animateSimple() {
            statItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                    item.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                    
                    const statNumber = item.querySelector('.stat-number');
                    if (statNumber) {
                        const target = parseInt(statNumber.getAttribute('data-target')) || 0;
                        animateCounter(statNumber, target);
                    }
                }, index * 200);
            });
        }

        // Single observer that handles both GSAP and fallback animations
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

        observer.observe(statsSection);
    });
</script>
