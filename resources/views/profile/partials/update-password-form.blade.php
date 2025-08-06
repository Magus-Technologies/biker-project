<!-- resources\views\profile\partials\update-password-form.blade.php -->
<section>
    <header class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                <i class="bi bi-shield-lock text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Actualizar Contraseña') }}
                </h2>
            </div>
        </div>
        <p class="text-sm text-gray-600">
            {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" x-data="{ showPasswords: false }">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <i class="bi bi-key text-green-600"></i>
                {{ __('Contraseña Actual') }}
            </label>
            <div class="relative">
                <input id="update_password_current_password" 
                       name="current_password" 
                       :type="showPasswords ? 'text' : 'password'"
                       autocomplete="current-password"
                       class="block w-full px-3 py-2 pl-10 pr-10 text-gray-900 placeholder-gray-500 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm" 
                       placeholder="Ingresa tu contraseña actual">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-key text-gray-400"></i>
                </div>
                <button type="button" 
                        @click="showPasswords = !showPasswords"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-500">
                    <i :class="showPasswords ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->get('current_password'))
                <div class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <i class="bi bi-shield-plus text-green-600"></i>
                {{ __('Nueva Contraseña') }}
            </label>
            <div class="relative">
                <input id="update_password_password" 
                       name="password" 
                       :type="showPasswords ? 'text' : 'password'"
                       autocomplete="new-password"
                       class="block w-full px-3 py-2 pl-10 pr-10 text-gray-900 placeholder-gray-500 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm" 
                       placeholder="Ingresa tu nueva contraseña">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-shield-plus text-gray-400"></i>
                </div>
                <button type="button" 
                        @click="showPasswords = !showPasswords"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-500">
                    <i :class="showPasswords ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->get('password'))
                <div class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <i class="bi bi-shield-check text-green-600"></i>
                {{ __('Confirmar Nueva Contraseña') }}
            </label>
            <div class="relative">
                <input id="update_password_password_confirmation" 
                       name="password_confirmation" 
                       :type="showPasswords ? 'text' : 'password'"
                       autocomplete="new-password"
                       class="block w-full px-3 py-2 pl-10 pr-10 text-gray-900 placeholder-gray-500 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm" 
                       placeholder="Confirma tu nueva contraseña">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-shield-check text-gray-400"></i>
                </div>
                <button type="button" 
                        @click="showPasswords = !showPasswords"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-500">
                    <i :class="showPasswords ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->get('password_confirmation'))
                <div class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="bi bi-check-lg mr-2"></i>
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" 
                   x-show="show" 
                   x-transition 
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">
                   ¡Contraseña actualizada!
                </p>
            @endif
        </div>
    </form>
</section>