@php
    $currentRoute = request()->route()->getName();
    $menuItems = [
        'menu' => [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
            ],
        ],
        'content' => [
            [
                'label' => 'Banners',
                'route' => 'admin.banners.index',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>'
            ],
            [
                'label' => 'Quantum',
                'route' => 'admin.content.index',
                'route_params' => ['type' => 'quantum'],
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
            ],
            [
                'label' => 'Services',
                'route' => 'admin.content.index',
                'route_params' => ['type' => 'services'],
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
            ],
            [
                'label' => 'Products',
                'route' => 'admin.content.index',
                'route_params' => ['type' => 'products'],
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>'
            ],
            [
                'label' => 'Training',
                'route' => 'admin.content.index',
                'route_params' => ['type' => 'training'],
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'
            ],
            [
                'label' => 'Blog',
                'route' => 'admin.content.index',
                'route_params' => ['type' => 'blog'],
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>'
            ],
        ],
        'payment' => [
            [
                'label' => 'Payments',
                'route' => 'admin.payments.index',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>'
            ],
            [
                'label' => 'Enrollments',
                'route' => 'admin.enrollments.index',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'
            ],
            [
                'label' => 'Payment Settings',
                'route' => 'admin.payment-settings.edit',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 10c-4.418 0-8-1.79-8-4V8c0-2.21 3.582-4 8-4s8 1.79 8 4v6c0 2.21-3.582 4-8 4z"/></svg>'
            ],
        ],
        'others' => [
            [
                'label' => 'Settings',
                'route' => 'admin.settings',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
            ],
            [
                'label' => 'Accounts',
                'route' => 'admin.accounts',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'
            ],
            [
                'label' => 'Help',
                'route' => 'admin.help',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            ],
        ]
    ];
@endphp

<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-text passero-one-regular">Destrsolutions</div>
    </div>
    
    <nav class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-section-title">Main Menu</div>
            @foreach($menuItems['menu'] as $item)
                <a href="{{ route($item['route']) }}" 
                   class="menu-item {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                    <div class="menu-item-icon">
                        {!! $item['icon'] !!}
                    </div>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        
        <div class="menu-section">
            <div class="menu-section-title">Content Management</div>
            <a href="{{ route('admin.categories.index') }}" 
               class="menu-item {{ $currentRoute === 'admin.categories.index' ? 'active' : '' }}">
                <div class="menu-item-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span>Categories</span>
            </a>
            @foreach($menuItems['content'] as $item)
                @php
                    $routeParams = $item['route_params'] ?? [];
                    if (isset($routeParams['type'])) {
                        $currentType = request()->route('type');
                        $isActive = $currentType === $routeParams['type'];
                    } else {
                        $isActive = $currentRoute === $item['route'] || str_starts_with($currentRoute, str_replace('.index', '', $item['route']));
                    }
                @endphp
                <a href="{{ route($item['route'], $routeParams) }}" 
                   class="menu-item {{ $isActive ? 'active' : '' }}">
                    <div class="menu-item-icon">
                        {!! $item['icon'] !!}
                    </div>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            <a href="{{ route('admin.contacts.index') }}" 
               class="menu-item {{ $currentRoute === 'admin.contacts.index' ? 'active' : '' }}">
                <div class="menu-item-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <span>Contact Messages</span>
            </a>
            <a href="{{ route('admin.seo.index') }}" 
               class="menu-item {{ $currentRoute === 'admin.seo.index' ? 'active' : '' }}">
                <div class="menu-item-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <span>SEO Management</span>
            </a>
            <a href="{{ route('admin.translations.index') }}" 
               class="menu-item {{ str_starts_with($currentRoute, 'admin.translations') ? 'active' : '' }}">
                <div class="menu-item-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                </div>
                <span>Translations</span>
            </a>
        </div>
        
        <div class="menu-section">
            <div class="menu-section-title">Payment</div>
            @foreach($menuItems['payment'] as $item)
                @php
                    $isActive = $currentRoute === $item['route'] || 
                                str_starts_with($currentRoute, str_replace('.index', '', $item['route']));
                @endphp
                <a href="{{ route($item['route']) }}" 
                   class="menu-item {{ $isActive ? 'active' : '' }}">
                    <div class="menu-item-icon">
                        {!! $item['icon'] !!}
                    </div>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        
        <div class="menu-section">
            <div class="menu-section-title">Others</div>
            @foreach($menuItems['others'] as $item)
                <a href="{{ route($item['route']) }}" 
                   class="menu-item {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                    <div class="menu-item-icon">
                        {!! $item['icon'] !!}
                    </div>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>
</aside>

