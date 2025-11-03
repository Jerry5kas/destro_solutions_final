@props(['title' => 'Destrsolutions - Bringing SDV to Life'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    
    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts: Orbitron (Logo), Manrope (Global) -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Manrope:wght@200;300;500&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- GSAP Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    
    <!-- Global Styles -->
    <style>
        html, body { 
            height: 100%; 
        }
        
        /* Global font assignments - Manrope */
        body { 
            font-family: 'Manrope', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            font-weight: 300; /* Light for body text */
        }
        
        /* Logo font - Orbitron */
        #logoInBar, .nav-logo {
            font-family: 'Orbitron', sans-serif;
        }
        
        /* All headings - Manrope Medium 500 */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
        }
        
        /* Banner titles - Manrope Medium 500 */
        .hero-title,
        .hero-main h1,
        .banner-title {
            font-family: 'Manrope', sans-serif !important;
            font-weight: 500 !important;
        }
        
        /* Ensure all body text uses Light 300 */
        p, span:not(.font-bold):not(.font-semibold):not(.font-medium), li, td, th, label {
            font-weight: 300;
        }
        
        /* Links use Light 300 by default */
        a:not(.font-bold):not(.font-semibold):not(.font-medium) {
            font-weight: 300;
        }
        
        /* Ensure all headings use Medium 500 */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 500 !important;
        }
        
        /* ============================================
           Z-INDEX STACKING SYSTEM - PRIORITY ORDER
           ============================================
           10000+: Navigation (highest priority)
           1000-9999: Modals, dropdowns, overlays
           100-999: Floating elements, tooltips
           10-99: Section overlays, gradients
           1-9: Section content
           0/-1: Background elements (lowest)
           ============================================ */
        
        /* NAVIGATION Z-INDEX STACK - HIGHEST PRIORITY LAYER (10000+) */
        /* All navigation elements must stay above everything */
        
        /* Header - Top level navigation container - BASE LAYER */
        header[class*="sticky"],
        header[class*="fixed"],
        #page-header,
        #nav-header { 
            --bar-h: 64px; 
            --nav-logo-w: 140px; 
            overflow: visible !important; 
            will-change: transform; 
            z-index: 10000 !important;
            position: sticky !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            background-color: white !important;
        }
        
        /* Ensure header children are visible */
        header[class*="sticky"] > *,
        header[class*="fixed"] > *,
        #page-header > *,
        #nav-header > * {
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Allow dropdown to overflow header */
        header .nav-dropdown {
            overflow: visible !important;
        }
        
        /* Logo bar should always be visible */
        .logo-bar {
            overflow: visible !important;
            visibility: visible !important;
            display: block !important;
            opacity: 1 !important;
        }
        
        /* Nav wrap should always be visible */
        .nav-wrap {
            overflow: visible !important;
            visibility: visible !important;
            display: block !important;
            opacity: 1 !important;
        }
        
        /* Ensure nav content is visible */
        nav[id*="mainNav"],
        #page-mainNav,
        #nav-mainNav {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Logo bar - part of navigation */
        .logo-bar { 
            height: var(--bar-h); 
            transition: height 320ms cubic-bezier(.2,.8,.2,1), 
                        padding 320ms cubic-bezier(.2,.8,.2,1), 
                        border-color 320ms cubic-bezier(.2,.8,.2,1), 
                        transform 320ms cubic-bezier(.2,.8,.2,1); 
            will-change: height, transform;
            z-index: 10001 !important;
            position: relative;
        }
        
        /* Navigation wrapper - ensures all nav children stay on top */
        .nav-wrap { 
            transition: transform 320ms cubic-bezier(.2,.8,.2,1), 
                        box-shadow 320ms cubic-bezier(.2,.8,.2,1), 
                        border-color 320ms cubic-bezier(.2,.8,.2,1); 
            will-change: transform;
            z-index: 10002 !important;
            position: relative;
        }
        
        /* Main navigation container */
        #page-mainNav,
        #nav-mainNav,
        nav[class*="mainNav"] {
            z-index: 10003 !important;
            position: relative;
        }
        
        /* Navigation list */
        .nav-list {
            z-index: 10004 !important;
            position: relative;
        }
        
        /* Navigation right section - contains search and language dropdown */
        .nav-right {
            z-index: 10005 !important;
            position: relative !important;
        }
        
        /* Language dropdown container - HIGH PRIORITY */
        #page-lang-btn,
        #nav-lang-btn,
        button[id*="lang-btn"] {
            z-index: 10006 !important;
            position: relative;
        }
        
        /* Language dropdown menu - HIGHEST PRIORITY (above navbar) */
        #page-lang-dropdown,
        #nav-lang-dropdown,
        div[id*="lang-dropdown"],
        .nav-dropdown {
            z-index: 10100 !important;
            position: absolute !important;
        }
        
        /* Mobile menu - also part of navigation */
        #page-mobileMenu,
        #nav-mobileMenu,
        div[id*="mobileMenu"] {
            z-index: 10007 !important;
            position: relative;
        }
        
        /* All navigation links and buttons */
        .nav-link,
        .nav-item,
        .nav-icon-btn {
            z-index: 10008 !important;
            position: relative;
        }
        
        /* Collapsed state */
        .header-collapsed { 
            margin-bottom: 0; 
        }
        
        .header-collapsed .logo-bar { 
            height: 0; 
            padding-top: 0; 
            padding-bottom: 0; 
            border-bottom-width: 0; 
            transform: none; 
            overflow: hidden; /* Only hide overflow when collapsed */
            visibility: hidden; /* Hide but maintain layout */
        }
        
        .header-collapsed .nav-wrap { 
            transform: none; 
            box-shadow: 0 1px 0 0 rgba(0,0,0,0.08);
            overflow: visible !important; /* Keep nav wrap visible */
            visibility: visible !important;
        }
        
        /* Ensure navbar is always visible when NOT collapsed */
        header:not(.header-collapsed),
        header[class*="sticky"]:not(.header-collapsed),
        header[class*="fixed"]:not(.header-collapsed) {
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Navbar logo: do not reserve space in expanded mode */
        .nav-logo { 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%) translateX(-8px); 
            opacity: 0; 
            pointer-events: none; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            width: var(--nav-logo-w); 
        }
        
        .header-collapsed .nav-logo { 
            opacity: 1; 
            transform: translateY(-50%) translateX(0); 
            pointer-events: auto; 
        }
        
        /* Letter D Logo - Only visible in collapsed mode, positioned absolutely OUTSIDE flex flow */
        .nav-d-logo {
            position: absolute;
            left: -20px; /* px-4 = 16px, aligns with container padding */
            top: 50%;
            transform: translateY(-50%) translateX(-8px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 320ms cubic-bezier(.2,.8,.2,1),
                        transform 320ms cubic-bezier(.2,.8,.2,1);
            display: flex;
            align-items: center;
            width: auto;
            z-index: 10;
            /* Remove from flex flow - doesn't affect nav-list positioning */
        }
        
        .header-collapsed .nav-d-logo {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
            pointer-events: auto;
        }
        
        .nav-list { 
            padding-left: 0; 
            padding-top: 18px; 
            padding-bottom: 18px; 
        }
        
        .header-collapsed .nav-list { 
            padding-left: 0; /* No padding since D logo is part of flex layout */
            padding-top: 14px; 
            padding-bottom: 14px; 
        }
        
        /* Enhanced Nav Link Styles with Underline Animation */
        .nav-link {
            position: relative;
            display: inline-block;
            transition: color 0.3s ease;
            padding-bottom: 4px;
        }
        
        .nav-link-underline {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #0D0DE0;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: left;
        }
        
        .nav-link:hover .nav-link-underline,
        .nav-link:focus .nav-link-underline {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #0D0DE0;
        }
        
        /* Active state for nav links */
        .nav-link[href*="#"]:not([href="#"]) {
            /* Add active state styles here if needed */
        }
        
        /* Icon button hover effects */
        .nav-icon-btn {
            transition: transform 0.2s ease, color 0.2s ease;
        }
        
        .nav-icon-btn:hover {
            transform: scale(1.1);
            color: #0D0DE0;
        }
        
        /* Dropdown menu item animations */
        .nav-dropdown a {
            transition: background-color 0.2s ease, color 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-dropdown a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background-color: #0D0DE0;
            transition: width 0.3s ease;
            z-index: -1;
        }
        
        .nav-dropdown a:hover::before {
            width: 100%;
        }
        
        .nav-dropdown a:hover {
            color: white;
            transform: translateX(4px);
            transition: transform 0.2s ease;
        }
        
        /* Hero height variable so header+banner+controls fit in viewport */
        #hero-slider { 
            --hero-h: 520px; 
        }
        
        .slides { 
            will-change: transform; 
            position: relative; 
            height: var(--hero-h); 
            display: flex; 
        }
        
        .slide { 
            will-change: transform, opacity; 
            height: var(--hero-h); 
            flex: 0 0 100%; 
        }
        
        /* Slide fade effect */
        .slide .bg-img { 
            opacity: .85; 
        }
        
        .slide.is-active .bg-img { 
            opacity: 1; 
        }
        
        /* Indicator animations */
        .indicator { 
            transition: transform 200ms ease; 
        }
        
        .indicator.active { 
            transform: scale(1.15); 
        }
        
        .indicator.active .progress { 
            box-shadow: 0 0 8px rgba(13, 13, 224, 0.4);
        }
        
        .indicator-bar {
            will-change: width;
        }
        
        .indicator .progress { 
            display: block;
            width: 0%;
            will-change: width;
        }
        
        @media (min-width: 768px) {
            /* Give extra room for tagline on desktop */
            #page-header { 
                --bar-h: 88px; 
            }
        }
        
        /* CONTENT SECTIONS - BELOW NAVIGATION (z-index: 1-100) */
        /* All sections must stay below navigation layer */
        /* CRITICAL: Override ALL Tailwind z-index utilities for sections */
        
        main {
            z-index: 1 !important;
            position: relative;
        }
        
        /* All section elements - base layer - OVERRIDE TAILWIND */
        section,
        .hero-main,
        .statistics-section,
        .about-section,
        .products-section,
        .solutions-section {
            z-index: 1 !important;
            position: relative;
            /* Override any Tailwind z-index classes */
        }
        
        /* Override Tailwind z-index utilities in sections */
        section[class*="z-"],
        .hero-main[class*="z-"],
        .hero-main *[class*="z-"]:not(.nav-dropdown):not([id*="lang"]) {
            /* Reset Tailwind z-index values - sections can't go above 100 */
            z-index: inherit !important;
        }
        
        /* Section content containers */
        section > div,
        section .mx-auto {
            z-index: 2 !important;
            position: relative;
        }
        
        /* Hero slider should be below navigation */
        #hero-slider,
        .hero-main > div {
            z-index: 3 !important;
            position: relative;
        }
        
        /* Hero background elements - lowest priority */
        /* Override Tailwind z-0, z-10, etc. */
        .hero-main .absolute.z-0,
        .hero-main .z-0,
        .hero-bg-image,
        .hero-video {
            z-index: 0 !important;
            position: absolute;
        }
        
        /* Hero overlay - override Tailwind z-10 */
        .hero-main .bg-black\/10,
        .hero-main .z-10 {
            z-index: 4 !important;
            position: absolute;
        }
        
        /* Hero content - override Tailwind z-20 */
        .hero-main .relative.z-20,
        .hero-main .z-20 {
            z-index: 5 !important;
            position: relative;
        }
        
        /* Section overlays and gradients - medium priority */
        .about-overlay,
        .about-slider-container,
        .product-card,
        .featured-solution-item {
            z-index: 2 !important;
            position: relative;
        }
        
        /* Section absolute positioned elements - override Tailwind z-10 */
        .about-indicators.z-10,
        .about-indicators,
        .about-slide {
            z-index: 10 !important;
            position: absolute;
        }
        
        /* CRITICAL: Ensure NO section element can exceed z-index 9999 */
        /* Note: CSS cannot clamp inline styles, but our rules ensure sections stay low */
        
        /* Prevent sections from creating stacking contexts that interfere */
        section:not(header),
        .statistics-section,
        .about-section,
        .products-section,
        .solutions-section,
        .hero-main {
            isolation: auto !important;
        }
        
        /* Ensure navbar wrapper doesn't get cut off */
        body > header,
        body > header > * {
            position: relative;
        }
        
        /* FINAL SAFETY: Any element with inline z-index > 9999 in sections gets clamped */
        section [style*="z-index"]:not([id*="lang"]):not([class*="nav"]) {
            /* This will be handled by JavaScript if needed, but CSS can't clamp inline styles */
        }
        
        /* Additional custom styles can be added here */
        @stack('styles')
    </style>
    
    <!-- Additional head content -->
    @stack('head')
</head>
<body class="bg-white text-gray-900">
    <!-- Main Content Slot -->
    {{ $slot }}
    
    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>

