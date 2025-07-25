<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        .w-280 { width: 280px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        /* Estilos para Desktop */
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            z-index: 250;
            transition: left 0.3s ease;
            background-color: #1e3a8a;
            color: white;
            border: 2px solid white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .sidebar-toggle:hover {
            background-color: #2563eb;
        }

        /* Header Mobile */
        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            z-index: 300;
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .mobile-menu-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .mobile-logo {
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Overlay Mobile Menu */

        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .mobile-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .mobile-close-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .mobile-menu-items {
            padding: 1rem 0;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            transition: background-color 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .mobile-menu-item:hover {
            background-color: #3749b3;
            color: white;
        }

        .mobile-menu-item i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
            min-width: 20px;
            text-align: center;
        }

        .mobile-menu-separator {
            border-top: 1px solid rgba(255,255,255,0.2);
            margin: 1rem 0;
        }

        /* Estilos para submenu móvil */
        .mobile-submenu {
            background-color: #2d4ba3;
            margin-left: 1rem;
            margin-right: 1rem;
            border-radius: 8px;
            overflow: hidden;
        }

        .mobile-submenu-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            transition: background-color 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-size: 14px;
        }

        .mobile-submenu-item:hover {
            background-color: #3749b3;
            color: white;
        }

        .mobile-submenu-item i {
            font-size: 1rem;
            margin-right: 0.5rem;
            min-width: 16px;
            text-align: center;
        }

        .mobile-dropdown-arrow {
            margin-left: auto;
            transition: transform 0.2s ease;
        }

        .mobile-dropdown-arrow.rotated {
            transform: rotate(180deg);
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            /* Ocultar elementos de desktop */
            .sidebar-toggle {
                display: none !important;
            }
            
            aside {
                display: none !important;
            }

            /* Mostrar header mobile */
            .mobile-header {
                display: flex !important;
            }

            .mobile-menu-overlay {
                display: block !important;
            }

            /* Ajustar contenido principal */
            main {
                margin-left: 0 !important;
                margin-top: 60px !important;
                padding-top: 1rem !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-header,
            [x-cloak] {
                display: none !important;
            }
        }

        /* Animaciones suaves */
        .fade-in {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <!-- Header Desktop -->
    <header class="hidden md:flex items-center justify-between bg-white shadow px-6 py-3 fixed top-0 left-0 right-0 z-40 h-16">
        <div class="flex items-center gap-3">
            <span class="text-xl font-bold text-blue-900">{{ config('app.name', 'Biker Project') }}</span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-gray-700 font-medium">{{ Auth::user()->getRoleNames()->first() ?? 'Usuario' }}</span>
                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700 focus:outline-none">
                        <i class="bi bi-person-circle text-xl"></i>
                        <i class="bi bi-chevron-down text-sm" :class="profileOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="profileOpen" 
                         @click.away="profileOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-person mr-2"></i>Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="bi bi-box-arrow-right mr-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>
    <!-- Fin Header Desktop -->

    <div x-data="{
            sidebarOpen: true,
            mobileMenuOpen: false,
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            },
            closeMobileMenu() {
                this.mobileMenuOpen = false;
            }
         }" class="min-h-screen flex flex-col">

        <!-- Spacer div for header desktop -->
        <div class="hidden md:block h-16"></div>

        <!-- Header Mobile -->
        <header class="mobile-header">
            <button @click="toggleMobileMenu()" class="mobile-menu-btn" type="button">
                <i class="bi bi-list"></i>
            </button>
            <div class="mobile-logo">
                <h1>Biker</h1>
            </div>
            <div class="flex items-center space-x-2">
                <!-- Puedes agregar iconos adicionales aquí -->
                <i class="bi bi-bell text-lg"></i>
            </div>
        </header>

        <!-- Mobile Menu Overlay -->
        <div @click="closeMobileMenu()"
             x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-400">
        </div>

        <!-- Mobile Menu Content -->
        <nav class="fixed top-0 left-0 w-280 h-screen bg-blue-800 text-white overflow-y-auto z-410" 
             x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div class="mobile-menu-header">
                <div class="mobile-logo">
                    {{ config('app.name', 'Laravel') }}
                </div>
                <button @click="closeMobileMenu()" class="mobile-close-btn" type="button">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            
            <div class="mobile-menu-items">
                <a href="#" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-house-door"></i>
                    <span>Inicio</span>
                </a>
                
                @can('ver-conductores')
                    <div class="mobile-menu-item" x-data="{ mobileClientsOpen: false }" @click="mobileClientsOpen = !mobileClientsOpen">
                        <i class="bi bi-people-fill"></i>
                        <span>Clientes</span>
                        <i class="bi bi-chevron-down mobile-dropdown-arrow" :class="mobileClientsOpen ? 'rotated' : ''"></i>
                        <div x-show="mobileClientsOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="mobile-submenu">
                            <a href="{{ route('drives.index') }}" class="mobile-submenu-item" @click="closeMobileMenu()">
                                <i class="bi bi-person"></i>
                                <span>Registros</span>
                            </a>
                            <a href="{{ route('clientes-mayoristas.index') }}" class="mobile-submenu-item" @click="closeMobileMenu()">
                                <i class="bi bi-building"></i>
                                <span>Mayoristas</span>
                            </a>
                        </div>
                    </div>
                @endcan
                
                @can('ver-mecanicos')
                    <a href="{{ route('mechanics.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-gear"></i>
                        <span>Mecánicos</span>
                    </a>
                @endcan
                
                @can('ver-vehiculos')
                    <a href="{{ route('cars.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-car-front-fill"></i>
                        <span>Vehículos</span>
                    </a>
                @endcan
                
                @can('ver-trabajadores')
                    <a href="{{ route('workers.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-pencil-square"></i>
                        <span>Registro de Trabajadores</span>
                    </a>
                @endcan
                
                @can('ver-servicios')
                    <a href="{{ route('services.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-tools"></i>
                        <span>Servicios Realizados</span>
                    </a>
                @endcan
                
                @can('ver-garantias')
                    <a href="{{ route('garantines.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-gear"></i>
                        <span>Garantías</span>
                    </a>
                @endcan
                
                @can('ver-productos')
                    <a href="{{ route('products.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                        <i class="bi bi-list-ul"></i>
                        <span>Productos</span>
                    </a>
                @endcan
                
                <a href="{{ route('sales.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-cart"></i>
                    <span>Ventas</span>
                </a>
                
                <a href="{{ route('quotations.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Cotizaciones</span>
                </a>
                
                <a href="{{ route('wholesalers.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-people"></i>
                    <span>Mayoristas</span>
                </a>
                
                <a href="{{ route('buys.index') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-people"></i>
                    <span>Compras</span>
                </a>

                <!-- Separador -->
                <hr class="mobile-menu-separator">

                <!-- Perfil y Cerrar sesión -->
                <a href="{{ route('profile.edit') }}" class="mobile-menu-item" @click="closeMobileMenu()">
                    <i class="bi bi-person-circle"></i>
                    <span>Perfil</span>
                </a>
                
                <div class="mobile-menu-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; padding: 0; cursor: pointer;">
                            <span>Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        @include('layouts.navigation')

        <!-- Botón para colapsar/expandir (Solo Desktop) -->
        <button @click="sidebarOpen = !sidebarOpen" class="sidebar-toggle"
                :style="sidebarOpen ? 'left: 234px;' : 'left: 54px;'">
            <i :class="sidebarOpen ? 'bi bi-chevron-left' : 'bi bi-chevron-right'"></i>
        </button>

        <!-- Page Heading -->
        @if (isset($header))
            {{ $header }}
        @endif

        <!-- Page Content -->
        <main :style="sidebarOpen ? 'margin-left: 250px;' : 'margin-left: 70px;'"
              class="transition-all duration-300 pt-4 px-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>