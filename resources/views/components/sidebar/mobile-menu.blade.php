<!-- resources\views\components\sidebar\mobile-menu.blade.php -->
<!-- Mobile Menu Content SIN OVERLAY -->
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
                ['route' => 'garantines.index', 'permission' => 'ver-garantias', 'icon' => 'bi-shield-check', 'title' => 'Garantías']
            ]" />

        <!-- SECCIÓN COMPRAS -->
        <x-sidebar.mobile-menu-section 
            key="compras" 
            icon="bi-cart" 
            title="Compras"
            :routes="[
                ['route' => 'sales.index', 'permission' => null, 'icon' => 'bi-cart', 'title' => 'Ventas'],
                ['route' => 'quotations.index', 'permission' => null, 'icon' => 'bi-file-earmark-text', 'title' => 'Cotizaciones'],
                ['route' => 'buys.index', 'permission' => null, 'icon' => 'bi-bag', 'title' => 'Compras'],
                ['route' => 'services.index', 'permission' => 'ver-servicios', 'icon' => 'bi-tools', 'title' => 'Servicios'],
                ['route' => 'mechanics.index', 'permission' => 'ver-mecanicos', 'icon' => 'bi-wrench', 'title' => 'Mecánicos'],
                ['route' => 'cars.index', 'permission' => 'ver-vehiculos', 'icon' => 'bi-car-front-fill', 'title' => 'Vehículos'],
                ['route' => 'workers.index', 'permission' => 'ver-trabajadores', 'icon' => 'bi-people', 'title' => 'Trabajadores']
            ]" />

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