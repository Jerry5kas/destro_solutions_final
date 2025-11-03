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
    
    <!-- Fonts: Passero One (Logo), Orbitron (Logo), Montserrat (Body & Headings) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Passero+One&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- GSAP Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    
    <!-- Global Styles -->
    <style>
        html, body { 
            height: 100%; 
        }
        
        /* Global font assignments - Montserrat */
        body { 
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400; /* Regular for body text */
            font-style: normal;
            /* Add padding-top to account for fixed navbar */
            /* Expanded: logo-bar (64px) + nav-wrap (~64px) = ~128px */
            /* Collapsed: nav-wrap only (~64px) */
            padding-top: var(--navbar-height, 128px); /* Default to expanded height */
            transition: padding-top 320ms cubic-bezier(.2,.8,.2,1);
        }
        
        /* Update padding when navbar collapses - only nav-wrap visible */
        body.navbar-collapsed {
            padding-top: var(--navbar-collapsed-height, 64px);
        }
        
        /* Logo font - Passero One - Ensure it overrides all other font rules */
        #logoInBar, 
        #logoInBar span,
        #logoInBar *,
        .nav-logo, 
        .passero-one-regular,
        .passero-one-regular *,
        .footer-brand h2,
        .footer-brand h2 *,
        header .logo-bar span,
        header .logo-bar * {
            font-family: "Passero One", sans-serif !important;
            font-weight: 400 !important;
            font-style: normal !important;
            font-optical-sizing: auto;
        }
        
        /* All headings - Montserrat Medium 500 */
        h1, h2, h3, h4, h5, h6 {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }
        
        /* Banner titles - Montserrat Medium 500 */
        .hero-title,
        .hero-main h1,
        .banner-title {
            font-family: "Montserrat", sans-serif !important;
            font-optical-sizing: auto;
            font-weight: 500 !important;
            font-style: normal;
        }
        
        /* Ensure all body text uses Regular 400 - but exclude logo elements */
        p:not(.passero-one-regular):not(.passero-one-regular *), 
        span:not(.passero-one-regular):not(#logoInBar):not(#logoInBar *):not(.font-bold):not(.font-semibold):not(.font-medium):not(h1):not(h2):not(h3):not(h4):not(h5):not(h6), 
        li, td, th, label {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }
        
        /* Links use Regular 400 by default */
        a:not(.font-bold):not(.font-semibold):not(.font-medium):not(h1):not(h2):not(h3):not(h4):not(h5):not(h6) {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
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
        /* CRITICAL: Header must be FIXED for truly global behavior across all pages/components */
        /* Fixed positioning ensures navbar works regardless of parent overflow or stacking contexts */
        header[class*="sticky"],
        header[class*="fixed"],
        #page-header,
        #nav-header,
        header.header-collapsed,
        #page-header.header-collapsed,
        #nav-header.header-collapsed { 
            --bar-h: 64px; 
            --nav-logo-w: 140px; 
            overflow: visible !important; 
            will-change: transform; 
            z-index: 10000 !important;
            position: fixed !important; /* Changed from sticky to fixed for global behavior */
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            background-color: white !important;
            /* Ensure header is always above all content */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        /* CRITICAL: Logo bar expands/collapses smoothly */
        .logo-bar { 
            height: var(--bar-h); 
            min-height: var(--bar-h);
            max-height: var(--bar-h);
            transition: height 320ms cubic-bezier(.2,.8,.2,1), 
                        min-height 320ms cubic-bezier(.2,.8,.2,1),
                        max-height 320ms cubic-bezier(.2,.8,.2,1),
                        padding 320ms cubic-bezier(.2,.8,.2,1), 
                        padding-top 320ms cubic-bezier(.2,.8,.2,1),
                        padding-bottom 320ms cubic-bezier(.2,.8,.2,1),
                        margin 320ms cubic-bezier(.2,.8,.2,1),
                        border-color 320ms cubic-bezier(.2,.8,.2,1), 
                        transform 320ms cubic-bezier(.2,.8,.2,1),
                        opacity 320ms cubic-bezier(.2,.8,.2,1),
                        visibility 320ms cubic-bezier(.2,.8,.2,1),
                        display 320ms cubic-bezier(.2,.8,.2,1); 
            will-change: height, opacity, transform;
            z-index: 10001 !important;
            position: relative;
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
            display: block !important;
        }
        
        /* Navigation wrapper - ensures all nav children stay on top */
        /* CRITICAL: Nav-wrap must stay visible and properly positioned when collapsed */
        .nav-wrap { 
            transition: transform 320ms cubic-bezier(.2,.8,.2,1), 
                        box-shadow 320ms cubic-bezier(.2,.8,.2,1), 
                        border-color 320ms cubic-bezier(.2,.8,.2,1); 
            will-change: transform;
            z-index: 10002 !important;
            position: relative !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            /* Ensure nav-wrap has a minimum height - reduced on mobile */
            min-height: 44px;
        }
        
        /* Reduce mobile navbar spacing */
        @media (max-width: 640px) {
            .logo-bar > div {
                padding-top: 0.75rem !important; /* py-3 */
                padding-bottom: 0.75rem !important;
            }
            
            .nav-wrap nav {
                padding-top: 0.5rem !important; /* py-2 equivalent */
                padding-bottom: 0.5rem !important;
            }
            
            .nav-list {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
        }
        
        /* When collapsed, nav-wrap must stay visible */
        .header-collapsed .nav-wrap { 
            /* Force visibility - override any conflicting styles */
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            transform: translateY(0) !important;
            /* Ensure it maintains height */
            height: auto !important;
            min-height: 50px !important;
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
        
        /* Collapsed state - Header must remain fixed */
        .header-collapsed { 
            margin-bottom: 0;
            /* CRITICAL: Ensure header stays fixed even when collapsed */
            position: fixed !important;
            top: 0 !important;
            z-index: 10000 !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* CRITICAL: Logo bar collapses completely - hides smoothly */
        .header-collapsed .logo-bar { 
            height: 0 !important; 
            min-height: 0 !important;
            max-height: 0 !important;
            padding-top: 0 !important; 
            padding-bottom: 0 !important; 
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            border-bottom-width: 0 !important; 
            border-top-width: 0 !important;
            transform: none; 
            overflow: hidden !important; 
            visibility: hidden !important;
            opacity: 0 !important;
            display: block !important; /* Keep block for smooth transition */
            pointer-events: none !important; /* Prevent interaction */
            /* Smooth transition - all properties */
            transition: height 320ms cubic-bezier(.2,.8,.2,1), 
                        min-height 320ms cubic-bezier(.2,.8,.2,1),
                        max-height 320ms cubic-bezier(.2,.8,.2,1),
                        padding 320ms cubic-bezier(.2,.8,.2,1),
                        padding-top 320ms cubic-bezier(.2,.8,.2,1),
                        padding-bottom 320ms cubic-bezier(.2,.8,.2,1),
                        margin 320ms cubic-bezier(.2,.8,.2,1),
                        opacity 320ms cubic-bezier(.2,.8,.2,1),
                        visibility 320ms cubic-bezier(.2,.8,.2,1);
        }
        
        /* CRITICAL: Ensure all children of logo-bar are also hidden when collapsed */
        .header-collapsed .logo-bar > *,
        .header-collapsed .logo-bar > div,
        .header-collapsed .logo-bar > div > * {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            min-height: 0 !important;
            max-height: 0 !important;
            padding: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            pointer-events: none !important;
        }
        
        /* Specifically hide the tagline span */
        .header-collapsed .logo-bar span {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        
        /* CRITICAL: Nav-wrap (primary nav) stays visible and fixed at top when collapsed */
        .header-collapsed .nav-wrap { 
            transform: translateY(0) !important; /* Move to top when logo-bar collapses */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15), 0 2px 8px rgba(0, 0, 0, 0.1) !important;
            overflow: visible !important;
            visibility: visible !important;
            display: block !important;
            opacity: 1 !important;
            position: relative !important;
            background-color: white !important;
            /* Smooth transition */
            transition: transform 320ms cubic-bezier(.2,.8,.2,1), 
                        box-shadow 320ms cubic-bezier(.2,.8,.2,1);
            /* Ensure it's at the very top when collapsed */
            margin-top: 0 !important;
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
        
        /* Reduce nav-list padding on mobile */
        @media (max-width: 640px) {
            .nav-list {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
            }
            
            .header-collapsed .nav-list {
                padding-top: 8px !important;
                padding-bottom: 8px !important;
            }
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
            /* CRITICAL: Don't use overflow-hidden on sections - it breaks fixed navbar */
            /* Only apply overflow to child elements that need clipping */
        }
        
        /* CRITICAL: Ensure no parent element breaks fixed positioning */
        html, body {
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }
        
        /* Ensure sections don't interfere with fixed navbar */
        main > section,
        body > section {
            position: relative;
            /* Sections are normal flow, navbar is fixed above */
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

