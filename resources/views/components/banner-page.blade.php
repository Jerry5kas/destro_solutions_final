@props([
    'title' => '',
    'description' => null,
    'imagePath' => 'images/default.png',
])

<section class="relative min-h-[60vh] md:min-h-[70vh] w-full banner-page" style="margin: 0; padding: 0; z-index: 1 !important;">
    <div class="absolute inset-0 z-0 bg-gray-900" style="overflow: hidden;">
        @php
            // Force a reliable default image; allow simple override via imagePath
            $imageUrl = asset('images/default.png');
            if (!empty($imagePath) && $imagePath !== 'images/default.png') {
                $imageUrl = asset(ltrim($imagePath, '/'));
            }
        @endphp
        <img
            src="{{ $imageUrl }}"
            alt="{{ $title }}"
            class="absolute inset-0 w-full h-full object-cover banner-bg-image"
            loading="eager"
            style="will-change: opacity;"
        />
    </div>

    <div class="absolute inset-0 bg-black/40 z-10 pointer-events-none"></div>

    <!-- Inset layer for text content area -->
    <!-- <div class="absolute inset-0 pointer-events-none" style="z-index: 15;">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 h-full flex items-center">
            <div class="banner-text-inset bg-gradient-to-r from-black/60 via-black/50 to-transparent rounded-lg backdrop-blur-sm p-6 md:p-8 lg:p-10">
            </div>
        </div>
    </div> -->

    <div class="relative z-20 h-full py-16 md:py-28 flex items-center">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="w-full space-y-4 md:space-y-6">
                <h1 class="banner-title text-3xl sm:text-5xl md:text-7xl font-extrabold text-white leading-tight drop-shadow-lg">{{ $title }}</h1>
                @if($description)
                    <p class="banner-description text-base sm:text-lg md:text-2xl text-white/90 font-normal drop-shadow-md max-w-2xl">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .banner-page { position: relative; margin: 0; padding: 0; }
    .banner-page > div:first-child { position: absolute; inset: 0; width: 100%; height: 100%; }
    .banner-bg-image { opacity: 1; transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1); will-change: opacity; }
    .banner-title, .banner-description { opacity: 0; will-change: transform, opacity; }
    
    /* Inset layer styling */
    .banner-text-inset {
        max-width: fit-content;
        min-width: 300px;
        width: fit-content;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.3), 0 4px 12px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    @media (max-width: 640px) { 
        .banner-page h1 { font-size: 2rem; line-height: 1.2; }
        .banner-text-inset {
            min-width: auto;
            width: 100%;
            padding: 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const titleEl = document.querySelector('.banner-page .banner-title');
  const descEl = document.querySelector('.banner-page .banner-description');
  if (typeof gsap === 'undefined') return;
  const tl = gsap.timeline({ delay: 0.2 });
  if (titleEl) {
    gsap.set(titleEl, { opacity: 0, y: 50, clipPath: 'inset(0 0 100% 0)' });
    tl.to(titleEl, { opacity: 1, y: 0, clipPath: 'inset(0 0 0% 0)', duration: 1.0, ease: 'power3.out' });
  }
  if (descEl) {
    gsap.set(descEl, { opacity: 0, y: 30 });
    tl.to(descEl, { opacity: 1, y: 0, duration: 0.8, ease: 'power2.out' }, '-=0.5');
  }
});
</script>


