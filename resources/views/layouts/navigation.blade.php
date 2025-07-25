<style>
    aside {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: #1e3a8a;
        color: white;
        transition: width 0.3s ease;
        z-index: 200;
        overflow-y: auto; /* Habilitar scroll vertical */
    }

    /* Estilos para un scroll delgado y moderno */
    aside::-webkit-scrollbar {
        width: 8px;
    }

    aside::-webkit-scrollbar-track {
        background: #1e3a8a; /* Fondo del track igual al sidebar */
    }

    aside::-webkit-scrollbar-thumb {
        background-color: #3749b3; /* Color del scroll */
        border-radius: 10px;
        border: 2px solid #1e3a8a; /* Espacio alrededor del scroll */
    }

    aside::-webkit-scrollbar-thumb:hover {
        background-color: #4f62c3; /* Color del scroll al pasar el mouse */
    }

    .menu {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 0 10px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background 0.2s ease;
        cursor: pointer;
    }

    .menu-item:hover {
        background-color: #3749b3;
    }

    .menu-item i {
        font-size: 20px;
        margin-right: 10px;
        min-width: 20px;
        text-align: center;
    }

    .menu-item span {
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .menu-item a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        width: 100%;
        padding: 10px;
    }

    .menu-item a:hover {
        color: white;
    }

    .menu-separator {
        border-top: 1px solid #fff;
        margin: 20px 0;
    }

    .logout-btn {
        background: none;
        border: none;
        color: inherit;
        padding: 0;
        cursor: pointer;
    }

    .logout-btn:hover {
        text-decoration: underline;
    }

    /* Responsive - Ocultar sidebar en móvil */
    @media (max-width: 768px) {
        aside {
            display: none;
        }
    }
</style>

   <!-- Botón de menú para móviles -->
    <div class="md:hidden flex items-center justify-between p-4 bg-white shadow">
        <button @click="sidebarOpen = !sidebarOpen" class="text-blue-600 text-2xl">
            <i class="bi bi-list"></i>
        </button>
        <span class="text-lg font-semibold">Mi App</span>
    </div>
    <!-- Botón cerrar (solo en móviles) -->
    <div class="md:hidden flex justify-end p-2">
        <button @click="sidebarOpen = false" class="text-white text-xl">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
        <aside id="sidebar" :class="sidebarOpen ? 'w-64' : 'w-0 md:w-16'"
            class="fixed top-0 left-0 h-full bg-blue-900 text-white transition-all duration-300 overflow-x-hidden z-50 md:w-16"
            @click.outside="sidebarOpen = false">
        <div class="menu-item">
            <a href="/dashboard" class="menu-item">
                <i class="bi bi-house-door"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Inicio</span>
            </a>
        </div>
        @can('ver-conductores')
            <a href="{{ route('drives.index') }}" class="menu-item">
                <i class="bi bi-people-fill"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Clientes</span>
            </a>
        @endcan
        @can('ver-mecanicos')
            <a href="{{ route('mechanics.index') }}" class="menu-item">
                <i class="bi bi-gear"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Mecánicos</span>
            </a>
        @endcan
        @can('ver-vehiculos')
            <a href="{{ route('cars.index') }}" class="menu-item">
                <i class="bi bi-car-front-fill"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Vehículos</span>
            </a>
        @endcan
        @can('ver-trabajadores')
            <a href="{{ route('workers.index') }}" class="menu-item">
                <i class="bi bi-pencil-square"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Registro de Trabajadores</span>
            </a>
        @endcan
        @can('ver-servicios')
            <a href="{{ route('services.index') }}" class="menu-item">
                <i class="bi bi-tools"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Servicios Realizados</span>
            </a>
        @endcan
        @can('ver-garantias')
            <a href="{{ route('garantines.index') }}" class="menu-item">
                <i class="bi bi-gear"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Garantías</span>
            </a>
        @endcan
        @can('ver-productos')
            <a href="{{ route('products.index') }}" class="menu-item">
                <i class="bi bi-list-ul"></i>
                <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Productos</span>
            </a>
        @endcan
        <a href="{{ route('sales.index') }}" class="menu-item">
            <i class="bi bi-cart"></i>
            <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Ventas</span>
        </a>
        <a href="{{ route('quotations.index') }}" class="menu-item">
            <i class="bi bi-file-earmark-text"></i>
            <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Cotizaciones</span>
        </a>
        <a href="{{ route('wholesalers.index') }}" class="menu-item">
            <i class="bi bi-people"></i>
            <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Mayoristas</span>
        </a>
        <a href="{{ route('buys.index') }}" class="menu-item">
            <i class="bi bi-people"></i>
            <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Compras</span>
        </a>

        <!-- Separador -->
        <hr class="menu-separator">

        <!-- Perfil y Cerrar sesión -->
        <a href="{{ route('profile.edit') }}" class="menu-item">
            <i class="bi bi-person-circle"></i>
            <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Perfil</span>
        </a>
        <div class="menu-item">
            <i class="bi bi-box-arrow-right"></i>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span :style="sidebarOpen ? 'opacity: 1;' : 'opacity: 0;'">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>
