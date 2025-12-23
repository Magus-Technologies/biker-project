<x-app-layout>
    <x-breadcrumb 
        title="Abrir Caja" 
        parent="Cajas" 
        parentUrl="{{ route('cajas.index') }}" 
        subtitle="Crear" 
    />

    <div class="px-3 py-4">
        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 border border-gray-200 max-w-3xl mx-auto">
            <form action="{{ route('cajas.store') }}" method="POST">
                @csrf

                <!-- Información del usuario -->
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 px-4 py-2 rounded mb-4 text-sm">
                    <p>
                        <i class="bi bi-person-circle mr-1"></i>
                        <strong>Usuario:</strong> {{ auth()->user()->name }}
                    </p>
                    <p class="mt-1">
                        <i class="bi bi-calendar mr-1"></i>
                        <strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Tienda -->
                @if($tiendas->count() > 0)
                    <div class="mb-4">
                        <label for="tienda_id" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-shop mr-1 text-gray-500"></i>Tienda <span class="text-gray-400">(Opcional)</span>
                        </label>
                        <select id="tienda_id" name="tienda_id" 
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sin tienda específica</option>
                            @foreach($tiendas as $tienda)
                                <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Monto Inicial -->
                <div class="mb-4">
                    <label for="monto_inicial" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="bi bi-cash-stack mr-1 text-gray-500"></i>Monto Inicial (Fondo de Cambio) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500 font-semibold text-sm">S/</span>
                        <input type="number" 
                               id="monto_inicial" 
                               name="monto_inicial" 
                               step="0.01" 
                               min="0"
                               value="{{ old('monto_inicial', '100.00') }}"
                               required
                               class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('monto_inicial') border-red-500 @enderror">
                    </div>
                    @error('monto_inicial')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">
                        <i class="bi bi-info-circle mr-1"></i>
                        Este es el dinero con el que inicias tu caja para dar vuelto
                    </p>
                </div>

                <!-- Observaciones -->
                <div class="mb-4">
                    <label for="observaciones_apertura" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="bi bi-chat-left-text mr-1 text-gray-500"></i>Observaciones <span class="text-gray-400">(Opcional)</span>
                    </label>
                    <textarea id="observaciones_apertura" 
                              name="observaciones_apertura" 
                              rows="3"
                              maxlength="500"
                              class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Ej: Billetes de S/ 10 y S/ 20 para cambio">{{ old('observaciones_apertura') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">Máximo 500 caracteres</p>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-4 border-t">
                    <a href="{{ route('cajas.index') }}" 
                       class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition text-center text-sm">
                        <i class="bi bi-x-lg mr-1"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition text-sm">
                        <i class="bi bi-unlock mr-1"></i>Abrir Caja
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="mt-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 px-4 py-2 rounded text-sm max-w-3xl mx-auto">
            <p>
                <i class="bi bi-exclamation-triangle mr-1"></i>
                <strong>Importante:</strong> Solo puedes tener una caja abierta a la vez. Recuerda cerrarla al finalizar tu turno.
            </p>
        </div>
    </div>
</x-app-layout>
