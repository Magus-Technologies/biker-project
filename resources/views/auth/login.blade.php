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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
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
                            placeholder="Username or email"
                            class="w-full px-4 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-600 bg-transparent" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="mb-4">
                        <input id="password" type="password" name="password" required placeholder="Password"
                            class="w-full px-4 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-600 bg-transparent" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <div class="mb-4">
                        <button type="submit"
                            class="w-full py-2 text-white font-semibold rounded bg-gradient-to-r from-blue-600 to-pink-500 hover:from-blue-700 hover:to-pink-600 transition">
                            LOGIN
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
    </script>
</body>
</html>