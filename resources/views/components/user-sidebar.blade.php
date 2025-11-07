@php
    $currentRoute = request()->route()->getName();
    $menuItems = [
        'menu' => [
            [
                'label' => 'Dashboard',
                'route' => 'user.dashboard',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
            ],
        ],
        'account' => [
            [
                'label' => 'My Profile',
                'route' => 'user.profile.edit',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'
            ],
            [
                'label' => 'My Enrollments',
                'route' => 'user.enrollments',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'
            ],
            [
                'label' => 'My Payments',
                'route' => 'user.payments',
                'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>'
            ],
        ],
    ];
@endphp

<aside class="user-sidebar" id="userSidebar">
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
            <div class="menu-section-title">My Account</div>
            @foreach($menuItems['account'] as $item)
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

