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
        ['route' => 'precios-productos.index', 'permission' => null, 'icon' => '<span style=\'display: inline-block; width: 1.25rem; text-align: center; font-weight: bold; margin-right: 0.5rem;\'>S/</span>', 'title' => 'Precios'],
        ['route' => 'products.index', 'permission' => 'ver-productos', 'icon' => 'bi-box', 'title' => 'Inventario'],
        ['route' => 'garantines.index', 'permission' => 'ver-garantias', 'icon' => 'bi-shield-check', 'title' => 'Garantías']
    ]" />

            <!-- MÓDULOS DE COMPRAS (INDIVIDUALES) -->
            <x-sidebar.menu-item route="buys.index" icon="bi-bag" title="Compras" />
            <x-sidebar.menu-item route="sales.index" icon="bi-cart" title="Ventas" />
            <x-sidebar.menu-item route="quotations.index" icon="bi-file-earmark-text" title="Cotizaciones" />
            <x-sidebar.menu-item route="services.index" icon="bi-tools" title="Servicios" permission="ver-servicios" />
            <x-sidebar.menu-item route="mechanics.index" icon="bi-wrench" title="Mecánicos" permission="ver-mecanicos" />
            <x-sidebar.menu-item route="cars.index" icon="bi-car-front-fill" title="Vehículos" permission="ver-vehiculos" />
            <x-sidebar.menu-item route="workers.index" icon="bi-people" title="Trabajadores" permission="ver-trabajadores" />

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