@props(['title' => 'Blog Editor - Destrosolutions'])

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
        
        /* Blog Editor Layout */
        .blog-editor-layout-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Top Header Bar (Minimal) */
        .blog-editor-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .blog-editor-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .blog-editor-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0D0DE0;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        
        .blog-editor-header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .back-link:hover {
            background: #f9fafb;
            color: #0D0DE0;
        }
        
        /* Main Content Area */
        .blog-editor-content-wrapper {
            flex: 1;
            padding: 2rem;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .blog-editor-header {
                padding: 1rem;
            }
            
            .blog-editor-logo {
                font-size: 1.25rem;
            }
            
            .blog-editor-content-wrapper {
                padding: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .blog-editor-content-wrapper {
                padding: 0.75rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="blog-editor-layout-wrapper">
        <!-- Minimal Header -->
        <header class="blog-editor-header">
            <div class="blog-editor-header-left">
                <a href="{{ route('admin.content.index', 'blog') }}" class="blog-editor-logo">
                    Destrosolutions
                </a>
            </div>
            <div class="blog-editor-header-right">
                <a href="{{ route('admin.content.index', 'blog') }}" class="back-link">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Blog List
                </a>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="blog-editor-content-wrapper">
            {{ $slot }}
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>

