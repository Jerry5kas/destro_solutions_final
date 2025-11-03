@props([
    'headerPrefix' => 'page', // Prefix for header ID lookup (for navbar collapse integration)
])

<section class="relative bg-gray-50">
  <div class="absolute inset-0 pointer-events-none" aria-hidden="true"></div>

  <div class="relative w-full">
    <!-- Slider -->
    <div id="hero-slider" class="relative">
      <div class="relative overflow-hidden">
        <div class="slides flex">
          <!-- Slide 1 (full-width background) -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
              <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('The AI Playbook') }}</h2>
              <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">
                {{ __('Our whitepaper shows the end-to-end process for successful AI implementations – from ideation to PoC development.') }}
              </p>
              <div class="mt-7">
                <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">
                  {{ __('Download now') }}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
              </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 2 (full-width background) -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1517142089942-ba376ce32a2e?q=80&w=1600&auto=format&fit=crop');"></div>
                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
              <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Citizen Development at Porsche AG') }}</h2>
              <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">
                {{ __('MHP enables significant cost savings through a low-code platform.') }}
              </p>
              <div class="mt-7">
                <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">
                  {{ __('Read the success story') }}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
              </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 3 (full-width background) -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Digital Transformation') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">
                  {{ __('Accelerate your digital journey with cutting-edge solutions and expert guidance.') }}
                </p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">
                    {{ __('Learn more') }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 4 (full-width background) -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Innovation Hub') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">
                  {{ __("Discover how we're shaping the future of technology and business excellence.") }}
                </p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">
                    {{ __('Explore now') }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 5 (full-width background) -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Enterprise Solutions') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">
                  {{ __('Transform your business operations with scalable enterprise-grade solutions.') }}
                </p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">
                    {{ __('Get started') }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 6 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img image-fit" style="background-image:url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('AI Engineering') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Ship reliable AI systems with MLOps, evaluation, and guardrails.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('Discover') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 7 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Cloud Modernization') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Migrate and modernize applications for performance and scalability.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('See how') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 8 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1531297484001-80022131f5a1?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Data Platforms') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Build resilient data platforms that power insights and automation.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('Learn more') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 9 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('DevOps Excellence') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Accelerate delivery with CI/CD and platform engineering.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('Explore') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 10 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1516259762381-22954d7d3ad2?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Product Strategy') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Turn ideas into differentiated digital products.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('Read more') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

          <!-- Slide 11 -->
          <article class="slide relative shrink-0 w-full">
            <div class="absolute inset-0 bg-center bg-cover bg-img" style="background-image:url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1600&auto=format&fit=crop');"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10 items-center py-6 mx-16">
              <div class="bg-white/40 border border-gray-200 rounded-card shadow-glass p-8 md:p-10 lg:p-12">
                <h2 class="text-[36px] leading-tight md:text-5xl lg:text-[56px] font-extrabold tracking-tight text-gray-900">{{ __('Customer Experience') }}</h2>
                <p class="mt-5 text-gray-700 text-base md:text-lg leading-relaxed">{{ __('Design experiences that delight and convert.') }}</p>
                <div class="mt-7">
                  <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#0D0DE0] text-white hover:opacity-90 px-5 py-3 font-semibold shadow">{{ __('Get inspired') }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="h-[360px] md:h-[460px] lg:h-[520px]"></div>
            </div>
          </article>

        </div>
      </div>

      <!-- Bottom navigation -->
      <div id="slider-chrome" class="m-6 pb-6">
        <div class="flex items-center justify-between gap-6">
          <!-- Prev -->
          <button id="btn-prev" class="group inline-flex size-12 items-center justify-center rounded-2xl border border-[#0D0DE0]/30 bg-white hover:bg-[#0D0DE0]/10 active:bg-[#0D0DE0]/20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 text-[#0D0DE0] group-active:translate-x-[-2px] transition"><path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <!-- Indicators (rendered dynamically) -->
          <div id="indicators" class="flex items-center gap-4 mx-auto"></div>

          <!-- Next -->
          <button id="btn-next" class="group inline-flex size-12 items-center justify-center rounded-2xl border border-[#0D0DE0]/30 bg-white hover:bg-[#0D0DE0]/10 active:bg-[#0D0DE0]/20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 text-[#0D0DE0] group-active:translate-x-[2px] transition"><path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  // Wait for GSAP and DOM to be ready
  function initSlider() {
    // Ensure GSAP is loaded
    if (typeof gsap === 'undefined') {
      console.error('GSAP is not loaded');
      setTimeout(initSlider, 100); // Retry after 100ms
      return;
    }

    /**
     * Advanced slider with GSAP animations and smooth transitions.
     */

    // Get the header element for navbar collapse functionality (optional)
    const headerEl = document.getElementById('{{ $headerPrefix }}-header');
    
    const root = document.getElementById('hero-slider');
    if (!root) return;

    const slidesTrack = root.querySelector('.slides');
    const slideEls = Array.from(root.querySelectorAll('.slide'));
    const indicatorsWrap = document.getElementById('indicators');
    let indicators = [];
    const prevBtn = document.getElementById('btn-prev');
    const nextBtn = document.getElementById('btn-next');

    if (!slidesTrack || slideEls.length === 0) return;

    const SLIDE_MS = 7000;
    const TRANSITION_MS = 900;
    let index = 0;
    let timerId = 0;
    let isAnimating = false;
    let isPointerDown = false;
    let startX = 0;
    let deltaX = 0;
    let progressTween = null;

    // GSAP timeline for slide transitions
    const slideTL = gsap.timeline({ paused: true });

    function animateToSlide(targetIndex) {
      if (isAnimating || targetIndex === index) return;
      isAnimating = true;

      const prevIndex = index;
      index = (targetIndex + slideEls.length) % slideEls.length;
      const currentSlide = slideEls[prevIndex];
      const nextSlide = slideEls[index];
      const direction = targetIndex > prevIndex || (targetIndex === 0 && prevIndex === slideEls.length - 1) ? 1 : -1;

      // Kill existing animations
      gsap.killTweensOf([slidesTrack, currentSlide, nextSlide]);

      // Animate slide track
      gsap.to(slidesTrack, {
        x: `-${index * 100}%`,
        duration: TRANSITION_MS / 1000,
        ease: 'power3.inOut',
        onComplete: () => {
          isAnimating = false;
        }
      });

      // Fade and scale background images
      const currentBg = currentSlide.querySelector('.bg-img');
      const nextBg = nextSlide.querySelector('.bg-img');

      if (currentBg) {
        gsap.to(currentBg, {
          opacity: 0.85,
          scale: 1.05,
          duration: TRANSITION_MS / 1000,
          ease: 'power2.out'
        });
      }

      if (nextBg) {
        gsap.fromTo(nextBg,
          { opacity: 0.85, scale: 1.05 },
          {
            opacity: 1,
            scale: 1,
            duration: TRANSITION_MS / 1000,
            ease: 'power2.out'
          }
        );
      }

      // Animate content cards
      const currentCard = currentSlide.querySelector('[class*="bg-white"]');
      const nextCard = nextSlide.querySelector('[class*="bg-white"]');

      if (currentCard) {
        gsap.to(currentCard, {
          opacity: 0,
          y: -30 * direction,
          scale: 0.95,
          duration: TRANSITION_MS / 1000,
          ease: 'power3.inOut'
        });
      }

      if (nextCard) {
        gsap.fromTo(nextCard,
          { opacity: 0, y: 30 * direction, scale: 0.95 },
          {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: TRANSITION_MS / 1000,
            ease: 'power3.out',
            delay: 0.15
          }
        );
      }

      // Update active states
      slideEls.forEach((el, idx) => {
        el.classList.toggle('is-active', idx === index);
      });

      buildIndicators();
      updateIndicators();
      startProgress();
      restartAuto();
    }

    function visibleStart() {
      const n = slideEls.length;
      const maxVisible = Math.min(5, n);
      return Math.min(Math.max(index - Math.floor(maxVisible / 2), 0), Math.max(n - maxVisible, 0));
    }

    function buildIndicators() {
      if (!indicatorsWrap) return;
      const n = slideEls.length;
      const maxVisible = Math.min(5, n);
      const start = visibleStart();
      indicatorsWrap.innerHTML = '';
      for (let i = 0; i < maxVisible; i++) {
        const slideIdx = start + i;
        const btn = document.createElement('button');
        btn.className = 'indicator';
        btn.setAttribute('aria-label', `Slide ${slideIdx + 1}`);
        const bar = document.createElement('span');
        bar.className = 'indicator-bar block h-1.5 rounded-full bg-gray-300 overflow-hidden';
        const progress = document.createElement('span');
        progress.className = 'progress block h-full w-0 bg-[#0D0DE0]';
        bar.appendChild(progress);
        btn.appendChild(bar);
        btn.addEventListener('click', () => { if (!isAnimating) goTo(slideIdx); });
        indicatorsWrap.appendChild(btn);
      }
      indicators = Array.from(indicatorsWrap.querySelectorAll('.indicator'));
    }

    function updateIndicators() {
      const start = visibleStart();
      indicators.forEach((indicator, i) => {
        const isActive = (start + i) === index;
        const progressBar = indicator.querySelector('.progress');
        const indicatorBar = indicator.querySelector('.indicator-bar');

        if (!indicatorBar || !progressBar) return;

        indicator.classList.toggle('active', isActive);

        // Animate indicator width: active = 32px (w-8), inactive = 16px (w-4)
        const targetWidth = isActive ? 32 : 16;

        // Animate width smoothly
        gsap.to(indicatorBar, {
          width: targetWidth + 'px',
          duration: 0.5,
          ease: 'power2.inOut'
        });

        // Animate indicator scale with bounce effect
        if (isActive) {
          gsap.to(indicator, {
            scale: 1.15,
            duration: 0.4,
            ease: 'back.out(1.7)'
          });

          // Add glow effect to progress bar
          gsap.to(progressBar, {
            boxShadow: '0 0 12px rgba(13, 13, 224, 0.5)',
            duration: 0.4,
            ease: 'power2.out'
          });
        } else {
          gsap.to(indicator, {
            scale: 1,
            duration: 0.3,
            ease: 'power2.out'
          });

          // Remove glow effect
          gsap.to(progressBar, {
            boxShadow: '0 0 0px rgba(13, 13, 224, 0)',
            duration: 0.3,
            ease: 'power2.out'
          });
        }
      });
    }

    function startProgress() {
      if (progressTween) progressTween.kill();
      const start = visibleStart();
      const activeIndicator = indicators[start !== undefined ? (index - start) : index];
      if (!activeIndicator) return;

      const progressBar = activeIndicator.querySelector('.progress');
      if (!progressBar) return;

      // Reset all progress bars to 0 width
      indicators.forEach((ind) => {
        const bar = ind.querySelector('.progress');
        if (bar) {
          gsap.set(bar, { width: '0%' });
        }
      });

      // Animate active progress bar from 0% to 100%
      progressTween = gsap.to(progressBar, {
        width: '100%',
        duration: SLIDE_MS / 1000,
        ease: 'none'
      });
    }

    function goTo(i) {
      animateToSlide(i);
    }

    function next() {
      goTo((index + 1) % slideEls.length);
    }

    function prev() {
      goTo((index - 1 + slideEls.length) % slideEls.length);
    }

    function restartAuto() {
      clearTimeout(timerId);
      timerId = window.setTimeout(next, SLIDE_MS);
    }

    // Events
    nextBtn.addEventListener('click', next);
    prevBtn.addEventListener('click', prev);

    // Touch/drag support with GSAP
    slidesTrack.addEventListener('pointerdown', (e) => {
      if (isAnimating) return;
      isPointerDown = true;
      startX = e.clientX;
      if (progressTween) progressTween.pause();
    });

    window.addEventListener('pointermove', (e) => {
      if (!isPointerDown || isAnimating) return;
      deltaX = e.clientX - startX;
      const percent = deltaX / slidesTrack.clientWidth;

      // Smooth drag with easing
      gsap.set(slidesTrack, {
        x: `calc(-${index * 100}% + ${deltaX}px)`
      });
    });

    window.addEventListener('pointerup', () => {
      if (!isPointerDown) return;
      isPointerDown = false;

      if (isAnimating) return;

      const threshold = slidesTrack.clientWidth * 0.15;
      if (Math.abs(deltaX) > threshold) {
        deltaX < 0 ? next() : prev();
      } else {
        // Snap back smoothly
        gsap.to(slidesTrack, {
          x: `-${index * 100}%`,
          duration: 0.4,
          ease: 'power2.out',
          onComplete: () => {
            if (progressTween) progressTween.resume();
          }
        });
      }
      deltaX = 0;
    });

    // Compute hero height so header + hero + controls fit in viewport (if header exists)
    function setHeroHeight() {
      const hero = document.getElementById('hero-slider');
      const chrome = document.getElementById('slider-chrome');
      if (!hero) return;
      const viewportH = window.innerHeight || document.documentElement.clientHeight;
      const headerH = headerEl ? headerEl.offsetHeight : 0;
      const chromeH = chrome ? chrome.offsetHeight : 0;
      const targetH = Math.max(360, viewportH - headerH - chromeH);
      hero.style.setProperty('--hero-h', targetH + 'px');
    }

    // Initialize GSAP
    gsap.set(slidesTrack, { x: 0 });

    // Set initial states with entrance animation
    slideEls.forEach((el, idx) => {
      const bgImg = el.querySelector('.bg-img');
      const card = el.querySelector('[class*="bg-white"]');

      if (idx === 0) {
        el.classList.add('is-active');
        // Start slightly animated for entrance effect
        gsap.set(bgImg, { opacity: 0.85, scale: 1.05 });
        gsap.set(card, { opacity: 0, y: 20, scale: 0.98 });

        // Animate to final state on load
        gsap.to(bgImg, {
          opacity: 1,
          scale: 1,
          duration: 1.2,
          ease: 'power2.out',
          delay: 0.2
        });

        gsap.to(card, {
          opacity: 1,
          y: 0,
          scale: 1,
          duration: 0.9,
          ease: 'power3.out',
          delay: 0.4
        });
      } else {
        gsap.set(bgImg, { opacity: 0.85, scale: 1.05 });
        gsap.set(card, { opacity: 0, y: 30, scale: 0.95 });
      }
    });

    // Build indicators and entrance
    buildIndicators();
    Array.from(indicatorsWrap.querySelectorAll('.indicator')).forEach((ind, i) => {
      const bar = ind.querySelector('.indicator-bar');
      const isFirst = (i === 0);
      if (bar) gsap.set(bar, { width: isFirst ? '32px' : '16px' });
      gsap.set(ind, { opacity: 0, scale: 0.8 });
      gsap.to(ind, { opacity: 1, scale: 1, duration: 0.5, ease: 'back.out(1.7)', delay: 0.6 + (i * 0.1) });
    });

    updateIndicators();
    startProgress();
    restartAuto();
    // Ensure correct hero height on load
    setHeroHeight();

    // Resize handler for hero height
    window.addEventListener('resize', () => {
      clearTimeout(window.__heroResizeTimer);
      window.__heroResizeTimer = setTimeout(setHeroHeight, 120);
    }, { passive: true });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSlider);
  } else {
    initSlider();
  }
</script>
@endpush

