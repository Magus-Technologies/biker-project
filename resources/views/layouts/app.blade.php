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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .w-280 { width: 280px; }

        /* Variables CSS para el sidebar */
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 60px;
            --primary-blue: #1e3a8a;
            --secondary-blue: #1e40af;
            --accent-blue: #3b82f6;
            --light-blue: #60a5fa;
        }

        /* Desktop Sidebar */
        .desktop-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-blue) 0%, var(--secondary-blue) 50%, var(--accent-blue) 100%);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 20px rgba(30, 58, 138, 0.3);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-content {
            padding: 24px 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .nav {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .nav-section {
            margin-bottom: 8px;
        }

        .logout-section {
            margin-top: auto;
            margin-bottom: 0;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .nav-link {
            color: rgba(255,255,255,0.95) !important;
            padding: 14px 24px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            background: none;
            font-size: 0.95rem;
            white-space: nowrap;
            position: relative;
            font-weight: 500;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0; /* Cambiado de top: 0 a bottom: 0 */
            height: 2px; /* Cambiado de height: 100% a height: 2px */
            width: 0;
            background: #fbbf24; /* Cambiado a color dorado sólido */
            transition: width 0.3s ease;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link i {
            width: 22px;
            margin-right: 14px;
            font-size: 1.15rem;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .nav-text {
            opacity: 1;
            transition: opacity 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #ffffff !important;
            transform: translateX(4px);
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            color: #ffffff !important;
            border-right: 4px solid #fbbf24;
            box-shadow: inset 0 0 20px rgba(255,255,255,0.1);
        }

        .nav-header {
            color: rgba(255,255,255,0.95);
            padding: 14px 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.95rem;
            white-space: nowrap;
            position: relative;
            border-radius: 0;
        }

        .nav-header::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0; /* Cambiado de top: 0 a bottom: 0 */
            height: 2px; /* Cambiado de height: 100% a height: 2px */
            width: 0;
            background: #fbbf24; /* Cambiado a color dorado sólido */
            transition: width 0.3s ease;
        }

        .nav-header:hover::before {
            width: 100%;
        }

        .nav-header i {
            width: 22px;
            margin-right: 14px;
            font-size: 1.15rem;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .nav-header:hover {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            transform: translateX(4px);
        }

        .nav-header:hover i {
            transform: scale(1.1);
        }

        .collapse-icon {
            margin-left: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .nav-header.expanded .collapse-icon {
            transform: rotate(180deg);
            opacity: 1;
        }

        .nav-submenu {
            background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.15) 100%);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 2px solid rgba(255,255,255,0.1);
            margin-left: 12px;
            border-radius: 0 8px 8px 0;
        }

        .submenu-link {
            padding-left: 56px !important;
            font-size: 0.9rem;
            font-weight: 400;
            position: relative;
        }

        .submenu-link::before {
            content: '';
            position: absolute;
            left: 44px;
            top: 100%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background: rgba(255,255,255,0.6);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .submenu-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background: #fbbf24;
            transition: width 0.3s ease;
        }

        .submenu-link:hover::after {
            width: 100%;
        }
        
        .logout-btn {
            background: none !important;
            border: none !important;
            color: rgba(255,255,255,0.95) !important;
            width: 100%;
            text-align: left;
        }

        .logout-btn:hover {
            background: linear-gradient(90deg, rgba(220,38,38,0.3) 0%, rgba(220,38,38,0.1) 100%) !important;
            color: #ffffff !important;
        }

        /* Botón Toggle Desktop */
        .sidebar-toggle-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.4);
        }

        .sidebar-toggle-btn:hover {
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--light-blue) 100%);
            transform: translateY(-50%) scale(1.15);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.6);
        }

        /* Header Desktop */
        .desktop-header {
            position: fixed;
            top: 0;
            right: 0;
            height: 64px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(30, 58, 138, 0.1);
        }

        /* Header Mobile */
        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            color: white;
            z-index: 300;
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.3);
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background-color: rgba(255,255,255,0.15);
            transform: scale(1.05);
        }

        .mobile-logo {
            font-size: 1.25rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Mobile Menu */
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
        }

        .mobile-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .mobile-close-btn:hover {
            background-color: rgba(255,255,255,0.15);
            transform: scale(1.05);
        }

        .mobile-menu-items {
            padding: 1.5rem 0;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: 500;
        }

        .mobile-menu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(8px);
        }

        .mobile-menu-item i {
            font-size: 1.25rem;
            margin-right: 1rem;
            min-width: 24px;
            text-align: center;
        }

        .mobile-submenu {
            background: linear-gradient(180deg, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.15) 100%);
            border-left: 3px solid #fbbf24;
            margin: 0.5rem 1rem;
            border-radius: 0 8px 8px 0;
            overflow: hidden;
        }

        .mobile-submenu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            padding-left: 2.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: rgba(255,255,255,0.95);
            font-size: 0.95rem;
            font-weight: 500;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .mobile-submenu-item:hover {
            background-color: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(8px);
            padding-left: 3rem;
        }

        .mobile-submenu-item:last-child {
            border-bottom: none;
        }

        .mobile-menu-separator {
            border-top: 1px solid rgba(255,255,255,0.2);
            margin: 1.5rem 0;
        }

        /* Scrollbar personalizado */
        .desktop-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .desktop-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .desktop-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .desktop-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .desktop-sidebar,
            .sidebar-toggle-btn,
            .desktop-header {
                display: none !important;
            }

            .mobile-header {
                display: flex !important;
            }

            .main-content {
                margin-left: 0 !important;
                margin-top: 64px !important;
                padding-top: 1rem !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-header {
                display: none !important;
            }

            .desktop-header {
                display: flex !important;
            }

            .desktop-sidebar {
                display: block !important;
            }

            .main-content {
                margin-top: 64px;
                padding-top: 1rem;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
        }

        /* Animaciones adicionales */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-submenu[x-show] {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100" 
      x-data="{
          sidebarOpen: true,
          mobileMenuOpen: false,
          submenus: {
              clientes: false,
              productos: false,
              compras: false
          },
          toggleSubmenu(key) {
              this.submenus[key] = !this.submenus[key];
              if (this.submenus[key] && !this.sidebarOpen) {
                  this.sidebarOpen = true;
              }
          },
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              if (!this.sidebarOpen) {
                  this.submenus = { clientes: false, productos: false, compras: false };
              }
          }
       }">

    <!-- Header Desktop -->
    <header class="desktop-header" :style="'left: ' + (sidebarOpen ? '280px' : '60px')">
        <div class="flex items-center gap-3">
            <span class="text-xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent">{{ config('app.name', 'Biker Project') }}</span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-gray-700 font-semibold px-3 py-1 bg-blue-50 rounded-full text-sm">
                    {{ Auth::user()->roles->first() ? Auth::user()->roles->first()->name : 'Sin rol' }}
                </span>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @keydown.escape="open = false" class="focus:outline-none transition-transform hover:scale-110">
                        <i class="bi bi-person-circle text-3xl text-blue-700"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                         class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors font-medium">Mi perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-colors font-medium">Cerrar Sesión</button>
                        </form>
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
        <div class="mobile-logo">
            <h1>{{ config('app.name', 'Biker') }}</h1>
        </div>
        <div class="flex items-center space-x-2">
            <i class="bi bi-bell text-lg"></i>
        </div>
    </header>

    <!-- Desktop Sidebar -->
    <aside class="desktop-sidebar" :style="'width: ' + (sidebarOpen ? '280px' : '60px')">
        <div class="sidebar-content">
            <nav class="nav flex-column">
                <!-- MENÚ PRINCIPAL -->
                <div class="nav-section">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="bi bi-house-door"></i>
                        <span class="nav-text" x-show="sidebarOpen">Inicio</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-circle"></i>
                        <span class="nav-text" x-show="sidebarOpen">Usuario</span>
                    </a>
                </div>

                <!-- SECCIÓN CLIENTES -->
                <div class="nav-section">
                    <div class="nav-header" @click="toggleSubmenu('clientes')" :class="{ 'expanded': submenus.clientes }">
                        <i class="bi bi-people"></i>
                        <span class="nav-text" x-show="sidebarOpen">Clientes</span>
                        <i class="bi bi-chevron-down collapse-icon" x-show="sidebarOpen"></i>
                    </div>
                    
                    <div class="nav-submenu" x-show="submenus.clientes && sidebarOpen" x-transition>
                        @can('ver-conductores')
                            <a class="nav-link submenu-link {{ request()->routeIs('drives.index') ? 'active' : '' }}" href="{{ route('drives.index') }}">
                                <i class="bi bi-person"></i>
                                <span class="nav-text">Clientes</span>
                            </a>
                        @endcan
