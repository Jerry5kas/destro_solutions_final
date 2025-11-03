@props([
    'variant' => 'complex', // 'complex' for home.blade.php, 'simple' for home2.blade.php
    'prefix' => 'nav', // Prefix for unique IDs to avoid conflicts
    'hideNavLogo' => false, // Hide the logo in the nav bar (for home.blade.php)
])

@php
    $navId = $prefix . '-header';
    $logoBarId = $prefix . '-logoBar';
    $logoInBarId = $prefix . '-logoInBar';
    $mainNavId = $prefix . '-mainNav';
    $navLogoId = $prefix . '-navLogo';
    $mobileMenuId = $prefix . '-mobileMenu';
    $btnMobileId = $prefix . '-btn-mobile-top';
    $langBtnId = $prefix . '-lang-btn';
    $langDropdownId = $prefix . '-lang-dropdown';

    // Navigation items
    $navItems = [
        ['label' => __('Home'), 'href' => '/'],
        ['label' => __('Quantum'), 'href' => '#'],
        ['label' => __('Services'), 'href' => '#services'],
        ['label' => __('Products'), 'href' => '#products'],
        ['label' => __('Training'), 'href' => '#'],
        ['label' => __('Blog'), 'href' => '#'],
        ['label' => __('Contact Us'), 'href' => '#contact'],
    ];

    // For simple variant, use different items
    $simpleNavItems = [
        ['label' => 'Home', 'href' => '#home'],
        ['label' => 'About', 'href' => '#about'],
        ['label' => 'Services', 'href' => '#services'],
        ['label' => 'Products', 'href' => '#products'],
        ['label' => 'Team', 'href' => '#team'],
        ['label' => 'Contact', 'href' => '#contact'],
    ];
@endphp

