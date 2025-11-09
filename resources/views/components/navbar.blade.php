@props([
    'variant' => 'complex', // 'complex' for home.blade.php, 'simple' for home2.blade.php
    'prefix' => 'nav', // Prefix for unique IDs to avoid conflicts
    'hideNavLogo' => false, // Hide the logo in the nav bar (for home.blade.php)
])

@php
    use App\Models\Category;
    
    $navId = $prefix . '-header';
    $logoBarId = $prefix . '-logoBar';
    $logoInBarId = $prefix . '-logoInBar';
    $mainNavId = $prefix . '-mainNav';
    $navLogoId = $prefix . '-navLogo';
    $mobileMenuId = $prefix . '-mobileMenu';
    $btnMobileId = $prefix . '-btn-mobile-top';
    $langBtnId = $prefix . '-lang-btn';
    $langDropdownId = $prefix . '-lang-dropdown';
    $userBtnId = $prefix . '-user-btn';
    $userDropdownId = $prefix . '-user-dropdown';

    // Navigation items
    $navItems = [
        ['label' => __('Home'), 'href' => '/'],
        ['label' => __('Quantum'), 'href' => route('quantum')],
        ['label' => __('Services'), 'href' => route('services')],
        ['label' => __('Products'), 'href' => route('products')],
        ['label' => __('Training'), 'href' => route('training')],
        ['label' => __('Blog'), 'href' => route('blog')],
        ['label' => __('Contact Us'), 'href' => route('contact')],
    ];

    // Get categories for mega menus
    $quantumCategories = Category::getByContentType('quantum');
    $servicesCategories = Category::getByContentType('services');
    $productsCategories = Category::getByContentType('products');
    $trainingCategories = Category::getByContentType('training');
@endphp