<!--                         
                        <div class="nav-link submenu-link cursor-pointer">
                            <i class="bi bi-building"></i>
                            <span class="nav-text">Sucursales</span>
                        </div> -->
                        
                        <a class="nav-link submenu-link {{ request()->routeIs('clientes-mayoristas.index') ? 'active' : '' }}" href="{{ route('clientes-mayoristas.index') }}">
                            <i class="bi bi-people"></i>
                            <span class="nav-text">Mayoristas</span>
                        </a>
                    </div>
                </div>

                <!-- SECCIÓN PRODUCTOS -->
                <div class="nav-section">
                    <div class="nav-header" @click="toggleSubmenu('productos')" :class="{ 'expanded': submenus.productos }">
                        <i class="bi bi-box"></i>
                        <span class="nav-text" x-show="sidebarOpen">Productos</span>
                        <i class="bi bi-chevron-down collapse-icon" x-show="sidebarOpen"></i>
                    </div>
                    
                    <div class="nav-submenu" x-show="submenus.productos && sidebarOpen" x-transition>
                        @can('ver-productos')
                            <a class="nav-link submenu-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="nav-text">Inventario</span>
                            </a>
                        @endcan
                        
                        @can('ver-garantias')
                            <a class="nav-link submenu-link {{ request()->routeIs('garantines.index') ? 'active' : '' }}" href="{{ route('garantines.index') }}">
                                <i class="bi bi-shield-check"></i>
                                <span class="nav-text">Garantías</span>
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- SECCIÓN COMPRAS -->
                <div class="nav-section">
                    <div class="nav-header" @click="toggleSubmenu('compras')" :class="{ 'expanded': submenus.compras }">
                        <i class="bi bi-cart"></i>
                        <span class="nav-text" x-show="sidebarOpen">Compras</span>
                        <i class="bi bi-chevron-down collapse-icon" x-show="sidebarOpen"></i>
                    </div>
                    
                    <div class="nav-submenu" x-show="submenus.compras && sidebarOpen" x-transition>
                        <a class="nav-link submenu-link {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                            <i class="bi bi-cart"></i>
                            <span class="nav-text">Ventas</span>
                        </a>
                        
                        <a class="nav-link submenu-link {{ request()->routeIs('quotations.index') ? 'active' : '' }}" href="{{ route('quotations.index') }}">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-text">Cotizaciones</span>
                        </a>
                        
                        <a class="nav-link submenu-link {{ request()->routeIs('buys.index') ? 'active' : '' }}" href="{{ route('buys.index') }}">
                            <i class="bi bi-bag"></i>
                            <span class="nav-text">Compras</span>
                        </a>
                        
                        @can('ver-servicios')
                            <a class="nav-link submenu-link {{ request()->routeIs('services.index') ? 'active' : '' }}" href="{{ route('services.index') }}">
                                <i class="bi bi-tools"></i>
                                <span class="nav-text">Servicios</span>
                            </a>
                        @endcan
                        
                        @can('ver-mecanicos')
                            <a class="nav-link submenu-link {{ request()->routeIs('mechanics.index') ? 'active' : '' }}" href="{{ route('mechanics.index') }}">
                                <i class="bi bi-wrench"></i>
                                <span class="nav-text">Mecánicos</span>
                            </a>
                        @endcan
                        
                        @can('ver-vehiculos')
                            <a class="nav-link submenu-link {{ request()->routeIs('cars.index') ? 'active' : '' }}" href="{{ route('cars.index') }}">
                                <i class="bi bi-car-front-fill"></i>
                                <span class="nav-text">Vehículos</span>
                            </a>
                        @endcan
                        
                        @can('ver-trabajadores')
                            <a class="nav-link submenu-link {{ request()->routeIs('workers.index') ? 'active' : '' }}" href="{{ route('workers.index') }}">
                                <i class="bi bi-people"></i>
                                <span class="nav-text">Trabajadores</span>
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- SECCIÓN AUTENTICACIÓN -->
                <div class="nav-section logout-section">
                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button type="submit" class="nav-link logout-btn w-100 text-start border-0">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="nav-text" x-show="sidebarOpen">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Botón Toggle Desktop -->
    <button @click="toggleSidebar()" class="sidebar-toggle-btn" 
            :style="'left: ' + (sidebarOpen ? 'calc(280px - 18px)' : 'calc(60px - 18px)')">
        <i :class="sidebarOpen ? 'bi bi-chevron-left' : 'bi bi-chevron-right'"></i>
    </button>

    <!-- Mobile Menu Overlay -->
    <div @click="mobileMenuOpen = false"
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
            <button @click="mobileMenuOpen = false" class="mobile-close-btn" type="button">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="mobile-menu-items">
            <a href="/dashboard" class="mobile-menu-item" @click="mobileMenuOpen = false">
                <i class="bi bi-house-door"></i>
                <span>Inicio</span>
            </a>
            
            <a href="{{ route('profile.edit') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
                <i class="bi bi-person-circle"></i>
                <span>Usuario</span>
            </a>

            <!-- SECCIÓN CLIENTES -->
            <div class="mobile-menu-item" @click="toggleSubmenu('clientes')">
                <i class="bi bi-people"></i>
                <span>Clientes</span>
                <i class="bi bi-chevron-down ml-auto transition-transform" :class="{ 'rotate-180': submenus.clientes }"></i>
            </div>
            
            <div x-show="submenus.clientes" x-transition class="mobile-submenu">
                @can('ver-conductores')
                    <a href="{{ route('drives.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-person"></i>
                        <span>Clientes</span>
                    </a>
                @endcan
                
                <div class="mobile-submenu-item">
                    <i class="bi bi-building"></i>
                    <span>Sucursales</span>
                </div>
                
                <a href="{{ route('wholesalers.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                    <i class="bi bi-people"></i>
                    <span>Mayoristas</span>
                </a>
            </div>

            <!-- SECCIÓN PRODUCTOS -->
            <div class="mobile-menu-item" @click="toggleSubmenu('productos')">
                <i class="bi bi-box"></i>
                <span>Productos</span>
                <i class="bi bi-chevron-down ml-auto transition-transform" :class="{ 'rotate-180': submenus.productos }"></i>
            </div>
            
            <div x-show="submenus.productos" x-transition class="mobile-submenu">
                @can('ver-productos')
                    <a href="{{ route('products.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-box"></i>
                        <span>Inventario</span>
                    </a>
                @endcan
                
                @can('ver-garantias')
                    <a href="{{ route('garantines.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-shield-check"></i>
                        <span>Garantías</span>
                    </a>
                @endcan
            </div>

            <!-- SECCIÓN COMPRAS -->
            <div class="mobile-menu-item" @click="toggleSubmenu('compras')">
                <i class="bi bi-cart"></i>
                <span>Compras</span>
                <i class="bi bi-chevron-down ml-auto transition-transform" :class="{ 'rotate-180': submenus.compras }"></i>
            </div>
            
            <div x-show="submenus.compras" x-transition class="mobile-submenu">
                <a href="{{ route('sales.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                    <i class="bi bi-cart"></i>
                    <span>Ventas</span>
                </a>
                
                <a href="{{ route('quotations.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Cotizaciones</span>
                </a>
                
                <a href="{{ route('buys.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                    <i class="bi bi-bag"></i>
                    <span>Compras</span>
                </a>
                
                @can('ver-servicios')
                    <a href="{{ route('services.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-tools"></i>
                        <span>Servicios</span>
                    </a>
                @endcan
                
                @can('ver-mecanicos')
                    <a href="{{ route('mechanics.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-wrench"></i>
                        <span>Mecánicos</span>
                    </a>
                @endcan
                
                @can('ver-vehiculos')
                    <a href="{{ route('cars.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-car-front-fill"></i>
                        <span>Vehículos</span>
                    </a>
                @endcan
                
                @can('ver-trabajadores')
                    <a href="{{ route('workers.index') }}" class="mobile-submenu-item" @click="mobileMenuOpen = false">
                        <i class="bi bi-people"></i>
                        <span>Trabajadores</span>
                    </a>
                @endcan
            </div>

            <!-- Separador -->
            <hr class="mobile-menu-separator">

            <!-- Cerrar sesión -->
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

    <!-- Page Heading -->
    @if (isset($header))
        {{ $header }}
    @endif

    <!-- Page Content -->
    <main class="main-content transition-all duration-300"
          :style="'margin-left: ' + (sidebarOpen ? '280px' : '60px')">
        {{ $slot }}
    </main>

</body>
</html>