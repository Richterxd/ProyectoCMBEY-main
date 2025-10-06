<x-layouts.rbac>
    @section('title', 'Gestión de Reuniones')

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section - Modernized -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class='bx bx-group text-white text-2xl'></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Gestión de Reuniones</h1>
                                <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.reuniones.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class='bx bx-plus mr-2 text-lg'></i>
                            Nueva Reunión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message - Enhanced -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <i class='bx bx-check text-white text-lg'></i>
                        </div>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content Section - Enhanced -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-calendar-event text-blue-600 text-lg'></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">
                                Reuniones Registradas
                            </h2>
                        </div>
                        <div class="bg-gray-50 px-3 py-1 rounded-full">
                            <span class="text-sm text-gray-600 font-medium">
                                Total: {{ $reuniones->total() }} reuniones
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-text text-gray-400'></i>
                                            <span>Reunión</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-file-blank text-gray-400'></i>
                                            <span>Solicitud</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-buildings text-gray-400'></i>
                                            <span>Institución</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-calendar text-gray-400'></i>
                                            <span>Fecha</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <i class='bx bx-group text-gray-400'></i>
                                            <span>Asistentes</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center justify-end space-x-2">
                                            <i class='bx bx-cog text-gray-400'></i>
                                            <span>Acciones</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reuniones as $reunion)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $reunion->titulo }}</div>
                                                @if($reunion->descripcion)
                                                    <div class="text-sm text-gray-500 truncate max-w-xs" title="{{ $reunion->descripcion }}">
                                                        {{ Str::limit($reunion->descripcion, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reunion->solicitud->titulo ?? 'N/A' }}</div>
                                            @if($reunion->solicitud)
                                                <div class="text-sm text-gray-500">ID: {{ $reunion->solicitud->solicitud_id }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reunion->institucion->titulo ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $reunion->fecha_reunion->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $reunion->asistentes->count() }} personas
                                                </span>
                                                @if($reunion->concejal())
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class='bx bx-star mr-1'></i>
                                                        Concejal
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- Ver -->
                                                <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                                   title="Ver detalles">
                                                    <i class='bx bx-show'></i>
                                                </a>
                                                <!-- Editar -->
                                                <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                                   title="Editar">
                                                    <i class='bx bx-edit'></i>
                                                </a>
                                                <!-- Eliminar -->
                                                <form action="{{ route('dashboard.reuniones.destroy', $reunion) }}" 
                                                      method="POST" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reunión?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                                            title="Eliminar">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class='bx bx-calendar-x text-4xl text-gray-400 mb-4'></i>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reuniones registradas</h3>
                                                <p class="text-gray-500 mb-4">Comience creando una nueva reunión para gestionar las actividades municipales.</p>
                                                <a href="{{ route('dashboard.reuniones.create') }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                    <i class='bx bx-plus mr-2'></i>
                                                    Crear Primera Reunión
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($reuniones->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $reuniones->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>