</aside>

    <!-- Botón de menú para móviles -->
    <div class="md:hidden flex items-center justify-between p-4 bg-white shadow">
        <button @click="sidebarOpen = !sidebarOpen" class="text-blue-600 text-2xl">
            <i class="bi bi-list"></i>
        </button>
        <span class="text-lg font-semibold">Mi App</span>
    </div>
    <!-- Botón cerrar (solo en móviles) -->
<div class="md:hidden flex justify-end p-2">
    <button @click="sidebarOpen = false" class="text-white text-xl">
        <i class="bi bi-x-lg"></i>
    </button>
</div>
    <aside id="sidebar" :class="sidebarOpen ? 'w-64' : 'w-0 md:w-16'"
        class="fixed top-0 left-0 h-full bg-blue-900 text-white transition-all duration-300 overflow-x-hidden z-50 md:w-16"
        @click.outside="sidebarOpen = false">
        <div class="menu">
            <!-- Inicio -->
            <div class="menu-item">
                <i class="bi bi-house-door"></i>
                <span>Inicio</span>
            </div>

            <!-- Usuario -->
            <div class="menu-item">
                <i class="bi bi-person-circle"></i>
                <a href="{{ route('profile.edit') }}"><span>Usuario</span></a>
            </div>

            <!-- Clientes con submenú -->
            <div x-data="{ clientesOpen: false }">
                <div class="menu-item" @click="clientesOpen = !clientesOpen">
                    <i class="bi bi-people-fill"></i>
                    <span>Clientes</span>
                    <i class="bi bi-chevron-down ml-auto" :class="clientesOpen ? 'rotate-180' : ''" style="transition: transform 0.2s;"></i>
                </div>
                <div x-show="clientesOpen" x-transition class="ml-6 mt-2">
                    @can('ver-conductores')
                        <div class="menu-item">
                            <i class="bi bi-person"></i>
                            <a href="{{ route('drives.index') }}"><span>Clientes</span></a>
                        </div>
                    @endcan
                    <div class="menu-item">
                        <i class="bi bi-building"></i>
                        <span>Sucursales</span> <!-- Placeholder -->
                    </div>
                    <div class="menu-item">
                        <i class="bi bi-people"></i>
                        <a href="{{ route('wholesalers.index') }}"><span>Mayoristas</span></a>
                    </div>
                </div>
            </div>

            <!-- Productos con submenú -->
            <div x-data="{ productosOpen: false }">
                <div class="menu-item" @click="productosOpen = !productosOpen">
                    <i class="bi bi-list-ul"></i>
                    <span>Productos</span>
                    <i class="bi bi-chevron-down ml-auto" :class="productosOpen ? 'rotate-180' : ''" style="transition: transform 0.2s;"></i>
                </div>
                <div x-show="productosOpen" x-transition class="ml-6 mt-2">
                    @can('ver-productos')
                        <div class="menu-item">
                            <i class="bi bi-box"></i>
                            <a href="{{ route('products.index') }}"><span>Inventario</span></a>
                        </div>
                    @endcan
                    @can('ver-garantias')
                        <div class="menu-item">
                            <i class="bi bi-shield-check"></i>
                            <a href="{{ route('garantines.index') }}"><span>Garantías</span></a>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Compras con submenú -->
            <div x-data="{ comprasOpen: false }">
                <div class="menu-item" @click="comprasOpen = !comprasOpen">
                    <i class="bi bi-cart-plus"></i>
                    <span>Compras</span>
                    <i class="bi bi-chevron-down ml-auto" :class="comprasOpen ? 'rotate-180' : ''" style="transition: transform 0.2s;"></i>
                </div>
                <div x-show="comprasOpen" x-transition class="ml-6 mt-2">
                    <div class="menu-item">
                        <i class="bi bi-cart"></i>
                        <a href="{{ route('sales.index') }}"><span>Ventas</span></a>
                    </div>
                    <div class="menu-item">
                        <i class="bi bi-file-earmark-text"></i>
                        <a href="{{ route('quotations.index') }}"><span>Cotizaciones</span></a>
                    </div>
                    @can('ver-servicios')
                        <div class="menu-item">
                            <i class="bi bi-tools"></i>
                            <a href="{{ route('services.index') }}"><span>Servicios</span></a>
                        </div>
                    @endcan
                    @can('ver-mecanicos')
                        <div class="menu-item">
                            <i class="bi bi-wrench"></i>
                            <a href="{{ route('mechanics.index') }}"><span>Mecánicos</span></a>
                        </div>
                    @endcan
                    @can('ver-vehiculos')
                        <div class="menu-item">
                            <i class="bi bi-car-front-fill"></i>
                            <a href="{{ route('cars.index') }}"><span>Vehículos</span></a>
                        </div>
                    @endcan
                    @can('ver-trabajadores')
                        <div class="menu-item">
                            <i class="bi bi-people"></i>
                            <a href="{{ route('workers.index') }}"><span>Trabajadores</span></a>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Separador -->
            <hr class="menu-separator">

            <!-- Cerrar sesión -->
            <div class="menu-item">
                <i class="bi bi-box-arrow-right"></i>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    
    </aside>
</div>

