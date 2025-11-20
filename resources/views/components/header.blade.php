<!-- resources\views\components\header.blade.php -->
<!-- Header Desktop -->
<header class="desktop-header" :class="{'header-expanded': sidebarOpen, 'header-collapsed': !sidebarOpen}">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-speedometer2 text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent">
                    {{ config('app.name', 'Biker Project') }}
                </h1>
                <p class="text-xs text-gray-500 font-medium">Panel de Control</p>
            </div>
        </div>
    </div>
    
    <div class="flex items-center gap-6">
        <!-- Notificaciones -->
        <div x-data="{ hasNotifications: true }" class="relative">
            <button class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50">
                <i class="bi bi-bell text-xl"></i>
                <span x-show="hasNotifications" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
            </button>
        </div>

        @auth
            <!-- Rol del usuario -->
            <!-- <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full border border-blue-100">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold text-blue-800">
                    {{ Auth::user()->roles->first() ? Auth::user()->roles->first()->name : 'Sin rol' }}
                </span>
            </div> -->

            <!-- Menú de usuario -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @keydown.escape="open = false" 
                        class="flex items-center gap-3 p-2 rounded-xl hover:bg-blue-50 transition-all duration-200 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="bi bi-person text-white text-lg"></i>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <i class="bi bi-chevron-down text-gray-400 text-sm transition-transform group-hover:rotate-180"></i>
                </button>
                
                <div x-show="open" @click.away="open = false" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-3 w-64 bg-white border border-gray-200 rounded-2xl shadow-2xl py-2 z-50 backdrop-blur-sm">
                    
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors font-medium group">
                        <i class="bi bi-person-gear text-blue-600 group-hover:scale-110 transition-transform"></i>
                        <span>Mi perfil</span>
                    </a>
                    
                    <a href="#" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors font-medium group">
                        <i class="bi bi-gear text-blue-600 group-hover:scale-110 transition-transform"></i>
                        <span>Configuración</span>
                    </a>
                    
                    <div class="border-t border-gray-100 mt-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors font-medium group">
                                <i class="bi bi-box-arrow-right group-hover:scale-110 transition-transform"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</header>

<!-- Header Mobile -->
<header class="mobile-header">
    <button @click="mobileMenuOpen = true" class="mobile-menu-btn" type="button">
        <i class="bi bi-list"></i>
    </button>
    
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <i class="bi bi-speedometer2 text-white text-sm"></i>
        </div>
        <div class="mobile-logo">
            <h1>{{ config('app.name', 'Biker') }}</h1>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <button class="p-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
            <i class="bi bi-bell text-lg"></i>
        </button>
        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <i class="bi bi-person text-white text-sm"></i>
        </div>
    </div>
</header>