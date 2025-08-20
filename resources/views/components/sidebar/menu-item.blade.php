<!-- resources\views\components\sidebar\menu-item.blade.php -->
@props(['route', 'icon', 'title', 'permission' => null])

<div class="nav-section">
    @if($permission)
        @can($permission)
            <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}" 
               href="{{ route($route) }}">
                @if (str_starts_with($icon, '<'))
                    {!! $icon !!}
                @else
                    <i class="{{ $icon }}"></i>
                @endif
                <span class="nav-text" x-show="sidebarOpen">{{ $title }}</span>
            </a>
        @endcan
    @else
        <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}" 
           href="{{ route($route) }}">
            @if (str_starts_with($icon, '<'))
                {!! $icon !!}
            @else
                <i class="{{ $icon }}"></i>
            @endif
            <span class="nav-text" x-show="sidebarOpen">{{ $title }}</span>
        </a>
    @endif
</div>