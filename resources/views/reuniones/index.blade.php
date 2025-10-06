<x-layouts.rbac>
    @section('title', 'Gestión de Reuniones')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-indigo-50/20">
        <!-- Enhanced Header Section with Animation -->
        <div class="bg-white/80 backdrop-blur-sm shadow-xl border-b border-gray-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center py-8">
                    <div class="flex items-center mb-6 md:mb-0 animate-slide-in-left">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class='bx bx-group text-white text-3xl'></i>
                                </div>
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <i class='bx bx-check text-white text-sm'></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">Gestión de Reuniones</h1>
                                <p class="text-sm text-gray-600 flex items-center">
                                    <i class='bx bx-buildings mr-2 text-blue-600'></i>
                                    Sistema Municipal CMBEY - Módulo Administrativo
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 animate-slide-in-right">
                        <div class="hidden lg:flex items-center space-x-3 bg-blue-50 px-4 py-2 rounded-xl border border-blue-200">
                            <i class='bx bx-calendar-event text-blue-600'></i>
                            <span class="text-sm font-medium text-blue-800" id="current-date"></span>
                        </div>
                        <a href="{{ route('dashboard.reuniones.create') }}" 
                           class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105">
                            <i class='bx bx-plus mr-3 text-xl group-hover:rotate-90 transition-transform duration-300'></i>
                            <span class="font-semibold">Nueva Reunión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters & Controls Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 p-6 mb-6 animate-fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <!-- Search & Filters -->
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 flex-1">
                        <!-- Search Bar -->
                        <div class="relative flex-1 max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class='bx bx-search text-gray-400 text-lg'></i>
                            </div>
                            <input type="text" 
                                   id="searchInput"
                                   class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm" 
                                   placeholder="Buscar reuniones...">
                        </div>
                        
                        <!-- Date Filter -->
                        <div class="relative">
                            <select id="dateFilter" class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todas las fechas</option>
                                <option value="today">Hoy</option>
                                <option value="week">Esta semana</option>
                                <option value="month">Este mes</option>
                                <option value="future">Próximas</option>
                            </select>
                        </div>
                        
                        <!-- Institution Filter -->
                        <div class="relative">
                            <select id="institutionFilter" class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todas las instituciones</option>
                                @foreach($reuniones->unique('institucion.titulo') as $reunion)
                                    @if($reunion->institucion)
                                        <option value="{{ $reunion->institucion->titulo }}">{{ $reunion->institucion->titulo }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- View Controls & Export -->
                    <div class="flex items-center space-x-3">
                        <!-- View Toggle -->
                        <div class="flex bg-gray-100 rounded-xl p-1">
                            <button id="tableView" class="px-4 py-2 rounded-lg bg-white shadow-sm text-gray-700 text-sm font-medium transition-all duration-200">
                                <i class='bx bx-table mr-2'></i>Tabla
                            </button>
                            <button id="cardView" class="px-4 py-2 rounded-lg text-gray-600 text-sm font-medium hover:bg-white hover:shadow-sm transition-all duration-200">
                                <i class='bx bx-grid-alt mr-2'></i>Cards
                            </button>
                        </div>
                        
                        <!-- Export Button -->
                        <div class="relative">
                            <button id="exportBtn" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class='bx bx-download mr-2'></i>
                                <span class="hidden sm:inline">Exportar</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Active Filters Display -->
                <div id="activeFilters" class="hidden mt-4 pt-4 border-t border-gray-200">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-600">Filtros activos:</span>
                        <div id="filterTags" class="flex flex-wrap gap-2"></div>
                        <button id="clearFilters" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Limpiar filtros</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message with SweetAlert2 -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        timerProgressBar: true,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        background: '#f0fdf4',
                        color: '#166534'
                    });
                });
            </script>
        @endif

        <!-- Enhanced Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Reuniones</p>
                            <p class="text-2xl font-bold">{{ $reuniones->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-calendar-event text-2xl'></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Este Mes</p>
                            <p class="text-2xl font-bold">{{ $reuniones->where('fecha_reunion', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-trending-up text-2xl'></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Próximas</p>
                            <p class="text-2xl font-bold">{{ $reuniones->where('fecha_reunion', '>', now())->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-time-five text-2xl'></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Instituciones</p>
                            <p class="text-2xl font-bold">{{ $reuniones->unique('institucion_id')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-buildings text-2xl'></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center">
                                <i class='bx bx-calendar-event text-blue-600 text-2xl'></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    Reuniones Registradas
                                </h2>
                                <p class="text-gray-600 text-sm">Gestión completa del sistema de reuniones</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 rounded-xl border border-blue-200">
                                <span class="text-sm text-blue-800 font-semibold flex items-center">
                                    <i class='bx bx-layer mr-2'></i>
                                    <span id="visibleCount">{{ $reuniones->count() }}</span> de {{ $reuniones->total() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Table View -->
                    <div id="tableViewContent" class="overflow-hidden rounded-2xl border border-gray-200/50">
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200/50">
                                <thead class="bg-gradient-to-r from-gray-50/80 to-blue-50/80 backdrop-blur-sm">
                                    <tr>
                                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center space-x-3 group cursor-pointer" onclick="sortTable('titulo')">
                                                <i class='bx bx-text text-blue-500'></i>
                                                <span class="group-hover:text-blue-600 transition-colors duration-200">Reunión</span>
                                                <i class='bx bx-sort text-gray-400 group-hover:text-blue-500 transition-colors duration-200'></i>
                                            </div>
                                        </th>
                                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center space-x-3 group cursor-pointer" onclick="sortTable('solicitud')">
                                                <i class='bx bx-file-blank text-green-500'></i>
                                                <span class="group-hover:text-green-600 transition-colors duration-200">Solicitud</span>
                                                <i class='bx bx-sort text-gray-400 group-hover:text-green-500 transition-colors duration-200'></i>
                                            </div>
                                        </th>
                                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center space-x-3 group cursor-pointer" onclick="sortTable('institucion')">
                                                <i class='bx bx-buildings text-purple-500'></i>
                                                <span class="group-hover:text-purple-600 transition-colors duration-200">Institución</span>
                                                <i class='bx bx-sort text-gray-400 group-hover:text-purple-500 transition-colors duration-200'></i>
                                            </div>
                                        </th>
                                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center space-x-3 group cursor-pointer" onclick="sortTable('fecha')">
                                                <i class='bx bx-calendar text-orange-500'></i>
                                                <span class="group-hover:text-orange-600 transition-colors duration-200">Fecha</span>
                                                <i class='bx bx-sort text-gray-400 group-hover:text-orange-500 transition-colors duration-200'></i>
                                            </div>
                                        </th>
                                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center space-x-3">
                                                <i class='bx bx-group text-indigo-500'></i>
                                                <span>Asistentes</span>
                                            </div>
                                        </th>
                                        <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-blue-100">
                                            <div class="flex items-center justify-end space-x-3">
                                                <i class='bx bx-cog text-gray-500'></i>
                                                <span>Acciones</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($reuniones as $reunion)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="text-sm font-semibold text-gray-900">{{ $reunion->titulo }}</div>
                                                @if($reunion->descripcion)
                                                    <div class="text-sm text-gray-500 truncate max-w-xs" title="{{ $reunion->descripcion }}">
                                                        {{ Str::limit($reunion->descripcion, 50) }}
                                                    </div>
                                                @endif
                                                @if($reunion->ubicacion)
                                                    <div class="flex items-center text-xs text-gray-400">
                                                        <i class='bx bx-map-pin mr-1'></i>
                                                        {{ Str::limit($reunion->ubicacion, 30) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="text-sm font-medium text-gray-900">{{ $reunion->solicitud->titulo ?? 'N/A' }}</div>
                                                @if($reunion->solicitud)
                                                    <div class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md inline-block">
                                                        ID: {{ $reunion->solicitud->solicitud_id }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $reunion->institucion->titulo ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="text-sm font-semibold text-gray-900">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                                                <div class="text-xs text-gray-500 bg-blue-50 px-2 py-0.5 rounded-md inline-block">
                                                    <i class='bx bx-time mr-1'></i>{{ $reunion->fecha_reunion->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800">
                                                    <i class='bx bx-user mr-1'></i>
                                                    {{ $reunion->asistentes->count() }} personas
                                                </span>
                                                @if($reunion->concejal())
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800">
                                                        <i class='bx bx-star mr-1'></i>
                                                        Concejal
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- Ver -->
                                                <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                                                   class="p-2.5 text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 hover:shadow-md transform hover:scale-105" 
                                                   title="Ver detalles">
                                                    <i class='bx bx-show text-lg'></i>
                                                </a>
                                                <!-- Editar -->
                                                <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                                                   class="p-2.5 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200 hover:shadow-md transform hover:scale-105" 
                                                   title="Editar">
                                                    <i class='bx bx-edit text-lg'></i>
                                                </a>
                                                <!-- Eliminar -->
                                                <form action="{{ route('dashboard.reuniones.destroy', $reunion) }}" 
                                                      method="POST" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reunión?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2.5 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 hover:shadow-md transform hover:scale-105" 
                                                            title="Eliminar">
                                                        <i class='bx bx-trash text-lg'></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-6">
                                                    <i class='bx bx-calendar-x text-4xl text-gray-400'></i>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay reuniones registradas</h3>
                                                <p class="text-gray-500 mb-6 max-w-md">Comience creando una nueva reunión para gestionar las actividades municipales y coordinar con las instituciones.</p>
                                                <a href="{{ route('dashboard.reuniones.create') }}" 
                                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                    <i class='bx bx-plus mr-2 text-lg'></i>
                                                    Crear Primera Reunión
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($reuniones->hasPages())
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
                                {{ $reuniones->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>