<!-- resources\views\components\sidebar\menu-section.blade.php -->
@props(['key', 'icon', 'title', 'routes'])

<div class="nav-section">
    <div class="nav-header" @click="toggleSubmenu('{{ $key }}')" :class="{ 'expanded': submenus.{{ $key }} }">
        <i class="{{ $icon }}"></i>
        <span class="nav-text" x-show="sidebarOpen">{{ $title }}</span>
        <i class="bi bi-chevron-down collapse-icon" x-show="sidebarOpen"></i>
    </div>
    
    <div class="nav-submenu" x-show="submenus.{{ $key }} && sidebarOpen" x-transition>
        @foreach($routes as $route)
            @if($route['permission'])
                @can($route['permission'])
                    <a class="nav-link submenu-link {{ request()->routeIs($route['route']) ? 'active' : '' }}" 
                       href="{{ route($route['route']) }}">
                        @if (str_starts_with($route['icon'], '<'))
                            {!! $route['icon'] !!}
                        @else
                            <i class="{{ $route['icon'] }}"></i>
                        @endif
                        <span class="nav-text">{{ $route['title'] }}</span>
                    </a>
                @endcan
            @else
                <a class="nav-link submenu-link {{ request()->routeIs($route['route']) ? 'active' : '' }}" 
                   href="{{ route($route['route']) }}">
                    @if (str_starts_with($route['icon'], '<'))
                        {!! $route['icon'] !!}
                    @else
                        <i class="{{ $route['icon'] }}"></i>
                    @endif
                    <span class="nav-text">{{ $route['title'] }}</span>
                </a>
            @endif
        @endforeach
    </div>
</div>