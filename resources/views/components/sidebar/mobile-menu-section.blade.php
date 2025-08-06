@props(['key', 'icon', 'title', 'routes'])

<div class="mobile-menu-item" @click="toggleSubmenu('{{ $key }}')">
    <i class="{{ $icon }}"></i>
    <span>{{ $title }}</span>
    <i class="bi bi-chevron-down ml-auto transition-transform" :class="{ 'rotate-180': submenus.{{ $key }} }"></i>
</div>

<div x-show="submenus.{{ $key }}" x-transition class="mobile-submenu">
    @foreach($routes as $route)
        @if($route['permission'])
            @can($route['permission'])
                <a href="{{ route($route['route']) }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                    <i class="{{ $route['icon'] }}"></i>
                    <span>{{ $route['title'] }}</span>
                </a>
            @endcan
        @else
            <a href="{{ route($route['route']) }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                <i class="{{ $route['icon'] }}"></i>
                <span>{{ $route['title'] }}</span>
            </a>
        @endif
    @endforeach
</div>