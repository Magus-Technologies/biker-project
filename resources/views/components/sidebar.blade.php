<!-- resources\views\components\sidebar.blade.php -->
<!-- Desktop Sidebar -->
<aside class="desktop-sidebar" :class="{'sidebar-expanded': sidebarOpen, 'sidebar-collapsed': !sidebarOpen}">
    <div class="sidebar-content">
        <nav class="nav flex-column">
            <!-- MENÚ PRINCIPAL -->
            <div class="nav-section">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
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
        ['route' => 'stock-minimo.index', 'permission' => null, 'icon' => 'bi-exclamation-triangle-fill', 'title' => 'Stock Mínimo']
    ]" />

            <!-- SECCIÓN GARANTÍAS -->
            <x-sidebar.menu-section key="garantias" icon="bi-shield-check" title="Garantías" :routes="[
        ['route' => 'motos.index', 'permission' => 'ver-vehiculos', 'icon' => 'bi-motorcycle', 'title' => 'Motos'],
        ['route' => 'garantines.index', 'permission' => null, 'icon' => 'bi-shield-check', 'title' => 'Garantía']
    ]" />

            <!-- MÓDULOS DE COMPRAS (INDIVIDUALES) -->
            <x-sidebar.menu-item route="buys.index" icon="bi-bag" title="Compras" />
            
            <!-- MÓDULO DE CAJA -->
            <x-sidebar.menu-item route="cajas.index" icon="bi-cash-coin" title="Caja" permission="ver-cajas" />
            
            <x-sidebar.menu-section key="ventas" icon="bi-cart" title="Ventas" :routes="[
                ['route' => 'sales.index', 'permission' => null, 'icon' => 'bi-cart-check', 'title' => 'Ventas'],
                ['route' => 'sales.bulk-create', 'permission' => null, 'icon' => 'bi-cart-plus', 'title' => 'Ventas Mayoristas'],
                ['route' => 'pedidos.index', 'permission' => null, 'icon' => 'bi-list-check', 'title' => 'Pedidos'],
                ['route' => 'despachos.index', 'permission' => null, 'icon' => 'bi-truck', 'title' => 'Despacho'],
                ['route' => 'devoluciones.index', 'permission' => null, 'icon' => 'bi-arrow-return-left', 'title' => 'Devoluciones']
            ]" />
            <x-sidebar.menu-item route="quotations.index" icon="bi-file-earmark-text" title="Cotizaciones" />
            <x-sidebar.menu-item route="services.index" icon="bi-tools" title="Servicios" permission="ver-servicios" />
            <x-sidebar.menu-item route="mechanics.index" icon="bi-wrench" title="Mecánicos"
                permission="ver-mecanicos" />
            <x-sidebar.menu-item route="workers.index" icon="bi-people" title="Trabajadores"
                permission="ver-trabajadores" />

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