@props([
  'id' => 'mega-services',
])

<div id="{{ $id }}" class="nav-mega hidden" style="position: fixed; left: 0; top: 0; width: 100%; z-index: 9999;">
  <!-- Desktop container -->
  <div class="mega-panel-desktop hidden md:block w-full bg-white border-t border-gray-200 shadow-[0_12px_24px_rgba(0,0,0,0.12)] md:h-auto md:max-h-screen md:overflow-y-auto">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 py-8 md:h-auto">
      <div class="flex flex-wrap gap-6 md:gap-8">
        {{ $slot }}
      </div>
    </div>
  </div>

  <!-- Mobile container (slides full screen from left) -->
  <div class="mega-panel-mobile md:hidden w-full bg-white h-auto max-h-screen overflow-y-auto" style="position:relative;">
    <div class="px-4 py-4">
      <div class="flex justify-end">
        <button type="button" aria-label="Close menu" class="p-3 -mr-2 text-gray-700" data-mega-close>
          <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div class="mt-2">
        <div class="flex flex-wrap gap-4">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .nav-mega a { transition: color .2s ease, transform .2s ease; }
  .nav-mega a:hover { color: #0D0DE0; transform: translateX(2px); }

  /* Mobile off-canvas from right */
  @media (max-width: 1023px) {
    .nav-mega { left: 0; right: auto; width: 100%; transform: translateX(-100%); transition: transform 280ms cubic-bezier(.2,.8,.2,1); }
    .nav-mega.open { transform: translateX(0); }
    .nav-mega .mega-panel-mobile { height: auto; max-height: 100vh; overflow-y: auto; }
  }

  /* Smooth scroll for overflow panels */
  .nav-mega .md\:overflow-y-auto { -webkit-overflow-scrolling: touch; }

  /* Right-aligned arrow indicator for desktop mega menu items only */
  @media (min-width: 768px) {
    .mega-panel-desktop a {
      position: relative;
      padding-right: 2.5rem; /* reserve space for arrow icon */
    }

    .mega-panel-desktop a::after {
      content: '';
      position: absolute;
      top: 50%;
      right: 1rem; /* right side middle alignment */
      width: 24px;
      height: 24px;
      transform: translateY(-50%);
      opacity: 0.5;
      background-color: currentColor;
      /* SVG arrow icon using mask */
      -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>') center/contain no-repeat;
      mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>') center/contain no-repeat;
      pointer-events: none;
      transition: transform .2s ease, opacity .2s ease;
    }

    .mega-panel-desktop a:hover::after,
    .mega-panel-desktop a:focus-visible::after {
      transform: translateY(-50%) translateX(3px);
      opacity: 1;
    }

    /* Improve focus visibility for keyboard users */
    .mega-panel-desktop a:focus-visible {
      outline: 2px solid #0D0DE0;
      outline-offset: 2px;
      border-radius: 6px;
    }
  }
</style>


