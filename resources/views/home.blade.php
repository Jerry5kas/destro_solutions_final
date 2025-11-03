<x-layout title="Destrosolutions - Software Defined Vehicles">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-hero-main/>
    <x-statistics/>
    <x-about/>
    <x-products/>
    <x-solutions/>
    <x-services/>
    <x-team/>
    <x-contact/>
    <x-footer/>


    @push('scripts')
        <script>
            // Navbar collapse/expand functionality - REBUILT for fixed navbar
            (function () {
                'use strict';

                // Wait for DOM to be fully ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', init);
                } else {
                    init();
                }

                function init() {
                    const headerEl = document.getElementById('page-header');
                    if (!headerEl) {
                        console.error('[Navbar] Header element #page-header not found!');
                        return;
                    }

                    console.log('[Navbar] Initializing collapse/expand functionality');

                    let isCollapsed = false;
                    let lastScrollY = window.scrollY || window.pageYOffset;
                    let lockState = false;
                    let lockTimer = null;

                    // Collapse thresholds
                    const COLLAPSE_AT = 80;  // Collapse after scrolling 80px
                    const EXPAND_AT = 30;    // Expand when scrolling back to 30px
                    const LOCK_DURATION = 300; // Lock state for 300ms
                    const MIN_SCROLL_DELTA = 5; // Minimum scroll movement to trigger

                    // Find the actual scroll container - check all possible sources
                    // Note: window.scrollY is 0, but body.scrollTop has the value
                    let getScrollY = function () {
                        // Check all possible scroll sources
                        const windowScrollY = window.scrollY !== undefined ? window.scrollY : (window.pageYOffset !== undefined ? window.pageYOffset : 0);
                        const docScrollTop = document.documentElement.scrollTop || 0;
                        const bodyScrollTop = document.body.scrollTop || 0;

                        // Return the largest value (body.scrollTop is working in this case)
                        return Math.max(windowScrollY, docScrollTop, bodyScrollTop);
                    };

                    function applyHeaderState() {
                        if (!headerEl) {
                            console.warn('[Navbar] applyHeaderState: headerEl not found!');
                            return;
                        }

                        // Get current scroll position using all possible methods
                        const y = getScrollY();
                        const isMobile = window.innerWidth < 640;

                        // Debug logging (comment out for production)
                        // console.log('[Navbar] applyHeaderState - Y:', y, 'isCollapsed:', isCollapsed, 'lockState:', lockState);

                        // On mobile, always keep expanded
                        if (isMobile) {
                            if (isCollapsed) {
                                console.log('[Navbar] Mobile detected - expanding navbar');
                                headerEl.classList.remove('header-collapsed');
                                document.body.classList.remove('navbar-collapsed');
                                isCollapsed = false;
                            }
                            lastScrollY = y;
                            return;
                        }

                        // Prevent rapid toggling with lock state
                        if (lockState) {
                            return;
                        }

                        // Check if we should collapse
                        if (!isCollapsed && y > COLLAPSE_AT) {
                            console.log('[Navbar] ⬇️ COLLAPSING - Scroll Y:', y, '> Threshold:', COLLAPSE_AT);
                            collapseNavbar();
                            lastScrollY = y;
                            return;
                        }

                        // Check if we should expand
                        if (isCollapsed && y < EXPAND_AT) {
                            console.log('[Navbar] ⬆️ EXPANDING - Scroll Y:', y, '< Threshold:', EXPAND_AT);
                            expandNavbar();
                            lastScrollY = y;
                            return;
                        }

                        // Update lastScrollY for delta calculation
                        lastScrollY = y;
                    }

                    function collapseNavbar() {
                        if (lockTimer) {
                            clearTimeout(lockTimer);
                        }

                        headerEl.classList.add('header-collapsed');
                        document.body.classList.add('navbar-collapsed');
                        isCollapsed = true;

                        // console.log('[Navbar] Collapsed - logo-bar hidden, nav-wrap visible');

                        // Lock state
                        lockState = true;
                        lockTimer = setTimeout(() => {
                            lockState = false;
                            lockTimer = null;
                        }, LOCK_DURATION);
                    }

                    function expandNavbar() {
                        if (lockTimer) {
                            clearTimeout(lockTimer);
                        }

                        headerEl.classList.remove('header-collapsed');
                        document.body.classList.remove('navbar-collapsed');
                        isCollapsed = false;

                        // console.log('[Navbar] Expanded - logo-bar visible, nav-wrap visible');

                        // Lock state
                        lockState = true;
                        lockTimer = setTimeout(() => {
                            lockState = false;
                            lockTimer = null;
                        }, LOCK_DURATION);
                    }

                    // Scroll handler with requestAnimationFrame for performance
                    let rafId = null;
                    let scrollHandler = function (event) {
                        if (rafId) return; // Skip if already scheduled
                        rafId = window.requestAnimationFrame(() => {
                            applyHeaderState();
                            rafId = null;
                        });
                    };

                    // Add scroll listeners to all possible containers
                    window.addEventListener('scroll', scrollHandler, {passive: true});
                    document.addEventListener('scroll', scrollHandler, {passive: true});
                    document.documentElement.addEventListener('scroll', scrollHandler, {passive: true});

                    // Also listen on body (where scroll is actually happening)
                    const bodyEl = document.body;
                    if (bodyEl) {
                        bodyEl.addEventListener('scroll', scrollHandler, {passive: true});
                    }

                    // Initial check after a short delay
                    setTimeout(() => {
                        applyHeaderState();
                    }, 100);

                    // Polling fallback - ensures scroll is detected even if events don't fire
                    let pollCount = 0;
                    let lastPollY = getScrollY();
                    let pollInterval = setInterval(() => {
                        pollCount++;
                        const currentY = getScrollY();

                        if (currentY !== lastPollY) {
                            applyHeaderState();
                            lastPollY = currentY;
                        }

                        // Stop polling after 30 seconds to save resources
                        if (pollCount >= 150) { // 30 seconds at 200ms intervals
                            clearInterval(pollInterval);
                        }
                    }, 200);


                    // Logo width calculation
                    function setNavLogoWidthVar() {
                        headerEl.style.setProperty('--nav-logo-w', '0px');
                    }

                    // Calculate navbar heights dynamically
                    function updateNavbarHeights() {
                        const logoBar = headerEl.querySelector('.logo-bar');
                        const navWrap = headerEl.querySelector('.nav-wrap');

                        if (!logoBar) {
                            console.warn('[Navbar] logo-bar element not found!');
                        }
                        if (!navWrap) {
                            console.warn('[Navbar] nav-wrap element not found!');
                        }

                        if (logoBar && navWrap) {
                            // Force reflow to get accurate measurements
                            void logoBar.offsetHeight;
                            void navWrap.offsetHeight;

                            const logoBarHeight = logoBar.offsetHeight || 0;
                            const navWrapHeight = navWrap.offsetHeight || 0;
                            const expandedHeight = logoBarHeight + navWrapHeight;
                            const collapsedHeight = navWrapHeight || 64; // Fallback to 64px if 0

                            if (collapsedHeight === 0) {
                                console.warn('[Navbar] nav-wrap height is 0! This will break collapse. Checking styles...');
                            }

                            document.documentElement.style.setProperty('--navbar-height', expandedHeight + 'px');
                            document.documentElement.style.setProperty('--navbar-collapsed-height', collapsedHeight + 'px');

                            console.log('[Navbar] Heights - Logo-bar:', logoBarHeight + 'px', 'Nav-wrap:', navWrapHeight + 'px', 'Expanded:', expandedHeight + 'px', 'Collapsed:', collapsedHeight + 'px');
                        } else {
                            console.error('[Navbar] Cannot calculate heights - missing elements');
                        }
                    }

                    // Initialize navbar state - start expanded
                    headerEl.classList.remove('header-collapsed');
                    document.body.classList.remove('navbar-collapsed');
                    isCollapsed = false;
                    lastScrollY = window.scrollY || window.pageYOffset || 0;

                    // Set up logo width and heights
                    setNavLogoWidthVar();
                    updateNavbarHeights();

                    // Update on resize
                    window.addEventListener('resize', () => {
                        setNavLogoWidthVar();
                        updateNavbarHeights();
                    }, {passive: true});

                    // Update heights after fonts load
                    if (document.fonts && document.fonts.ready) {
                        document.fonts.ready.then(() => {
                            setNavLogoWidthVar();
                            updateNavbarHeights();
                        });
                    }

                    // Initial height update after a short delay
                    setTimeout(() => {
                        updateNavbarHeights();
                        // Check initial scroll position
                        const initialY = window.scrollY || window.pageYOffset || 0;
                        console.log('[Navbar] Initial scroll position:', initialY);
                        applyHeaderState();

                        // Force check after a moment to ensure everything is ready
                        setTimeout(() => {
                            console.log('[Navbar] Final check - Scroll Y:', window.scrollY || window.pageYOffset || 0);
                            applyHeaderState();
                        }, 200);
                    }, 100);

                    // Expose test function to window for manual testing
                    window.testNavbarCollapse = function () {
                        console.log('[Navbar] 🧪 MANUAL TEST - Forcing collapse...');
                        collapseNavbar();
                        console.log('[Navbar] ✅ Check if navbar visually collapsed. Header classes:', headerEl.className);
                    };

                    window.testNavbarExpand = function () {
                        console.log('[Navbar] 🧪 MANUAL TEST - Forcing expand...');
                        expandNavbar();
                        console.log('[Navbar] ✅ Check if navbar visually expanded. Header classes:', headerEl.className);
                    };

                    window.testNavbarScroll = function () {
                        console.log('[Navbar] 🧪 MANUAL TEST - Current scroll Y:', window.scrollY || window.pageYOffset || document.documentElement.scrollTop);
                        console.log('[Navbar] 🧪 MANUAL TEST - Forcing scroll check...');
                        applyHeaderState();
                    };

                    window.testNavbarSimulateScroll = function (y) {
                        console.log('[Navbar] 🧪 MANUAL TEST - Simulating scroll to Y:', y);
                        // Temporarily set scroll position for testing
                        window.scrollTo(0, y);
                        setTimeout(() => {
                            applyHeaderState();
                        }, 100);
                    };

                    // Initialization complete
                    // Test functions available: window.testNavbarCollapse(), window.testNavbarExpand(), window.testNavbarScroll()
                }
            })();
        </script>
    @endpush

</x-layout>
