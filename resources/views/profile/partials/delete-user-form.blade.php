<!-- resources\views\profile\partials\delete-user-form.blade.php -->
<section class="space-y-6">
    <header class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-exclamation-triangle text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Eliminar Cuenta
                </h2>
                <p class="text-gray-600 text-sm font-medium">
                    Esta acción es permanente e irreversible
                </p>
            </div>
        </div>
    </header>

    <!-- Advertencia -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-red-900 mb-2">
                    ⚠️ Zona Peligrosa
                </h3>
                <p class="text-red-800 text-sm mb-4">
                    Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. 
                    Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                </p>
                
                <div class="bg-red-100 border border-red-300 rounded-lg p-4 mb-4">
                    <h4 class="font-semibold text-red-900 mb-2 flex items-center gap-2">
                        <i class="bi bi-info-circle"></i>
                        ¿Qué se eliminará?
                    </h4>
                    <ul class="text-sm text-red-800 space-y-1">
                        <li class="flex items-center gap-2">
                            <i class="bi bi-x-circle text-red-600"></i>
                            Toda tu información personal
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="bi bi-x-circle text-red-600"></i>
                            Historial de actividades
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="bi bi-x-circle text-red-600"></i>
                            Configuraciones personalizadas
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="bi bi-x-circle text-red-600"></i>
                            Acceso a la plataforma
                        </li>
                    </ul>
                </div>

                <button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl hover:from-red-700 hover:to-red-800 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="bi bi-trash"></i>
                    Eliminar Mi Cuenta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    ¿Estás seguro de que quieres eliminar tu cuenta?
                </h2>
                <p class="text-gray-600">
                    Esta acción no se puede deshacer. Todos tus datos serán eliminados permanentemente.
                </p>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="bi bi-key text-red-600"></i>
                    Confirma tu contraseña para continuar
                </label>
                <div class="relative group">
                    <input id="password"
                           name="password"
                           type="password"
                           class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md group-hover:border-red-300"
                           placeholder="Ingresa tu contraseña">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-key text-gray-400 group-focus-within:text-red-500 transition-colors"></i>
                    </div>
                </div>
                @error('password', 'userDeletion')
                    <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" 
                        x-on:click="$dispatch('close')"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </button>

                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl hover:from-red-700 hover:to-red-800 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="bi bi-trash"></i>
                    Sí, Eliminar Mi Cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>