<!-- resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Estilos del Layout -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen" 
      x-data="{
          sidebarOpen: window.innerWidth >= 1025,
          mobileMenuOpen: false,
          submenus: {
              clientes: false,
              productos: false
          },
          toggleSubmenu(key) {
              this.submenus[key] = !this.submenus[key];
              if (this.submenus[key] && !this.sidebarOpen && window.innerWidth >= 1025) {
                  this.sidebarOpen = true;
              }
          },
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              if (!this.sidebarOpen) {
                  this.submenus = { clientes: false, productos: false };
              }
          },
          init() {
              // Detectar cambios de tamaño de ventana
              window.addEventListener('resize', () => {
                  if (window.innerWidth < 1025) {
                      this.sidebarOpen = false;
                      this.mobileMenuOpen = false;
                  } else {
                      this.sidebarOpen = true;
                      this.mobileMenuOpen = false;
                  }
              });
              
              // Cerrar menú móvil al hacer clic en enlaces
              document.addEventListener('click', (e) => {
                  if (e.target.closest('a') && this.mobileMenuOpen) {
                      this.mobileMenuOpen = false;
                  }
              });
          }
       }"
       x-init="init()">

    <!-- Header Component -->
    <x-header />

    <!-- Sidebar Component -->
    <x-sidebar />

    <!-- Botón Toggle Desktop -->
    <button @click="toggleSidebar()" 
            class="sidebar-toggle-btn hidden lg:flex" 
            :style="'left: ' + (sidebarOpen ? 'calc(280px - 22px)' : 'calc(60px - 22px)')"
            :title="sidebarOpen ? 'Contraer sidebar' : 'Expandir sidebar'">
        <i :class="sidebarOpen ? 'bi bi-chevron-left' : 'bi bi-chevron-right'"></i>
    </button>

    <!-- Page Content - OPTIMIZADO PARA RESPONSIVE -->
    <main class="main-content transition-all duration-300 min-h-screen"
          :style="window.innerWidth >= 1025 ? 'margin-left: ' + (sidebarOpen ? '280px' : '60px') : (mobileMenuOpen ? 'margin-left: 280px' : 'margin-left: 0')">
        {{ $slot }}
    </main>

    <!-- Loading Overlay -->
    <div x-data="{ loading: false }" 
         x-show="loading" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-9999">
        <div class="bg-white rounded-2xl p-8 flex flex-col items-center gap-4 shadow-2xl">
            <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
            <p class="text-gray-600 font-medium">Cargando...</p>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-data="{ 
        notifications: [],
        addNotification(message, type = 'info') {
            const id = Date.now();
            this.notifications.push({ id, message, type });
            setTimeout(() => {
                this.removeNotification(id);
            }, 5000);
        },
        removeNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }" 
    class="fixed top-20 right-4 z-50 space-y-2">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="bg-white border-l-4 rounded-lg shadow-lg p-4 max-w-sm"
                 :class="{
                     'border-blue-500': notification.type === 'info',
                     'border-green-500': notification.type === 'success',
                     'border-yellow-500': notification.type === 'warning',
                     'border-red-500': notification.type === 'error'
                 }">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-800" x-text="notification.message"></p>
                    <button @click="removeNotification(notification.id)" 
                            class="ml-4 text-gray-400 hover:text-gray-600">
                        <i class="bi bi-x text-lg"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>

    @stack('modals')

</body>
</html>