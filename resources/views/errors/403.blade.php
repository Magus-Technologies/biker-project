<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Prohibido</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }

        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }

        .number-403 {
            font-size: 10rem;
            font-weight: 900;
            color: #ea580c;
        }

        @media (max-width: 768px) {
            .number-403 {
                font-size: 5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center overflow-hidden">
    <div class="text-center px-4">
        <!-- Icono animado -->
        <div class="mb-6 float-animation">
            <i class="fas fa-ban pulse-animation text-gray-800 text-7xl md:text-8xl"></i>
        </div>

        <!-- Número 403 -->
        <div class="mb-4 fade-in">
            <h1 class="number-403">403</h1>
        </div>

        <!-- Mensaje principal -->
        <div class="mb-6 fade-in delay-1">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                <i class="fas fa-lock mr-2 text-orange-600"></i>
                Acceso Prohibido
            </h2>
            <p class="text-base md:text-lg text-gray-700 mb-2">
                Lo sentimos, no tienes permiso para acceder a esta página.
            </p>
            <p class="text-sm md:text-base text-gray-600">
                Esta área está restringida... 🚫
            </p>
        </div>

        <!-- Información adicional -->
        <div class="mb-6 fade-in delay-2 max-w-md mx-auto">
            <div class="bg-orange-50 rounded-lg p-4">
                <h3 class="text-gray-900 font-semibold text-sm mb-2">
                    <i class="fas fa-info-circle mr-1 text-orange-600"></i>
                    Posibles razones:
                </h3>
                <ul class="text-gray-700 text-sm text-left space-y-1">
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-orange-600"></i>
                        <span>No tienes los permisos necesarios</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-orange-600"></i>
                        <span>Tu sesión ha expirado</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-orange-600"></i>
                        <span>Esta función está restringida</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center fade-in delay-3">
            <a href="{{ url('/') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                <i class="fas fa-home mr-2"></i>
                Volver al Inicio
            </a>

            @auth
                <button onclick="window.history.back()"
                        class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center border-2 border-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Página Anterior
                </button>
            @else
                <a href="{{ route('login') }}"
                   class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center border-2 border-blue-600">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Iniciar Sesión
                </a>
            @endauth
        </div>

        <!-- Footer -->
        <div class="mt-8 fade-in delay-3">
            <p class="text-gray-600 text-xs">
                <i class="fas fa-wrench mr-1"></i>
                Sistema de Gestión Biker © {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