@php
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
      <div class="mx-auto max-w-[1280px] px-4 md:px-8 py-2 sm:py-3 md:py-5 lg:py-6 flex items-center justify-between gap-2 sm:gap-4">
        <div id="{{ $logoInBarId }}" class="flex items-center">
          <div class="relative flex items-center justify-center md:justify-start pb-6">
            <div class="flex flex-row items-center gap-4">
            <img
              src="{{ asset('images/Logo-nav.png') }}"
              alt="{{ __('Destro Solutions mark') }}"
              class="h-6 w-auto"
              loading="lazy"
            />
            <img
              src="{{ asset('images/Logo-text.png') }}"
              alt="{{ __('Destro Solutions logo') }}"
              class="h-6  w-auto"
              loading="lazy"
            />
            </div>
            <span class="absolute top-8 left-1/2 md:left-0 -translate-x-1/2 md:translate-x-0 text-[14px] font-semibold text-gray-500 whitespace-nowrap">{{ __('Bringing SDV to Life') }}</span>
          </div>
        </div>
        <div class="flex items-center gap-4 text-gray-700">
          <button id="{{ $btnMobileId }}" class="sm:hidden p-1.5 -mr-1" aria-label="Open menu" aria-expanded="false">
            <svg class="w-5 h-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Primary nav -->
    <div class="nav-wrap bg-white border-transparent w-full">
      <nav id="{{ $mainNavId }}">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 relative flex items-center w-full py-2 sm:py-3 md:py-0">
          <!-- Logo Image - Only visible in collapsed mode, positioned absolutely -->
          <!-- Logo Text - Only visible in collapsed mode -->
          <div id="{{ $prefix }}-d-logo" class="nav-d-logo select-none">
            <img
              src="{{ asset('images/Logo-nav.png') }}"
              alt="{{ __('Destro Solutions mark') }}"
              class="h-6 sm:h-8 w-auto"
              loading="lazy"
            />
          </div>
          <ul class="nav-list hidden sm:flex items-center gap-8 overflow-x-auto text-gray-600 flex-1">
            @foreach($navItems as $index => $item)
            @php 
              $label = strtolower($item['label']);
              $megaKeys = [strtolower(__('Quantum')), strtolower(__('Services')), strtolower(__('Products')), strtolower(__('Training'))];
              $isMega = in_array($label, $megaKeys, true);
              // Map label to content type for mega menu
              $megaTypeMap = [
                strtolower(__('Quantum')) => 'quantum',
                strtolower(__('Services')) => 'services',
                strtolower(__('Products')) => 'products',
                strtolower(__('Training')) => 'training',
              ];
              $megaType = $isMega ? ($megaTypeMap[$label] ?? $label) : null;
            @endphp
            <li class="nav-item" @if($isMega) data-mega="{{ $megaType }}" @endif>
              <a class="nav-link hover:text-[#0D0DE0] whitespace-nowrap relative text-base font-semibold" href="{{ $item['href'] }}" @if($isMega) data-mega-trigger="{{ $megaType }}" @endif>
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
            <!-- User button with dropdown -->
            <div class="relative">
              <button id="{{ $userBtnId }}" class="nav-icon-btn p-2 text-gray-700 hover:text-gray-900 transition-transform duration-200 hover:scale-110" aria-label="User" aria-expanded="false">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </button>
              <div id="{{ $userDropdownId }}" class="nav-dropdown absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 hidden overflow-hidden" style="z-index: 10100;">
                @auth
                  @php
                    $firstName = explode(' ', Auth::user()->name)[0];
                  @endphp
                  <div class="px-4 py-2 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">{{ $firstName }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                  </div>
                  <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white">
                    {{ __('Dashboard') }}
                  </a>
                  <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white">
                    {{ __('Profile') }}
                  </a>
                  <div class="border-t border-gray-200"></div>
                  <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white">
                      {{ __('Sign Out') }}
                    </button>
                  </form>
                @else
                  <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white">
                    {{ __('Sign In') }}
                  </a>
                  <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0D0DE0] hover:text-white">
                    {{ __('Sign Up') }}
                  </a>
                @endauth
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <!-- Mobile menu -->
    <div id="{{ $mobileMenuId }}" class="md:hidden border-t border-gray-200 bg-white hidden overflow-hidden">
      <div class="px-4 pt-4 pb-3 flex flex-col items-center justify-between gap-3 border-b border-gray-200">
        <div class="flex items-center gap-3">
          <img
            src="{{ asset('images/Logo-nav.png') }}"
            alt="{{ __('Destro Solutions mark') }}"
            class="h-6 w-auto"
            loading="lazy"
          />
          <img
            src="{{ asset('images/Logo-text.png') }}"
            alt="{{ __('Destro Solutions logo') }}"
            class="h-8 w-auto"
            loading="lazy"
          />
        </div>
      </div>
      <div class="px-4 py-3 flex items-center gap-3">
        <input class="flex-1 bg-transparent border-b border-gray-300 focus:border-[#0D0DE0] outline-none text-sm py-1 placeholder:text-gray-400" placeholder="{{ __('Search') }}"/>
        <button class="p-2 text-gray-700" aria-label="Language">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </button>
      </div>
      <ul class="px-4 pb-4 space-y-3 text-[#0D0DE0]">
        @foreach($navItems as $item)
        @php 
          $label = strtolower($item['label']);
          $megaKeys = [strtolower(__('Quantum')), strtolower(__('Services')), strtolower(__('Products')), strtolower(__('Training'))];
          $isMega = in_array($label, $megaKeys, true);
          // Map label to content type for mega menu
          $megaTypeMap = [
            strtolower(__('Quantum')) => 'quantum',
            strtolower(__('Services')) => 'services',
            strtolower(__('Products')) => 'products',
            strtolower(__('Training')) => 'training',
          ];
          $megaType = $isMega ? ($megaTypeMap[$label] ?? $label) : null;
        @endphp
        <li>
          <a class="block py-2 text-base font-semibold" href="{{ $item['href'] }}" @if($isMega) data-mega-trigger="{{ $megaType }}" @endif>{{ $item['label'] }}</a>
        </li>
        @endforeach
      </ul>
      <!-- Mobile User Menu -->
      <div class="px-4 py-3 border-t border-gray-200">
        @auth
          @php
            $firstName = explode(' ', Auth::user()->name)[0];
          @endphp
          <div class="mb-3">
            <p class="text-sm font-semibold text-gray-900">{{ $firstName }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
          </div>
          <a href="{{ route('user.dashboard') }}" class="block py-2 text-sm font-semibold text-[#0D0DE0]">{{ __('Dashboard') }}</a>
          <a href="{{ route('user.profile.edit') }}" class="block py-2 text-sm font-semibold text-[#0D0DE0]">{{ __('Profile') }}</a>
          <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="block py-2 text-sm font-semibold text-[#0D0DE0]">{{ __('Sign Out') }}</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="block py-2 text-sm font-semibold text-[#0D0DE0]">{{ __('Sign In') }}</a>
          <a href="{{ route('register') }}" class="block py-2 text-sm font-semibold text-[#0D0DE0]">{{ __('Sign Up') }}</a>
        @endauth
      </div>
    </div>
    <!-- Desktop Mega Menus -->
    <x-nav-mega id="nav-mega-quantum" :categories="$quantumCategories" content-type="quantum">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
        @forelse($quantumCategories as $category)
          <a href="{{ route('quantum', ['category' => $category->slug]) }}" class="block p-4 rounded-md border border-gray-100 hover:border-[#0D0DE0]/30">
            <div class="text-sm font-semibold text-gray-900">{{ $category->title }}</div>
            <div class="text-xs text-gray-500 mt-1">Explore {{ $category->title }}</div>
          </a>
        @empty
          <div class="col-span-full text-center text-gray-500 py-4">No categories available</div>
        @endforelse
      </div>
    </x-nav-mega>
    <x-nav-mega id="nav-mega-services" :categories="$servicesCategories" content-type="services">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
        @forelse($servicesCategories as $category)
          <a href="{{ route('services', ['category' => $category->slug]) }}" class="block p-4 rounded-md border border-gray-100 hover:border-[#0D0DE0]/30">
            <div class="text-sm font-semibold text-gray-900">{{ $category->title }}</div>
            <div class="text-xs text-gray-500 mt-1">Explore {{ $category->title }}</div>
          </a>
        @empty
          <div class="col-span-full text-center text-gray-500 py-4">No categories available</div>
        @endforelse
      </div>
    </x-nav-mega>
    <x-nav-mega id="nav-mega-products" :categories="$productsCategories" content-type="products">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
        @forelse($productsCategories as $category)
          <a href="{{ route('products', ['category' => $category->slug]) }}" class="block p-4 rounded-md border border-gray-100 hover:border-[#0D0DE0]/30">
            <div class="text-sm font-semibold text-gray-900">{{ $category->title }}</div>
            <div class="text-xs text-gray-500 mt-1">Explore {{ $category->title }}</div>
          </a>
        @empty
          <div class="col-span-full text-center text-gray-500 py-4">No categories available</div>
        @endforelse
      </div>
    </x-nav-mega>
    <x-nav-mega id="nav-mega-training" :categories="$trainingCategories" content-type="training">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
        @forelse($trainingCategories as $category)
          <a href="{{ route('training', ['category' => $category->slug]) }}" class="block p-4 rounded-md border border-gray-100 hover:border-[#0D0DE0]/30">
            <div class="text-sm font-semibold text-gray-900">{{ $category->title }}</div>
            <div class="text-xs text-gray-500 mt-1">Explore {{ $category->title }}</div>
          </a>
        @empty
          <div class="col-span-full text-center text-gray-500 py-4">No categories available</div>
        @endforelse
      </div>
    </x-nav-mega>
  </header>

  @push('scripts')
  <script>
    (function() {
      const prefix = '{{ $prefix }}';
      const btnMobile = document.getElementById(prefix + '-btn-mobile-top');
      const mobileMenu = document.getElementById(prefix + '-mobileMenu');
      const langBtn = document.getElementById(prefix + '-lang-btn');
      const langDropdown = document.getElementById(prefix + '-lang-dropdown');
      const userBtn = document.getElementById(prefix + '-user-btn');
      const userDropdown = document.getElementById(prefix + '-user-dropdown');

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
              // Close user dropdown if open
              if (userDropdown && !userDropdown.classList.contains('hidden')) {
                gsap.to(userDropdown, {
                  opacity: 0,
                  y: -10,
                  scale: 0.95,
                  duration: 0.2,
                  ease: 'power2.in',
                  onComplete: () => {
                    userDropdown.classList.add('hidden');
                    userBtn.setAttribute('aria-expanded', 'false');
                  }
                });
              }
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

      // User dropdown toggle with animation
      if (userBtn && userDropdown) {
        userBtn.addEventListener('click', (e) => {
          e.preventDefault();
          const open = !userDropdown.classList.contains('hidden');

          if (typeof gsap !== 'undefined') {
            if (open) {
              // Close dropdown
              gsap.to(userDropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95,
                duration: 0.2,
                ease: 'power2.in',
                onComplete: () => {
                  userDropdown.classList.add('hidden');
                }
              });
            } else {
              // Close language dropdown if open
              if (!langDropdown.classList.contains('hidden')) {
                gsap.to(langDropdown, {
                  opacity: 0,
                  y: -10,
                  scale: 0.95,
                  duration: 0.2,
                  ease: 'power2.in',
                  onComplete: () => {
                    langDropdown.classList.add('hidden');
                    langBtn.setAttribute('aria-expanded', 'false');
                  }
                });
              }
              // Open dropdown
              userDropdown.classList.remove('hidden');
              gsap.fromTo(userDropdown, {
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
            userDropdown.classList.toggle('hidden');
          }

          userBtn.setAttribute('aria-expanded', String(!open));
        });

        document.addEventListener('click', (e) => {
          if (!userDropdown.contains(e.target) && !userBtn.contains(e.target)) {
            if (!userDropdown.classList.contains('hidden')) {
              if (typeof gsap !== 'undefined') {
                gsap.to(userDropdown, {
                  opacity: 0,
                  y: -10,
                  scale: 0.95,
                  duration: 0.2,
                  ease: 'power2.in',
                  onComplete: () => {
                    userDropdown.classList.add('hidden');
                  }
                });
              } else {
                userDropdown.classList.add('hidden');
              }
              userBtn.setAttribute('aria-expanded', 'false');
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

    // Navbar collapse/expand functionality - available on all pages
    (function () {
      'use strict';

      // Wait for DOM to be fully ready
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCollapse);
      } else {
        initCollapse();
      }

      function initCollapse() {
        const prefix = '{{ $prefix }}';
        const headerEl = document.getElementById(prefix + '-header');
        if (!headerEl) {
          console.error('[Navbar] Header element #' + prefix + '-header not found!');
          return;
        }

        let isCollapsed = false;
        let lockState = false;
        let lockTimer = null;

        const COLLAPSE_AT = 80;
        const EXPAND_AT = 30;
        const LOCK_DURATION = 300;

        const getScrollY = function () {
          const windowScrollY = window.scrollY !== undefined ? window.scrollY : (window.pageYOffset !== undefined ? window.pageYOffset : 0);
          const docScrollTop = document.documentElement.scrollTop || 0;
          const bodyScrollTop = document.body.scrollTop || 0;
          return Math.max(windowScrollY, docScrollTop, bodyScrollTop);
        };

        function updateNavbarHeights() {
          const logoBar = headerEl.querySelector('.logo-bar');
          const navWrap = headerEl.querySelector('.nav-wrap');
          if (!(logoBar && navWrap)) return;
          void logoBar.offsetHeight; void navWrap.offsetHeight; // force reflow
          const logoBarHeight = logoBar.offsetHeight || 0;
          const navWrapHeight = navWrap.offsetHeight || 0;
          const expandedHeight = logoBarHeight + navWrapHeight;
          const collapsedHeight = navWrapHeight || 64;
          document.documentElement.style.setProperty('--navbar-height', expandedHeight + 'px');
          document.documentElement.style.setProperty('--navbar-collapsed-height', collapsedHeight + 'px');
        }

        function collapseNavbar() {
          if (lockTimer) clearTimeout(lockTimer);
          headerEl.classList.add('header-collapsed');
          document.body.classList.add('navbar-collapsed');
          isCollapsed = true;
          lockState = true;
          lockTimer = setTimeout(() => { lockState = false; lockTimer = null; }, LOCK_DURATION);
        }

        function expandNavbar() {
          if (lockTimer) clearTimeout(lockTimer);
          headerEl.classList.remove('header-collapsed');
          document.body.classList.remove('navbar-collapsed');
          isCollapsed = false;
          lockState = true;
          lockTimer = setTimeout(() => { lockState = false; lockTimer = null; }, LOCK_DURATION);
        }

        function applyHeaderState() {
          const y = getScrollY();
          const isMobile = window.innerWidth < 640;
          if (isMobile) {
            if (isCollapsed) expandNavbar();
            return;
          }
          if (lockState) return;
          if (!isCollapsed && y > COLLAPSE_AT) {
            collapseNavbar();
            return;
          }
          if (isCollapsed && y < EXPAND_AT) {
            expandNavbar();
            return;
          }
        }

        // Initialize
        headerEl.classList.remove('header-collapsed');
        document.body.classList.remove('navbar-collapsed');
        isCollapsed = false;
        updateNavbarHeights();

        const rafScroll = () => { window.requestAnimationFrame(applyHeaderState); };
        // Listen on all potential scroll containers (matches home page robustness)
        window.addEventListener('scroll', rafScroll, { passive: true });
        document.addEventListener('scroll', rafScroll, { passive: true });
        document.documentElement.addEventListener('scroll', rafScroll, { passive: true });
        const bodyEl = document.body;
        if (bodyEl) {
          bodyEl.addEventListener('scroll', rafScroll, { passive: true });
        }
        window.addEventListener('resize', () => {
          updateNavbarHeights();
          applyHeaderState();
        }, { passive: true });

        if (document.fonts && document.fonts.ready) {
          document.fonts.ready.then(() => {
            updateNavbarHeights();
            applyHeaderState();
          });
        }

        // Initial check after a short delay (to allow layout to settle)
        setTimeout(() => {
          updateNavbarHeights();
          applyHeaderState();
          // Safety: re-apply shortly after in case of late layout shifts
          setTimeout(() => {
            updateNavbarHeights();
            applyHeaderState();
          }, 200);
        }, 120);
      }
    })();

    // Mega Menu interactions (desktop hover / mobile side-drawer)
    (function() {
      const prefix = '{{ $prefix }}';
      const headerEl = document.getElementById(prefix + '-header');
      const mobileMenu = document.getElementById(prefix + '-mobileMenu');
      const btnMobile = document.getElementById(prefix + '-btn-mobile-top');
      if (!headerEl) return;

      const panels = {
        quantum: document.getElementById('nav-mega-quantum'),
        services: document.getElementById('nav-mega-services'),
        products: document.getElementById('nav-mega-products'),
        training: document.getElementById('nav-mega-training')
      };
      const triggers = document.querySelectorAll('a[data-mega-trigger]');
      let activeKey = null;
      let hideTimer = null;

      function isDesktop() { return window.innerWidth >= 1024; }
      function bodyNoScroll(enable) {
        if (enable) document.body.style.overflow = 'hidden'; else document.body.style.overflow = '';
      }
      function positionPanel(panel) {
        const rect = headerEl.getBoundingClientRect();
        const scrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
        panel.style.top = (rect.bottom + scrollY) + 'px';
      }
      function showPanel(key) {
        clearHide();
        Object.entries(panels).forEach(([k,p]) => {
          if (!p) return;
          if (k === key) {
            if (isDesktop()) {
              positionPanel(p);
              p.classList.remove('hidden','open');
            } else {
              // Position below header and open as side panel
              positionPanel(p);
              p.classList.add('open');
              p.classList.remove('hidden');
              bodyNoScroll(true);
              // Hide mobile menu so mega panel is visible
              if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                if (btnMobile) btnMobile.setAttribute('aria-expanded', 'false');
              }
            }
          } else {
            p.classList.add('hidden');
            p.classList.remove('open');
          }
        });
        activeKey = key;
      }
      function scheduleHide() {
        clearHide();
        hideTimer = setTimeout(() => {
          const p = activeKey ? panels[activeKey] : null;
          if (!p) return;
          p.classList.add('hidden');
          p.classList.remove('open');
          bodyNoScroll(false);
          activeKey = null;
        }, 160);
      }
      function clearHide() { if (hideTimer) { clearTimeout(hideTimer); hideTimer = null; } }

      // Bind triggers
      triggers.forEach(t => {
        const key = t.getAttribute('data-mega-trigger');
        // Hover (desktop) and pointer hover (mobile devices with pointers) both open
        t.addEventListener('mouseenter', () => { if (isDesktop()) showPanel(key); });
        t.addEventListener('pointerenter', () => { if (!activeKey) showPanel(key); });
        t.parentElement.addEventListener('mouseleave', () => { if (isDesktop()) scheduleHide(); });
        // Mobile tap opens (prevents navigation)
        t.addEventListener('click', (e) => {
          if (!isDesktop()) { e.preventDefault(); showPanel(key); }
        });
        // Touch start also opens immediately
        t.addEventListener('touchstart', (e) => { if (!isDesktop()) { e.preventDefault(); showPanel(key); } }, { passive: false });
      });

      // Keep open when focusing panel; hide when leaving
      Object.values(panels).forEach(p => {
        if (!p) return;
        p.addEventListener('mouseenter', () => { if (isDesktop()) clearHide(); });
        p.addEventListener('mouseleave', () => { if (isDesktop()) scheduleHide(); });
        // Mobile close via button
        const closeBtn = p.querySelector('[data-mega-close]');
        if (closeBtn) {
          closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            p.classList.add('hidden');
            p.classList.remove('open');
            bodyNoScroll(false);
            activeKey = null;
          });
        }
      });

      window.addEventListener('scroll', () => {
        if (isDesktop() && activeKey) positionPanel(panels[activeKey]);
      }, { passive: true });
      window.addEventListener('resize', () => {
        if (!isDesktop()) { // close on resize to mobile
          if (activeKey) { panels[activeKey].classList.add('open'); bodyNoScroll(true); }
        } else {
          bodyNoScroll(false);
          if (activeKey) positionPanel(panels[activeKey]);
        }
      }, { passive: true });

      // ESC to close
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && activeKey) {
          scheduleHide();
        }
      });
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

