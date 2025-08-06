<!-- resources\views\profile\partials\update-profile-information-form.blade.php -->
<section>
    <header class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-person-circle text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Información Personal
                </h2>
                <p class="text-gray-600 text-sm font-medium">
                    Actualiza la información de tu cuenta y dirección de correo electrónico
                </p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Campo Nombre -->
        <div class="group">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="bi bi-person text-blue-600"></i>
                Nombre Completo
            </label>
            <div class="relative">
                <input id="name" 
                       name="name" 
                       type="text" 
                       value="{{ old('name', $user->name) }}"
                       required 
                       autofocus 
                       autocomplete="name"
                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md group-hover:border-blue-300" 
                       placeholder="Ingresa tu nombre completo">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="bi bi-person text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                </div>
            </div>
            @error('name')
                <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Campo Email -->
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="bi bi-envelope text-blue-600"></i>
                Correo Electrónico
            </label>
            <div class="relative">
                <input id="email" 
                       name="email" 
                       type="email" 
                       value="{{ old('email', $user->email) }}"
                       required 
                       autocomplete="username"
                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md group-hover:border-blue-300" 
                       placeholder="tu@email.com">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="bi bi-envelope text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                </div>
            </div>
            @error('email')
                <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i class="bi bi-exclamation-triangle text-yellow-600 text-lg mt-0.5"></i>
                        <div>
                            <p class="text-sm text-yellow-800 font-medium">
                                Tu dirección de correo electrónico no está verificada.
                            </p>
                            <button form="send-verification" 
                                    class="mt-2 text-sm text-yellow-700 hover:text-yellow-900 underline font-medium transition-colors">
                                Haz clic aquí para reenviar el correo de verificación
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-check-circle text-green-600"></i>
                                <p class="text-sm text-green-800 font-medium">
                                    Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Botones de acción -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center gap-4">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="bi bi-check-lg"></i>
                    Guardar Cambios
                </button>

                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-init="setTimeout(() => show = false, 3000)"
                         class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg border border-green-200">
                        <i class="bi bi-check-circle text-green-600"></i>
                        <span class="text-sm font-medium">¡Guardado exitosamente!</span>
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>