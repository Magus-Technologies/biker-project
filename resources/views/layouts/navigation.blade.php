<!-- resources\views\layouts\navigation.blade.php -->
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

<aside id="sidebar" :style="sidebarOpen ? 'width: 250px;' : 'width: 70px;'">
    <div class="menu">
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