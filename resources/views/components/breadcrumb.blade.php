<!-- resources/views/components/breadcrumb.blade.php -->
@props(['title', 'subtitle' => null, 'parent' => null, 'parentUrl' => null])

<div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
    <div class="px-3 py-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Título -->
            <h6 class="text-xl font-semibold text-gray-800 mb-0">{{ $title }}</h6>
            
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 flex items-center gap-2 transition-colors">
                    <i class="bi bi-house-door"></i>
                    <span>Inicio</span>
                </a>
                
                @if($parent && $parentUrl)
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ $parentUrl }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                        {{ $parent }}
                    </a>
                @endif
                
                @if($subtitle)
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-blue-600 font-medium">{{ $subtitle }}</span>
                @endif
            </nav>
        </div>
    </div>
</div>
