<x-layout title="Destrosolutions - Software Defined Vehicles">
  <x-navbar variant="complex" prefix="page" hideNavLogo="true" />
  <x-hero-main />
  <x-statistics />
  <x-about />
  <x-products />
  <x-solutions />

  @push('scripts')
  <script>
    // Navbar collapse/expand functionality
    document.addEventListener('DOMContentLoaded', function() {
      const headerEl = document.getElementById('page-header');
      if (!headerEl) {
        console.warn('Header element not found');
        return;
      }

    let isCollapsed = false;
    let lastScrollY = 0;
    let lockState = false;
    let lockTimer = 0;
    
    function applyHeaderState() {
        if (!headerEl) return;

      const y = window.scrollY;
      const isMobile = window.innerWidth < 640;
      
      if (isMobile) {
        if (isCollapsed) {
          headerEl.classList.remove('header-collapsed');
          isCollapsed = false;
        }
        return;
      }
      
      // Lock state for 300ms after any change to prevent rapid toggling
      if (lockState) return;
      
      const scrollDelta = Math.abs(y - lastScrollY);
      const collapseAt = 80;  // Higher threshold for collapse
      const expandAt = 30;    // Lower threshold for expand (larger dead zone)
      
      // Only change state if scrolled enough AND past threshold
      if (scrollDelta > 5) { // Require minimum scroll movement
        if (!isCollapsed && y > collapseAt) {
          if (lockTimer) window.clearTimeout(lockTimer);
          headerEl.classList.add('header-collapsed');
          isCollapsed = true;
          lockState = true;
          lockTimer = window.setTimeout(() => { lockState = false; lockTimer = 0; }, 300);
        } else if (isCollapsed && y < expandAt) {
          if (lockTimer) window.clearTimeout(lockTimer);
          headerEl.classList.remove('header-collapsed');
          isCollapsed = false;
          lockState = true;
          lockTimer = window.setTimeout(() => { lockState = false; lockTimer = 0; }, 300);
        }
        lastScrollY = y;
      }
    }
    
    // Use requestAnimationFrame for smooth updates
    let rafId = null;
    window.addEventListener('scroll', () => {
      if (rafId) return; // Skip if already scheduled
      rafId = window.requestAnimationFrame(() => {
        applyHeaderState();
        rafId = null;
      });
    }, { passive: true });

      // Measure logo width to align navbar padding in collapsed state
      // Since nav logo is hidden, set width to 0 so nav-list padding stays at 0
      function setNavLogoWidthVar() {
        headerEl.style.setProperty('--nav-logo-w', '0px');
      }

      window.addEventListener('resize', setNavLogoWidthVar, { passive: true });

      // Run after fonts load
      if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(() => { setNavLogoWidthVar(); });
      } else {
        setTimeout(() => { setNavLogoWidthVar(); }, 0);
      }

    // Initialize header state
    lastScrollY = window.scrollY;
      window.requestAnimationFrame(() => { applyHeaderState(); });
    });
  </script>
  @endpush

</x-layout>
