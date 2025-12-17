<!-- resources\views\components\sidebar\mobile-menu.blade.php -->
<!-- Overlay/Backdrop oscuro -->
<div x-show="mobileMenuOpen"
     @click="mobileMenuOpen = false"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black bg-opacity-50 z-[1050]">
</div>

<!-- Mobile Menu Content -->
<nav class="fixed top-0 left-0 w-280 h-screen bg-blue-800 text-white overflow-y-auto z-[1100]" 
     x-show="mobileMenuOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full">
    
    <div class="mobile-menu-header">
        <div class="mobile-logo flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 mr-3">
            <span class="text-lg font-bold">{{ config('app.name', 'Laravel') }}</span>
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
        <x-sidebar.mobile-menu-section 
            key="clientes" 
            icon="bi-people" 
            title="Clientes"
            :routes="[
                ['route' => 'drives.index', 'permission' => 'ver-conductores', 'icon' => 'bi-person', 'title' => 'Clientes'],
                ['route' => 'clientes-mayoristas.index', 'permission' => null, 'icon' => 'bi-people', 'title' => 'Mayoristas']
            ]" />

        <!-- SECCIÓN PRODUCTOS -->
        <x-sidebar.mobile-menu-section 
            key="productos" 
            icon="bi-box" 
            title="Productos"
            :routes="[
                ['route' => 'precios-productos.index', 'permission' => null, 'icon' => 'bi-currency-dollar', 'title' => 'Precios'],
                ['route' => 'products.index', 'permission' => 'ver-productos', 'icon' => 'bi-box', 'title' => 'Inventario'],
                ['route' => 'stock-minimo.index', 'permission' => null, 'icon' => 'bi-exclamation-triangle-fill', 'title' => 'Stock Mínimo']
            ]" />

        <!-- SECCIÓN GARANTÍAS -->
        <x-sidebar.mobile-menu-section 
            key="garantias" 
            icon="bi-shield-check" 
            title="Garantías"
            :routes="[
                ['route' => 'cars.index', 'permission' => 'ver-vehiculos', 'icon' => 'bi-motorcycle', 'title' => 'Motos'],
                ['route' => 'garantines.index', 'permission' => null, 'icon' => 'bi-shield-check', 'title' => 'Garantía']
            ]" />

        <!-- Compras (individual) -->
        <a href="{{ route('buys.index') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
            <i class="bi bi-bag"></i>
            <span>Compras</span>
        </a>

        <!-- SECCIÓN VENTAS -->
        <x-sidebar.mobile-menu-section 
            key="ventas" 
            icon="bi-cart" 
            title="Ventas"
            :routes="[
                ['route' => 'sales.index', 'permission' => null, 'icon' => 'bi-cart-check', 'title' => 'Ventas'],
                ['route' => 'sales.bulk-create', 'permission' => null, 'icon' => 'bi-cart-plus', 'title' => 'Ventas Mayoristas'],
                ['route' => 'pedidos.index', 'permission' => null, 'icon' => 'bi-list-check', 'title' => 'Pedidos'],
                ['route' => 'despachos.index', 'permission' => null, 'icon' => 'bi-truck', 'title' => 'Despacho'],
                ['route' => 'devoluciones.index', 'permission' => null, 'icon' => 'bi-arrow-return-left', 'title' => 'Devoluciones']
            ]" />

        <!-- Cotizaciones (individual) -->
        <a href="{{ route('quotations.index') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
            <i class="bi bi-file-earmark-text"></i>
            <span>Cotizaciones</span>
        </a>

        <!-- Servicios (individual) -->
        @can('ver-servicios')
            <a href="{{ route('services.index') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
                <i class="bi bi-tools"></i>
                <span>Servicios</span>
            </a>
        @endcan

        <!-- Mecánicos (individual) -->
        @can('ver-mecanicos')
            <a href="{{ route('mechanics.index') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
                <i class="bi bi-wrench"></i>
                <span>Mecánicos</span>
            </a>
        @endcan

        <!-- Trabajadores (individual) -->
        @can('ver-trabajadores')
            <a href="{{ route('workers.index') }}" class="mobile-menu-item" @click="mobileMenuOpen = false">
                <i class="bi bi-people"></i>
                <span>Trabajadores</span>
            </a>
        @endcan

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