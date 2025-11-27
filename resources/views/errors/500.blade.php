<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error del Servidor</title>
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

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .shake-animation {
            animation: shake 0.5s ease-in-out infinite;
        }

        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }

        .number-500 {
            font-size: 10rem;
            font-weight: 900;
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .number-500 {
                font-size: 5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center overflow-hidden">
    <div class="text-center px-4">
        <!-- Icono animado -->
        <div class="mb-6 float-animation">
            <i class="fas fa-server shake-animation text-gray-800 text-7xl md:text-8xl"></i>
        </div>

        <!-- Número 500 -->
        <div class="mb-4 fade-in">
            <h1 class="number-500">500</h1>
        </div>

        <!-- Mensaje principal -->
        <div class="mb-6 fade-in delay-1">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                Error del Servidor
            </h2>
            <p class="text-base md:text-lg text-gray-700 mb-2">
                Lo sentimos, algo salió mal en nuestro servidor.
            </p>
            <p class="text-sm md:text-base text-gray-600">
                Estamos trabajando para solucionarlo... ⚙️
            </p>
        </div>

        <!-- Información adicional -->
        <div class="mb-6 fade-in delay-2 max-w-md mx-auto">
            <div class="bg-gray-100 rounded-lg p-4">
                <h3 class="text-gray-900 font-semibold text-sm mb-2">
                    <i class="fas fa-tools mr-1 text-blue-600"></i>
                    ¿Qué puedes hacer?
                </h3>
                <ul class="text-gray-700 text-sm text-left space-y-1">
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-blue-600"></i>
                        <span>Espera unos minutos e intenta nuevamente</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-blue-600"></i>
                        <span>Recarga la página (F5)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-xs mt-1 mr-2 text-blue-600"></i>
                        <span>Contacta al administrador si persiste</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center fade-in delay-3">
            <button onclick="location.reload()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                <i class="fas fa-sync-alt mr-2"></i>
                Recargar Página
            </button>

            <a href="{{ url('/') }}"
               class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center border-2 border-blue-600">
                <i class="fas fa-home mr-2"></i>
                Ir al Inicio
            </a>
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