@if($variant === 'complex')
  <!-- Complex Navbar (for home.blade.php) -->
  <header id="{{ $navId }}" class="fixed top-0 w-full bg-white" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: fixed !important; z-index: 10000 !important;">
    
    <div id="{{ $logoBarId }}" class="logo-bar">
      <div class="mx-auto max-w-[1280px] px-4 md:px-8 py-3 sm:py-4 md:py-5 lg:py-6 flex items-center justify-between gap-2 sm:gap-4">
        <div id="{{ $logoInBarId }}" class="flex items-center">
          <div class="flex flex-col leading-tight">
            <span class="text-xl sm:text-2xl md:text-3xl lg:text-4xl text-[#0D0DE0] tracking-tight passero-one-regular">Destrsolutions</span>
            <span class="hidden md:block text-xs font-bold text-gray-500">{{ __('Bringing SDV to Life') }}</span>
          </div>
        </div>
        <div class="flex items-center gap-4 text-gray-700">
          <button id="{{ $btnMobileId }}" class="sm:hidden p-2 -mr-2" aria-label="Open menu" aria-expanded="false">
            <svg class="w-6 h-6 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Primary nav -->
    <div class="nav-wrap bg-white border-transparent w-full">
      <nav id="{{ $mainNavId }}">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 relative flex items-center w-full">
          <!-- Logo Image - Only visible in collapsed mode, positioned absolutely -->
          <!-- Logo Text - Only visible in collapsed mode -->
          <div id="{{ $prefix }}-d-logo" class="nav-d-logo select-none">
            <span class="text-xl sm:text-2xl md:text-3xl text-[#0D0DE0] passero-one-regular">DS</span>
          </div>

          <ul class="nav-list hidden sm:flex items-center gap-8 overflow-x-auto text-gray-600 flex-1">
            @foreach($navItems as $index => $item)
            <li class="nav-item">
              <a class="nav-link hover:text-[#0D0DE0] whitespace-nowrap relative text-sm font-semibold" href="{{ $item['href'] }}">
                {{ $item['label'] }}
                <span class="nav-link-underline"></span>
              </a>
            </li>
            @endforeach
          </ul>
          <div class="nav-right hidden sm:flex items-center gap-4 pl-4">
            <button class="nav-icon-btn p-2 text-gray-700 hover:text-gray-900 transition-transform duration-200 hover:scale-110" aria-label="Search">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </button>
            <!-- language button with dropdown -->
            <div class="relative">
              <button id="{{ $langBtnId }}" class="nav-icon-btn p-2 text-gray-700 hover:text-gray-900 transition-transform duration-200 hover:scale-110" aria-label="Language" aria-expanded="false">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
              </button>
              <div id="{{ $langDropdownId }}" class="nav-dropdown absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-200 hidden overflow-hidden" style="z-index: 10100;">
                <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white {{ app()->getLocale() === 'en' ? 'bg-[#0D0DE0]/10 font-semibold' : '' }}">
                  {{ __('English') }}
                </a>
                <a href="{{ route('locale.switch', 'de') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white {{ app()->getLocale() === 'de' ? 'bg-[#0D0DE0]/10 font-semibold' : '' }}">
                  {{ __('Deutsch') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <!-- Mobile menu -->
    <div id="{{ $mobileMenuId }}" class="md:hidden border-t border-gray-200 bg-white hidden overflow-hidden">
      <div class="px-4 py-3 flex items-center gap-3">
        <input class="flex-1 bg-transparent border-b border-gray-300 focus:border-[#0D0DE0] outline-none text-sm py-1 placeholder:text-gray-400" placeholder="{{ __('Search') }}"/>
        <button class="p-2 text-gray-700" aria-label="Language">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </button>
      </div>
      <ul class="px-4 pb-4 space-y-3 text-[#0D0DE0]">
        @foreach($navItems as $item)
        <li><a class="block py-2 text-sm font-semibold" href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
    </div>
  </header>

  @push('scripts')
  <script>
    (function() {
      const prefix = '{{ $prefix }}';
      const btnMobile = document.getElementById(prefix + '-btn-mobile-top');
      const mobileMenu = document.getElementById(prefix + '-mobileMenu');
      const langBtn = document.getElementById(prefix + '-lang-btn');
      const langDropdown = document.getElementById(prefix + '-lang-dropdown');

      // Mobile menu toggle with animation
      if (btnMobile && mobileMenu) {
        btnMobile.addEventListener('click', () => {
          const isOpen = !mobileMenu.classList.contains('hidden');

          if (typeof gsap !== 'undefined') {
            if (isOpen) {
              // Close menu
              gsap.to(mobileMenu, {
                height: 0,
                opacity: 0,
                duration: 0.3,
                ease: 'power2.inOut',
                onComplete: () => {
                  mobileMenu.classList.add('hidden');
                  mobileMenu.style.height = '';
                }
              });
            } else {
              // Open menu
              mobileMenu.classList.remove('hidden');
              mobileMenu.style.height = '0';
              mobileMenu.style.opacity = '0';

              // Force reflow
              mobileMenu.offsetHeight;

              const height = mobileMenu.scrollHeight;
              gsap.to(mobileMenu, {
                height: height + 'px',
                opacity: 1,
                duration: 0.4,
                ease: 'power2.out'
              });
            }
          } else {
            mobileMenu.classList.toggle('hidden');
          }

          btnMobile.setAttribute('aria-expanded', String(!isOpen));
        });
      }

      // Language dropdown toggle with animation
      if (langBtn && langDropdown) {
        langBtn.addEventListener('click', (e) => {
          e.preventDefault();
          const open = !langDropdown.classList.contains('hidden');

          if (typeof gsap !== 'undefined') {
            if (open) {
              // Close dropdown
              gsap.to(langDropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95,
                duration: 0.2,
                ease: 'power2.in',
                onComplete: () => {
                  langDropdown.classList.add('hidden');
                }
              });
            } else {
              // Open dropdown
              langDropdown.classList.remove('hidden');
              gsap.fromTo(langDropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95
              }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.3,
                ease: 'back.out(1.2)'
              });
            }
          } else {
            langDropdown.classList.toggle('hidden');
          }

          langBtn.setAttribute('aria-expanded', String(!open));
        });

        document.addEventListener('click', (e) => {
          if (!langDropdown.contains(e.target) && !langBtn.contains(e.target)) {
            if (!langDropdown.classList.contains('hidden')) {
              if (typeof gsap !== 'undefined') {
                gsap.to(langDropdown, {
                  opacity: 0,
                  y: -10,
                  scale: 0.95,
                  duration: 0.2,
                  ease: 'power2.in',
                  onComplete: () => {
                    langDropdown.classList.add('hidden');
                  }
                });
              } else {
                langDropdown.classList.add('hidden');
              }
              langBtn.setAttribute('aria-expanded', 'false');
            }
          }
        });
      }

      // GSAP animations for nav items on load
      if (typeof gsap !== 'undefined') {
        const navItems = document.querySelectorAll('#' + prefix + '-mainNav .nav-item');
        if (navItems.length > 0) {
          gsap.fromTo(navItems, {
            opacity: 0,
            y: -10
          }, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            stagger: 0.08,
            ease: 'power2.out',
            delay: 0.2
          });
        }
      }
    })();
  </script>
  @endpush

@else
  <!-- Simple Navbar (for home2.blade.php) -->
  <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0 flex items-center">
            <span class="font-orbitron text-2xl font-bold tracking-wide">DESTROSOLUTIONS</span>
          </div>
          <div class="hidden md:ml-10 md:flex md:space-x-8">
            @foreach($simpleNavItems as $item)
            <a href="{{ $item['href'] }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-theme text-sm font-medium transition-colors duration-300">{{ $item['label'] }}</a>
            @endforeach
          </div>
        </div>
        <div class="hidden md:flex items-center">
          <a href="#" class="bg-theme text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors duration-300">Get Started</a>
        </div>
        <div class="md:hidden flex items-center">
          <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-theme focus:outline-none">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="md:hidden bg-white shadow-lg">
      <div class="pt-2 pb-3 space-y-1">
        @foreach($simpleNavItems as $item)
        <a href="{{ $item['href'] }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium hover:border-theme hover:bg-gray-50">{{ $item['label'] }}</a>
        @endforeach
        <div class="pt-4 pb-3 border-t border-gray-200">
          <div class="flex items-center px-4">
            <a href="#" class="block w-full bg-theme text-white px-4 py-2 rounded-md text-center font-medium">Get Started</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
@endif

