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
                                <tbody class="bg-white/50 backdrop-blur-sm divide-y divide-gray-200/30">
                                    @forelse ($reuniones as $reunion)
                                        <tr class="hover:bg-blue-50/50 hover:shadow-lg transition-all duration-300 cursor-pointer group reunionRow" 
                                            data-titulo="{{ strtolower($reunion->titulo) }}"
                                            data-solicitud="{{ strtolower($reunion->solicitud->titulo ?? '') }}"
                                            data-institucion="{{ strtolower($reunion->institucion->titulo ?? '') }}"
                                            data-fecha="{{ $reunion->fecha_reunion->format('Y-m-d') }}">
                                            <td class="px-8 py-6">
                                                <div class="space-y-2">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                            {{ substr($reunion->titulo, 0, 1) }}
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="text-base font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                                                                {{ $reunion->titulo }}
                                                            </div>
                                                            @if($reunion->descripcion)
                                                                <div class="text-sm text-gray-600 truncate max-w-xs mt-1" title="{{ $reunion->descripcion }}">
                                                                    {{ Str::limit($reunion->descripcion, 60) }}
                                                                </div>
                                                            @endif
                                                            @if($reunion->ubicacion)
                                                                <div class="flex items-center text-xs text-gray-500 mt-2 bg-gray-100 px-3 py-1 rounded-full inline-flex">
                                                                    <i class='bx bx-map-pin mr-1 text-red-500'></i>
                                                                    {{ Str::limit($reunion->ubicacion, 35) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="space-y-2">
                                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-green-700 transition-colors duration-200">
                                                        {{ $reunion->solicitud->titulo ?? 'N/A' }}
                                                    </div>
                                                    @if($reunion->solicitud)
                                                        <div class="inline-flex items-center text-xs font-medium text-green-700 bg-green-100 px-3 py-1 rounded-full">
                                                            <i class='bx bx-hash mr-1'></i>
                                                            {{ $reunion->solicitud->solicitud_id }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                                        <i class='bx bx-buildings text-white text-sm'></i>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900 group-hover:text-purple-700 transition-colors duration-200">
                                                        {{ $reunion->institucion->titulo ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="space-y-2">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="text-base font-bold text-gray-900">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                                                        @if($reunion->fecha_reunion->isToday())
                                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium animate-pulse">HOY</span>
                                                        @elseif($reunion->fecha_reunion->isFuture())
                                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">PRÓXIMA</span>
                                                        @endif
                                                    </div>
                                                    <div class="inline-flex items-center text-sm text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                                                        <i class='bx bx-time mr-2'></i>
                                                        {{ $reunion->fecha_reunion->format('H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-800 shadow-sm">
                                                        <i class='bx bx-user mr-2'></i>
                                                        {{ $reunion->asistentes->count() }} personas
                                                    </span>
                                                    @if($reunion->concejal())
                                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 shadow-sm">
                                                            <i class='bx bx-crown mr-2 text-yellow-600'></i>
                                                            Concejal
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <!-- Ver -->
                                                    <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                                                       class="group p-3 text-blue-600 hover:bg-blue-50 rounded-2xl transition-all duration-300 hover:shadow-xl transform hover:scale-110 hover:-translate-y-1" 
                                                       title="Ver detalles">
                                                        <i class='bx bx-show text-xl group-hover:text-blue-700'></i>
                                                    </a>
                                                    <!-- Editar -->
                                                    <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                                                       class="group p-3 text-emerald-600 hover:bg-emerald-50 rounded-2xl transition-all duration-300 hover:shadow-xl transform hover:scale-110 hover:-translate-y-1" 
                                                       title="Editar">
                                                        <i class='bx bx-edit text-xl group-hover:text-emerald-700'></i>
                                                    </a>
                                                    <!-- Eliminar -->
                                                    <button onclick="deleteReunion({{ $reunion->id }})"
                                                            class="group p-3 text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300 hover:shadow-xl transform hover:scale-110 hover:-translate-y-1" 
                                                            title="Eliminar">
                                                        <i class='bx bx-trash text-xl group-hover:text-red-700'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-8 py-20 text-center">
                                                <div class="flex flex-col items-center animate-fade-in">
                                                    <div class="relative mb-8">
                                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center shadow-xl">
                                                            <i class='bx bx-calendar-x text-5xl text-gray-400'></i>
                                                        </div>
                                                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                                            <i class='bx bx-plus text-white text-lg'></i>
                                                        </div>
                                                    </div>
                                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No hay reuniones registradas</h3>
                                                    <p class="text-gray-600 mb-8 max-w-md text-center leading-relaxed">
                                                        Comience creando una nueva reunión para gestionar las actividades municipales y coordinar con las instituciones del municipio.
                                                    </p>
                                                    <a href="{{ route('dashboard.reuniones.create') }}" 
                                                       class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white rounded-2xl hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105">
                                                        <i class='bx bx-plus mr-3 text-2xl group-hover:rotate-90 transition-transform duration-300'></i>
                                                        <span class="font-bold text-lg">Crear Primera Reunión</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card View (Hidden by default) -->
                    <div id="cardViewContent" class="hidden grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse ($reuniones as $reunion)
                            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden group reunionCard"
                                 data-titulo="{{ strtolower($reunion->titulo) }}"
                                 data-solicitud="{{ strtolower($reunion->solicitud->titulo ?? '') }}"
                                 data-institucion="{{ strtolower($reunion->institucion->titulo ?? '') }}"
                                 data-fecha="{{ $reunion->fecha_reunion->format('Y-m-d') }}">
                                <!-- Card Header -->
                                <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 p-6 text-white">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2 leading-tight">{{ $reunion->titulo }}</h3>
                                            <div class="flex items-center text-blue-100 text-sm">
                                                <i class='bx bx-calendar mr-2'></i>
                                                {{ $reunion->fecha_reunion->format('d/m/Y') }} - {{ $reunion->fecha_reunion->format('H:i') }}
                                            </div>
                                        </div>
                                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                            <i class='bx bx-group text-2xl'></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Content -->
                                <div class="p-6 space-y-4">
                                    <!-- Institution -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                                            <i class='bx bx-buildings text-purple-600'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Institución</p>
                                            <p class="font-semibold text-gray-900">{{ $reunion->institucion->titulo ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Request -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                                            <i class='bx bx-file-blank text-green-600'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Solicitud</p>
                                            <p class="font-semibold text-gray-900 truncate" title="{{ $reunion->solicitud->titulo ?? 'N/A' }}">
                                                {{ Str::limit($reunion->solicitud->titulo ?? 'N/A', 30) }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Location -->
                                    @if($reunion->ubicacion)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center">
                                                <i class='bx bx-map-pin text-red-600'></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Ubicación</p>
                                                <p class="font-semibold text-gray-900 truncate" title="{{ $reunion->ubicacion }}">
                                                    {{ Str::limit($reunion->ubicacion, 30) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Participants -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                        <div class="flex space-x-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                                <i class='bx bx-user mr-1'></i>
                                                {{ $reunion->asistentes->count() }}
                                            </span>
                                            @if($reunion->concejal())
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    <i class='bx bx-crown mr-1'></i>
                                                    Concejal
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        @if($reunion->fecha_reunion->isToday())
                                            <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold animate-pulse">HOY</span>
                                        @elseif($reunion->fecha_reunion->isFuture())
                                            <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold">PRÓXIMA</span>
                                        @else
                                            <span class="bg-gray-400 text-white text-xs px-3 py-1 rounded-full font-bold">PASADA</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Card Actions -->
                                <div class="px-6 pb-6">
                                    <div class="flex items-center justify-between space-x-3">
                                        <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-all duration-200 font-medium">
                                            <i class='bx bx-show mr-2'></i>
                                            Ver
                                        </a>
                                        <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl hover:bg-emerald-100 transition-all duration-200 font-medium">
                                            <i class='bx bx-edit mr-2'></i>
                                            Editar
                                        </a>
                                        <button onclick="deleteReunion({{ $reunion->id }})"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full flex flex-col items-center py-20">
                                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                                    <i class='bx bx-calendar-x text-4xl text-gray-400'></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay reuniones</h3>
                                <p class="text-gray-500 mb-6">Comienza creando tu primera reunión</p>
                                <a href="{{ route('dashboard.reuniones.create') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200">
                                    <i class='bx bx-plus mr-2'></i>
                                    Crear Reunión
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($reuniones->hasPages())
                        <div class="mt-8 px-8 py-6 border-t border-gray-200/50 bg-gray-50/50 rounded-b-3xl">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Mostrando {{ $reuniones->firstItem() }} a {{ $reuniones->lastItem() }} de {{ $reuniones->total() }} reuniones
                                </div>
                                <div class="custom-pagination">
                                    {{ $reuniones->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>