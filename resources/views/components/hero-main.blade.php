@props(['hero' => null])

@php
    $title = $hero['title'] ?? __('Software Defined Vehicles');
    $description = $hero['description'] ?? __("Innovative Tomorrow's Mobility");
    $ctaLabel = $hero['cta_label'] ?? __('Connect Us');
    $ctaHref = $hero['cta_href'] ?? '#contact';
    $imageUrl = $hero['image_url'] ?? asset('images/main-white.png');
    $videoUrl = $hero['video_url'] ?? asset('video/main-video.mp4');

    $descriptionPrimary = trim($description);
    $descriptionAccent = null;

    if (str_contains($descriptionPrimary, ' ')) {
        $lastSpace = strrpos($descriptionPrimary, ' ');
        if ($lastSpace !== false) {
            $descriptionAccent = trim(substr($descriptionPrimary, $lastSpace + 1));
            $descriptionPrimary = trim(substr($descriptionPrimary, 0, $lastSpace));
            if ($descriptionAccent === '') {
                $descriptionAccent = null;
            }
        }
    }
@endphp

<section class="relative h-screen w-full hero-main" style="margin: 0; padding: 0; z-index: 1 !important;">
    <!-- Background Image - overflow handled here, not on parent -->
    <div class="absolute inset-0 z-0 bg-gray-900" style="overflow: hidden;">
        <img
            src="{{ $imageUrl }}"
            alt="{{ $title }}"
            class="absolute inset-0 w-full h-full object-cover hero-bg-image"
            loading="eager"
            style="will-change: opacity;"
        />
        <!-- Background Video (hover to reveal) -->
        @if($videoUrl)
            <video
                class="absolute inset-0 w-full h-full object-cover hero-video"
                muted
                loop
                playsinline
                preload="auto"
                style="will-change: opacity;"
            >
                <source src="{{ $videoUrl }}" type="video/mp4">
            </video>
        @endif
    </div>

    <!-- Overlay Section - Light overlay for text readability -->
    <div class="absolute inset-0 bg-black/10 z-10 pointer-events-none"></div>

    <!-- Content -->
    <div class="relative z-20 h-full flex items-center pointer-events-none hero-content">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="w-full  space-y-10">
                <div class="space-y-10">
                    <!-- Big Text -->
                    <h1 class="hero-title text-2xl sm:text-8xl font-extrabold text-white leading-tight mb-4 md:mb-6 drop-shadow-lg">
                        {{ $title }}
                    </h1>
                    <!-- Medium Text -->
                    <p class="hero-subtitle text-xl sm:text-4xl text-white mb-8 md:mb-10 font-bold drop-shadow-md">
                        {{ $descriptionPrimary }}
                        @if($descriptionAccent)
                            <span class="text-[#0D0DE0] font-bold hero-mobility">{{ $descriptionAccent }}</span>
                        @endif
                    </p>
                </div>

                <!-- Connect Us Button -->
                <a
                    href="{{ $ctaHref }}"
                    class="hero-button inline-block mt-0 sm:mt-16 px-8 py-3 bg-[#0D0DE0] text-white font-semibold text-lg rounded-full hover:bg-[#0a0ab3] transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 pointer-events-auto"
                >
                    {{ $ctaLabel }}
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-main {
        position: relative;
        margin: 0;
        padding: 0;
        /* CRITICAL: Don't use overflow-hidden on parent to allow fixed navbar to work */
        /* Overflow is handled on child elements only */
    }

    .hero-bg-image {
        opacity: 1;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
        will-change: opacity;
    }

    .hero-video {
        opacity: 0;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
        will-change: opacity;
    }

    .hero-main:hover .hero-bg-image {
        opacity: 0;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-main:hover .hero-video {
        opacity: 1;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Smooth transition when hover ends */
    .hero-main:not(:hover) .hero-bg-image {
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-main:not(:hover) .hero-video {
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hide content when hovering (video is playing) */
    .hero-content {
        opacity: 1;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
        will-change: opacity;
    }

    .hero-main:hover .hero-content {
        opacity: 0;
        transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Initial states for GSAP animations */
    .hero-title,
    .hero-subtitle,
    .hero-button {
        opacity: 0;
        will-change: transform, opacity;
    }

    /* Mobile responsiveness */
    @media (max-width: 640px) {
        .hero-main h1 {
            font-size: 2rem;
            line-height: 1.2;
        }

        .hero-main p {
            font-size: 1.125rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const heroSection = document.querySelector('.hero-main');
        const video = document.querySelector('.hero-video');
        const heroTitle = document.querySelector('.hero-title');
        const heroSubtitle = document.querySelector('.hero-subtitle');
        const heroMobility = document.querySelector('.hero-mobility');
        const heroButton = document.querySelector('.hero-button');

        // GSAP Animations for Hero Content
        if (typeof gsap !== 'undefined') {
            // Create a master timeline
            const heroTL = gsap.timeline({ delay: 0.3 });

            // Animate title - fade in + slide up
            if (heroTitle) {
                gsap.set(heroTitle, {
                    opacity: 0,
                    y: 60,
                    clipPath: 'inset(0 0 100% 0)'
                });
                heroTL.to(heroTitle, {
                    opacity: 1,
                    y: 0,
                    clipPath: 'inset(0 0 0% 0)',
                    duration: 1.2,
                    ease: 'power3.out'
                });
            }

            // Animate subtitle - fade in + slide up with stagger
            if (heroSubtitle) {
                gsap.set(heroSubtitle, {
                    opacity: 0,
                    y: 40
                });
                heroTL.to(heroSubtitle, {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power2.out'
                }, '-=0.6');
            }

            // Animate "Mobility" word with special effect
            if (heroMobility) {
                gsap.set(heroMobility, {
                    opacity: 0,
                    scale: 0.8
                });
                heroTL.to(heroMobility, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.8,
                    ease: 'back.out(1.7)'
                }, '-=0.4');
            }

            // Animate button - fade in + scale
            if (heroButton) {
                gsap.set(heroButton, {
                    opacity: 0,
                    scale: 0.9,
                    y: 20
                });
                heroTL.to(heroButton, {
                    opacity: 1,
                    scale: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'back.out(1.4)'
                }, '-=0.5');
            }

            // Optional: Parallax effect on scroll (subtle)
            if (heroTitle || heroSubtitle) {
                let lastScrollY = window.scrollY;
                window.addEventListener('scroll', () => {
                    const currentScrollY = window.scrollY;
                    if (currentScrollY < window.innerHeight) {
                        const scrollProgress = currentScrollY / window.innerHeight;
                        const parallaxOffset = scrollProgress * 30;

                        if (heroTitle) {
                            gsap.to(heroTitle, {
                                y: parallaxOffset * 0.5,
                                opacity: 1 - scrollProgress * 0.3,
                                duration: 0.3,
                                ease: 'none'
                            });
                        }

                        if (heroSubtitle) {
                            gsap.to(heroSubtitle, {
                                y: parallaxOffset * 0.3,
                                opacity: 1 - scrollProgress * 0.2,
                                duration: 0.3,
                                ease: 'none'
                            });
                        }
                    }
                }, { passive: true });
            }
        }

        // Video hover functionality
        if (video && heroSection) {
            // Use mouseover and mouseout for better detection
            heroSection.addEventListener('mouseenter', function () {
                if (video.readyState >= 2) { // HaveFutureData
                    video.play().catch(function (error) {
                        console.log('Video play prevented:', error);
                    });
                } else {
                    video.addEventListener('loadeddata', function playVideo() {
                        video.play().catch(function (error) {
                            console.log('Video play prevented:', error);
                        });
                        video.removeEventListener('loadeddata', playVideo);
                    });
                }
            });

            heroSection.addEventListener('mouseleave', function () {
                video.pause();
                video.currentTime = 0;
            });

            // Also trigger on mousemove to ensure it works when moving over different parts
            heroSection.addEventListener('mousemove', function () {
                if (video.paused && !video.ended) {
                    video.play().catch(function (error) {
                        // Silently handle autoplay restrictions
                    });
                }
            });
        }
    });
</script>
