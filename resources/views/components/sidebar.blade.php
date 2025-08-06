<!-- resources\views\components\sidebar.blade.php -->
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

                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                    href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    <span class="nav-text" x-show="sidebarOpen">Usuario</span>
                </a>
            </div>

            <!-- SECCIÓN CLIENTES -->
            <x-sidebar.menu-section key="clientes" icon="bi-people" title="Clientes" :routes="[
        ['route' => 'drives.index', 'permission' => 'ver-conductores', 'icon' => 'bi-person', 'title' => 'Clientes'],
        ['route' => 'clientes-mayoristas.index', 'permission' => null, 'icon' => 'bi-people', 'title' => 'Mayoristas']
    ]" />

            <!-- SECCIÓN PRODUCTOS -->
            <x-sidebar.menu-section key="productos" icon="bi-box" title="Productos" :routes="[
        ['route' => 'precios-productos.index', 'permission' => null, 'icon' => 'bi-currency-dollar', 'title' => 'Precios'],
        ['route' => 'products.index', 'permission' => 'ver-productos', 'icon' => 'bi-box', 'title' => 'Inventario'],
        ['route' => 'garantines.index', 'permission' => 'ver-garantias', 'icon' => 'bi-shield-check', 'title' => 'Garantías']
    ]" />

            <!-- SECCIÓN COMPRAS -->
            <x-sidebar.menu-section key="compras" icon="bi-cart" title="Compras" :routes="[
        ['route' => 'sales.index', 'permission' => null, 'icon' => 'bi-cart', 'title' => 'Ventas'],
        ['route' => 'quotations.index', 'permission' => null, 'icon' => 'bi-file-earmark-text', 'title' => 'Cotizaciones'],
        ['route' => 'buys.index', 'permission' => null, 'icon' => 'bi-bag', 'title' => 'Compras'],
        ['route' => 'services.index', 'permission' => 'ver-servicios', 'icon' => 'bi-tools', 'title' => 'Servicios'],
        ['route' => 'mechanics.index', 'permission' => 'ver-mecanicos', 'icon' => 'bi-wrench', 'title' => 'Mecánicos'],
        ['route' => 'cars.index', 'permission' => 'ver-vehiculos', 'icon' => 'bi-car-front-fill', 'title' => 'Vehículos'],
        ['route' => 'workers.index', 'permission' => 'ver-trabajadores', 'icon' => 'bi-people', 'title' => 'Trabajadores']
    ]" />

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

<!-- Mobile Menu Components -->
<x-sidebar.mobile-menu />