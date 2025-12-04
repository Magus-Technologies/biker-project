<!-- resources\views\auth\login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="w-full md:w-1/2 p-8">
                <div class="text-center mb-6">
                    <div class="text-4xl text-blue-700 mb-2" style="display: flex; justify-content: center;">
                        <img src="{{ asset('img/logo.png') }}" style="width: 200px">
                    </div>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="mb-4">
                        <select id="tienda_id" name="tienda_id" required
                            class="w-full px-4 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-600 bg-transparent">
                            <option value="">Seleccionar Tienda/Sucursal</option>
                            @foreach($tiendas as $tienda)
                                <option value="{{ $tienda->id }}" {{ old('tienda_id') == $tienda->id ? 'selected' : '' }}>
                                    {{ $tienda->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('tienda_id')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="mb-4">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="Usuario o correo electrónico"
                            class="w-full px-4 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-600 bg-transparent" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="mb-4 relative">
                        <input id="password" type="password" name="password" required placeholder="Contraseña"
                            class="w-full px-4 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-600 bg-transparent pr-10" />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                            </svg>
                            <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Recuérdame</label>
                    </div>

                    <div class="mb-4">
                        <button type="submit"
                            class="w-full py-2 text-white font-semibold rounded bg-gradient-to-r from-blue-600 to-pink-500 hover:from-blue-700 hover:to-pink-600 transition">
                            INICIAR SESIÓN
                        </button>
                    </div>

                    <div class="flex justify-between text-sm text-gray-600">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="hover:underline">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="hidden md:block md:w-1/2 relative">
                <img src="{{ asset('img/moto-login.png') }}" alt="Login Image"
                    class="absolute inset-0 h-full w-full object-cover" />
                <div class="absolute inset-0 bg-blue-800 opacity-60"></div>
            </div>
        </div>
    </div>

    <script>
        // Actualizar token CSRF automáticamente
        setInterval(function() {
            fetch('/csrf-token')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    document.querySelector('input[name="_token"]').value = data.token;
                })
                .catch(error => console.log('Error updating CSRF token:', error));
        }, 300000); // Cada 5 minutos

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePassword.addEventListener('click', function () {
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    </script>
</body>
</html>