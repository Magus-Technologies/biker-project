<style>
    aside {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 60px;
        background-color: #1e3a8a;
        color: white;
        transition: width 0.3s ease;
        z-index: 200;
    }

    aside.expanded {
        width: 250px;
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
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    aside.expanded .menu-item span {
        opacity: 1;
    }

    /* SWITCH STYLES */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin-right: 10px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    input:checked+.slider {
        background-color: #2563eb;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .switch-label {
        color: #fff;
        font-size: 14px;
        user-select: none;
        margin-left: 8px;
        transition: opacity 0.3s;
        opacity: 0;
    }

    aside.expanded .switch-label {
        opacity: 1;
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

    /* MOBILE */
    @media (max-width: 768px) {
        aside {
            width: 0;
            min-width: 0;
            overflow-x: hidden;
            z-index: 201;
            width: 3rem !important; /* 48px */
        }

        aside.expanded {
            width: 220px;
            min-width: 220px;
        }

        .menu-item span,
        aside.expanded .switch-label {
            opacity: 1;
        }

        /* Overlay para tapar el fondo cuando el sidebar está abierto */
        #sidebar-overlay {
            display: none;
        }

        aside.expanded+#sidebar-overlay {
            display: block;
            position: fixed;
            z-index: 200;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
        }
    }
</style>

<!-- Botón para abrir menú en móvil -->
<div class="md:hidden flex items-center p-4 bg-white shadow" style="z-index:210; position:relative;">
    <button id="open-sidebar" class="text-blue-600 text-2xl">
        <i class="bi bi-list"></i>
    </button>
    <span class="text-lg font-semibold ml-2">Mi App</span>
</div>

<aside id="sidebar"
    class="transition-all duration-300 fixed top-0 left-0 h-full w-16 bg-blue-900 text-white overflow-x-hidden">
    <div class="menu">
        <div class="menu-item" style="justify-content: flex-end;">
            <label class="switch" title="Fijar o soltar menú">
                <input type="checkbox" id="sidebar-switch">
                <span class="slider"></span>
            </label>
            <span class="switch-label" id="sidebar-switch-label">Fijar abierto</span>
        </div>
        <div class="menu-item">
            <i class="bi bi-house-door"></i>
            <span>Inicio</span>
        </div>
        @can('ver-conductores')
            <div class="menu-item">
                <i class="bi bi-people-fill"></i>
                <a href="{{ route('drives.index') }}"><span>Clientes</span></a>
            </div>
        @endcan
        @can('ver-mecanicos')
            <div class="menu-item">
                <i class="bi bi-gear"></i>
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
                <i class="bi bi-pencil-square"></i>
                <a href="{{ route('workers.index') }}"><span>Registro de Trabajadores</span></a>
            </div>
        @endcan
        @can('ver-servicios')
            <div class="menu-item">
                <i class="bi bi-tools"></i>
                <a href="{{ route('services.index') }}"><span>Servicios Realizados</span></a>
            </div>
        @endcan
        @can('ver-garantias')
            <div class="menu-item">
                <i class="bi bi-gear"></i>
                <a href="{{ route('garantines.index') }}"><span>Garantías</span></a>
            </div>
        @endcan
        @can('ver-productos')
            <div class="menu-item">
                <i class="bi bi-list-ul"></i>
                <a href="{{ route('products.index') }}"><span>Productos</span></a>
            </div>
        @endcan
        <div class="menu-item">
            <i class="bi bi-cart"></i>
            <a href="{{ route('sales.index') }}"><span>Ventas</span></a>
        </div>
        <div class="menu-item">
            <i class="bi bi-file-earmark-text"></i>
            <a href="{{ route('quotations.index') }}"><span>Cotizaciones</span></a>
        </div>
        <div class="menu-item">
            <i class="bi bi-people"></i>
            <a href="{{ route('wholesalers.index') }}"><span>Mayoristas</span></a>
        </div>
        <div class="menu-item">
            <i class="bi bi-people"></i>
            <a href="{{ route('buys.index') }}"><span>Compras</span></a>
        </div>

        <!-- Separador -->
        <hr class="menu-separator">

        <!-- Perfil y Cerrar sesión -->
        <div class="menu-item">
            <i class="bi bi-person-circle"></i>
            <a href="{{ route('profile.edit') }}"><span>Perfil</span></a>
        </div>
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
<!-- Overlay para móvil -->
<div id="sidebar-overlay"></div>

<script>
    let isPinned = localStorage.getItem('sidebarPinned') === 'true';
    const sidebar = document.getElementById('sidebar');
    const switchInput = document.getElementById('sidebar-switch');
    const switchLabel = document.getElementById('sidebar-switch-label');
    const openSidebarBtn = document.getElementById('open-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    // Función para detectar mobile
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Inicializa el estado al cargar
    function updateSidebarState() {
        if (isPinned) {
            sidebar.classList.add('expanded');
            switchInput.checked = true;
            switchLabel.textContent = 'Cerrar menú';
        } else {
            sidebar.classList.remove('expanded');
            switchInput.checked = false;
            switchLabel.textContent = 'Fijar abierto';
        }
        // Overlay solo en móvil
        if (isMobile() && sidebar.classList.contains('expanded')) {
            sidebarOverlay.style.display = 'block';
        } else {
            sidebarOverlay.style.display = 'none';
        }
    }
    updateSidebarState();

    // Hover sólo en desktop
    sidebar.addEventListener('mouseenter', () => {
        if (!isPinned && !isMobile()) {
            sidebar.classList.add('expanded');
        }
    });
    sidebar.addEventListener('mouseleave', () => {
        if (!isPinned && !isMobile()) {
            sidebar.classList.remove('expanded');
        }
    });

    // Switch para fijar/desfijar
    switchInput.addEventListener('change', () => {
        isPinned = switchInput.checked;
        localStorage.setItem('sidebarPinned', isPinned);
        updateSidebarState();
    });

    // Botón abrir sidebar en móvil
    openSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('expanded');
        sidebarOverlay.style.display = 'block';
    });

    // Overlay cierra sidebar en móvil
    sidebarOverlay.addEventListener('click', () => {
        if (!isPinned) {
            sidebar.classList.remove('expanded');
            sidebarOverlay.style.display = 'none';
        }
    });

    // Al hacer resize, ajusta
    window.addEventListener('resize', () => {
        updateSidebarState();
        // Si el menú estaba abierto por mobile pero ahora es desktop, oculta overlay
        if (!isMobile()) {
            sidebarOverlay.style.display = 'none';
        }
    });
</script>
