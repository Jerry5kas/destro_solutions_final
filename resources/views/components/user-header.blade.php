@php
    $user = Auth::user();
    $firstName = explode(' ', $user->name)[0];
    $initials = strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') !== false ? substr($user->name, strpos($user->name, ' ') + 1, 1) : ''));
@endphp

<header class="user-header">
    <div class="header-left">
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h1 class="page-title" style="margin: 0; font-size: 1.5rem;">User Dashboard</h1>
    </div>
    
    <div class="header-right">
        <div class="user-selector">
            <div class="user-avatar-small">
                {{ $initials }}
            </div>
            <div>
                <div class="user-name-small">{{ $firstName }}</div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout">Sign Out</button>
        </form>
    </div>
</header>

