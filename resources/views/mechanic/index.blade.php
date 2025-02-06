<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socios --}}
        </h2>
    </x-slot>

    <div class="max-w-7xl  mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Lista de Mecanicos</h2>
            {{-- @can('buscar-socio')
                <form method="GET" action="{{ route('socios.index') }}" class="flex items-center">
                    <input type="text" name="buscar" placeholder="Buscar socio..." value="{{ request('buscar') }}"
                        class="border border-gray-300 rounded-lg py-2 px-4 mr-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                        Buscar
                    </button>
                </form>
            @endcan --}}
            {{-- @can('agregar-socio') --}}
            <a href="{{ route('mechanics.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                Agregar
            </a>
            {{-- @endcan --}}
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de registros -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nº Codigo
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombres y Apellidos
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nº Documento
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nacionalidad
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Telefono
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mechanics as $mechanic)
                        <tr>
                            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900">
                                {{ $mechanic->codigo }}
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900">
                                {{ $mechanic->nombres . ' ' . $mechanic->apellido_paterno . ' ' . $mechanic->apellido_materno }}
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $mechanic->nro_documento }}
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $mechanic->nacionalidad }}
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $mechanic->telefono }}
                            </td>

                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium text-gray-900">
                                <button type="button" id ="btn-{{ $mechanic->id }}"
                                    class=" px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-md {{ $mechanic->status_mechanic == 0 ? 'bg-green-200 text-green-700' : 'text-red-700  bg-red-200' }}"
                                    onclick="confirmDelete({{ $mechanic->id }}, '{{ $mechanic->status == 0 ? '¿Está seguro de desactivar este registro?' : '¿Está seguro de activar este registro?' }}')">
                                    @if ($mechanic->status_mechanic == 0)
                                        Disponible
                                    @else
                                        No disponible
                                    @endif
                                </button>
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium">
                                <a href="" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-1 text-center text-gray-500">
                                No hay registros disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mostrar los enlaces de paginación -->
        {{-- @if ($registros instanceof \Illuminate\Pagination\LengthAwarePaginator && $registros->count() > 0)
            {{ $registros->links() }}
        @endif --}}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</x-app-layout>
