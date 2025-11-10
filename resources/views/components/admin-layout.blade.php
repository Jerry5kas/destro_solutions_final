@props(['title' => 'Admin Dashboard - Destrosolutions'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Passero+One&display=swap" rel="stylesheet">
    
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Montserrat", sans-serif;
            background: #f5f7fa;
            color: #111827;
            overflow-x: hidden;
        }
        
        .passero-one-regular {
            font-family: "Passero One", sans-serif !important;
            font-weight: 400 !important;
        }
        
        /* Layout Container */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.04);
        }
        
        .sidebar-logo {
            padding: 1.75rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        }
        
        .sidebar-logo-text {
            font-size: 1.75rem;
            color: #0D0DE0;
            letter-spacing: -0.5px;
        }
        
        .sidebar-menu {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .menu-section {
            margin-bottom: 2rem;
        }
        
        .menu-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1.5rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            position: relative;
        }
        
        .menu-item:hover {
            background: #f9fafb;
            color: #0D0DE0;
        }
        
        .menu-item.active {
            background: linear-gradient(90deg, #eff6ff 0%, rgba(239, 246, 255, 0.5) 100%);
            color: #0D0DE0;
            border-left-color: #0D0DE0;
            font-weight: 600;
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #0D0DE0;
            border-radius: 3px 0 0 3px;
        }
        
        .menu-item-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        /* Main Content Area */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Top Header */
        .admin-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }
        
        .mobile-menu-toggle {
            display: none;
            padding: 0.5rem;
            background: transparent;
            border: none;
            cursor: pointer;
            color: #111827;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-toggle:hover {
            background: #f9fafb;
        }
        
        .header-search {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: "Montserrat", sans-serif;
            transition: all 0.2s ease;
            background: #f9fafb;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #0D0DE0;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(13, 13, 224, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 18px;
            height: 18px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f9fafb;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .user-selector:hover {
            background: #f3f4f6;
            border-color: #e5e7eb;
        }
        
        .user-avatar-small {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0D0DE0 0%, #6366f1 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(13, 13, 224, 0.2);
        }
        
        .user-name-small {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }
        
        .notification-bell {
            position: relative;
            padding: 0.625rem;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.2s ease;
            color: #6b7280;
        }
        
        .notification-bell:hover {
            background: #f9fafb;
            color: #0D0DE0;
        }
        
        .notification-dot {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        .btn-logout {
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: "Montserrat", sans-serif;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }
        
        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
        }
        
        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 2rem;
        }
        
        /* Shared Page Styles */
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 2rem;
        }
        
        .dashboard-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
        }
        
        .dashboard-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }
        
        .mobile-overlay.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-sidebar {
                width: 260px;
            }
            
            .admin-main {
                margin-left: 260px;
            }
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .admin-sidebar.active {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .header-search {
                display: none;
            }
            
            .admin-content {
                padding: 1.5rem 1rem;
            }
            
            .user-name-small {
                display: none;
            }
            
            .admin-header {
                padding: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .admin-content {
                padding: 1rem;
            }
            
            .header-right {
                gap: 0.5rem;
            }
            
            .user-selector {
                padding: 0.5rem;
            }
            
            .btn-logout {
                padding: 0.5rem 1rem;
                font-size: 0.8125rem;
            }
            
            .page-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .dashboard-card {
                padding: 1.25rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- Admin Layout -->
    <div class="admin-layout">
        <!-- Sidebar -->
        <x-admin-sidebar />
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <x-admin-header />
            
            <!-- Content Slot -->
            <div class="admin-content">
                {{ $slot }}
            </div>
        </main>
    </div>
    
    <script>
        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('adminSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        if (mobileMenuToggle && sidebar && mobileOverlay) {
            mobileMenuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });
            
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Close sidebar when clicking outside on mobile
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>

