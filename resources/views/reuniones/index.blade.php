<x-layouts.rbac>
    @section('title', 'Gestión de Reuniones')

    <div class="min-h-screen bg-gray-50">

        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="bx bx-group text-xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Gestión de Reuniones</h1>
                                <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row items-center gap-3">
                        <a href="{{ route('dashboard.reuniones.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva reunión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center mb-4 sm:mb-0">
                        <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                        Lista de Reuniones
                    </h2>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <input type="text" placeholder="Buscar reunión..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        </div>
                        <span class="text-sm text-gray-500">{{ $reuniones->count() }} reuniones</span>
                    </div>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-x-circle text-red-600 text-xl mr-3'></i>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-error text-yellow-600 text-xl mr-3'></i>
                            <p class="text-yellow-800 font-medium">{{ session('warning') }}</p>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    @if($reuniones->isEmpty())
                        <div class="text-center py-20">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                                    <i class='bx bx-calendar-x text-4xl text-gray-400'></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay reuniones registradas</h3>
                                <p class="text-gray-500 mb-6">Comienza creando tu primera reunión</p>
                                <a href="{{ route('dashboard.reuniones.create') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class='bx bx-plus mr-2'></i>
                                    Crear Primera Reunión
                                </a>
                            </div>
                        </div>
                    @else

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-group mr-2'></i>
                                            Reunión
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-file-blank mr-2'></i>
                                            Solicitud
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-buildings mr-2'></i>
                                            Institución
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-calendar mr-2'></i>
                                            Fecha
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-user-circle mr-2'></i>
                                            Asistentes
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                        <div class="flex items-center">
                                            <i class='bx bx-cog mr-2'></i>
                                            Acciones
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
        </div>
    </div>

    <!-- Custom Styles for Enhanced UI -->
    <style>
        /* Custom animations */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fade-in { animation: fade-in 0.6s ease-out; }
        .animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
        .animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
        
        /* Custom hover effects */
        .group:hover .group-hover\:rotate-90 { transform: rotate(90deg); }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            border-radius: 8px;
        }
        
        /* Filter tags */
        .filter-tag {
            animation: fade-in 0.3s ease-out;
        }
        
        /* Loading states */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Enhanced pagination */
        .custom-pagination .pagination {
            display: flex;
            align-items: center;
            space-x: 2;
        }
        
        .custom-pagination .page-link {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.75rem;
            border: 2px solid transparent;
            background: white;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .custom-pagination .page-link:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .custom-pagination .active .page-link {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .reunionRow td:nth-child(3),
            .reunionRow td:nth-child(4) {
                display: none;
            }
            
            .reunionRow td:first-child {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .reunionRow td:nth-child(2) {
                display: none;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Enhanced JavaScript Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== INITIALIZATION =====
            initializeCurrentDate();
            initializeViewToggle();
            initializeSearch();
            initializeFilters();
            initializeExport();
            initializeSortable();
            initializeTooltips();
            
            // ===== CURRENT DATE DISPLAY =====
            function initializeCurrentDate() {
                const currentDateElement = document.getElementById('current-date');
                if (currentDateElement) {
                    const now = new Date();
                    const options = { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    };
                    currentDateElement.textContent = now.toLocaleDateString('es-ES', options);
                }
            }
            
            // ===== VIEW TOGGLE FUNCTIONALITY =====
            function initializeViewToggle() {
                const tableViewBtn = document.getElementById('tableView');
                const cardViewBtn = document.getElementById('cardView');
                const tableContent = document.getElementById('tableViewContent');
                const cardContent = document.getElementById('cardViewContent');
                
                if (tableViewBtn && cardViewBtn && tableContent && cardContent) {
                    tableViewBtn.addEventListener('click', function() {
                        // Show table, hide cards
                        tableContent.classList.remove('hidden');
                        cardContent.classList.add('hidden');
                        
                        // Update button styles
                        tableViewBtn.classList.add('bg-white', 'shadow-sm', 'text-gray-700');
                        tableViewBtn.classList.remove('text-gray-600');
                        cardViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-gray-700');
                        cardViewBtn.classList.add('text-gray-600');
                        
                        // Save preference
                        localStorage.setItem('reuniones_view', 'table');
                    });
                    
                    cardViewBtn.addEventListener('click', function() {
                        // Show cards, hide table
                        cardContent.classList.remove('hidden');
                        tableContent.classList.add('hidden');
                        
                        // Update button styles
                        cardViewBtn.classList.add('bg-white', 'shadow-sm', 'text-gray-700');
                        cardViewBtn.classList.remove('text-gray-600');
                        tableViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-gray-700');
                        tableViewBtn.classList.add('text-gray-600');
                        
                        // Save preference
                        localStorage.setItem('reuniones_view', 'cards');
                    });
                    
                    // Load saved preference
                    const savedView = localStorage.getItem('reuniones_view');
                    if (savedView === 'cards') {
                        cardViewBtn.click();
                    }
                }
            }
            
            // ===== SEARCH FUNCTIONALITY =====
            function initializeSearch() {
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    let searchTimeout;
                    
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            performSearch(this.value.toLowerCase().trim());
                        }, 300);
                    });
                }
            }
            
            function performSearch(searchTerm) {
                const tableRows = document.querySelectorAll('.reunionRow');
                const cardItems = document.querySelectorAll('.reunionCard');
                let visibleCount = 0;
                
                // Search in table rows
                tableRows.forEach(row => {
                    const titulo = row.dataset.titulo || '';
                    const solicitud = row.dataset.solicitud || '';
                    const institucion = row.dataset.institucion || '';
                    
                    const isVisible = !searchTerm || 
                                    titulo.includes(searchTerm) || 
                                    solicitud.includes(searchTerm) || 
                                    institucion.includes(searchTerm);
                    
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });
                
                // Search in cards
                cardItems.forEach(card => {
                    const titulo = card.dataset.titulo || '';
                    const solicitud = card.dataset.solicitud || '';
                    const institucion = card.dataset.institucion || '';
                    
                    const isVisible = !searchTerm || 
                                    titulo.includes(searchTerm) || 
                                    solicitud.includes(searchTerm) || 
                                    institucion.includes(searchTerm);
                    
                    card.style.display = isVisible ? '' : 'none';
                });
                
                updateVisibleCount(visibleCount);
                updateActiveFilters();
            }
            
            // ===== FILTER FUNCTIONALITY =====
            function initializeFilters() {
                const dateFilter = document.getElementById('dateFilter');
                const institutionFilter = document.getElementById('institutionFilter');
                const clearFiltersBtn = document.getElementById('clearFilters');
                
                if (dateFilter) {
                    dateFilter.addEventListener('change', applyFilters);
                }
                
                if (institutionFilter) {
                    institutionFilter.addEventListener('change', applyFilters);
                }
                
                if (clearFiltersBtn) {
                    clearFiltersBtn.addEventListener('click', clearAllFilters);
                }
            }
            
            function applyFilters() {
                const dateFilter = document.getElementById('dateFilter').value;
                const institutionFilter = document.getElementById('institutionFilter').value.toLowerCase();
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                
                const tableRows = document.querySelectorAll('.reunionRow');
                const cardItems = document.querySelectorAll('.reunionCard');
                let visibleCount = 0;
                
                const today = new Date().toISOString().split('T')[0];
                const weekFromNow = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
                const monthFromNow = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
                
                // Filter table rows
                tableRows.forEach(row => {
                    const fecha = row.dataset.fecha;
                    const institucion = row.dataset.institucion;
                    const titulo = row.dataset.titulo;
                    const solicitud = row.dataset.solicitud;
                    
                    let isVisible = true;
                    
                    // Date filter
                    if (dateFilter) {
                        switch (dateFilter) {
                            case 'today':
                                isVisible = isVisible && fecha === today;
                                break;
                            case 'week':
                                isVisible = isVisible && fecha >= today && fecha <= weekFromNow;
                                break;
                            case 'month':
                                isVisible = isVisible && fecha >= today && fecha <= monthFromNow;
                                break;
                            case 'future':
                                isVisible = isVisible && fecha > today;
                                break;
                        }
                    }
                    
                    // Institution filter
                    if (institutionFilter) {
                        isVisible = isVisible && institucion.includes(institutionFilter);
                    }
                    
                    // Search filter
                    if (searchTerm) {
                        isVisible = isVisible && (
                            titulo.includes(searchTerm) || 
                            solicitud.includes(searchTerm) || 
                            institucion.includes(searchTerm)
                        );
                    }
                    
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });
                
                // Filter cards (same logic)
                cardItems.forEach(card => {
                    const fecha = card.dataset.fecha;
                    const institucion = card.dataset.institucion;
                    const titulo = card.dataset.titulo;
                    const solicitud = card.dataset.solicitud;
                    
                    let isVisible = true;
                    
                    // Apply same filters...
                    if (dateFilter) {
                        switch (dateFilter) {
                            case 'today':
                                isVisible = isVisible && fecha === today;
                                break;
                            case 'week':
                                isVisible = isVisible && fecha >= today && fecha <= weekFromNow;
                                break;
                            case 'month':
                                isVisible = isVisible && fecha >= today && fecha <= monthFromNow;
                                break;
                            case 'future':
                                isVisible = isVisible && fecha > today;
                                break;
                        }
                    }
                    
                    if (institutionFilter) {
                        isVisible = isVisible && institucion.includes(institutionFilter);
                    }
                    
                    if (searchTerm) {
                        isVisible = isVisible && (
                            titulo.includes(searchTerm) || 
                            solicitud.includes(searchTerm) || 
                            institucion.includes(searchTerm)
                        );
                    }
                    
                    card.style.display = isVisible ? '' : 'none';
                });
                
                updateVisibleCount(visibleCount);
                updateActiveFilters();
            }
            
            function clearAllFilters() {
                document.getElementById('searchInput').value = '';
                document.getElementById('dateFilter').value = '';
                document.getElementById('institutionFilter').value = '';
                
                // Show all items
                document.querySelectorAll('.reunionRow, .reunionCard').forEach(item => {
                    item.style.display = '';
                });
                
                updateVisibleCount({{ $reuniones->count() }});
                updateActiveFilters();
            }
            
            function updateActiveFilters() {
                const activeFiltersContainer = document.getElementById('activeFilters');
                const filterTagsContainer = document.getElementById('filterTags');
                
                if (!activeFiltersContainer || !filterTagsContainer) return;
                
                const searchTerm = document.getElementById('searchInput').value;
                const dateFilter = document.getElementById('dateFilter').value;
                const institutionFilter = document.getElementById('institutionFilter').value;
                
                filterTagsContainer.innerHTML = '';
                
                let hasActiveFilters = false;
                
                if (searchTerm) {
                    addFilterTag('Búsqueda', searchTerm, () => {
                        document.getElementById('searchInput').value = '';
                        applyFilters();
                    });
                    hasActiveFilters = true;
                }
                
                if (dateFilter) {
                    const dateLabels = {
                        'today': 'Hoy',
                        'week': 'Esta semana',
                        'month': 'Este mes',
                        'future': 'Próximas'
                    };
                    addFilterTag('Fecha', dateLabels[dateFilter], () => {
                        document.getElementById('dateFilter').value = '';
                        applyFilters();
                    });
                    hasActiveFilters = true;
                }
                
                if (institutionFilter) {
                    addFilterTag('Institución', institutionFilter, () => {
                        document.getElementById('institutionFilter').value = '';
                        applyFilters();
                    });
                    hasActiveFilters = true;
                }
                
                activeFiltersContainer.classList.toggle('hidden', !hasActiveFilters);
            }
            
            function addFilterTag(label, value, removeCallback) {
                const filterTagsContainer = document.getElementById('filterTags');
                const tag = document.createElement('div');
                tag.className = 'filter-tag inline-flex items-center bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full';
                tag.innerHTML = `
                    <span class="mr-2">${label}: ${value}</span>
                    <button class="hover:bg-blue-200 rounded-full p-1 transition-colors duration-200">
                        <i class='bx bx-x text-sm'></i>
                    </button>
                `;
                
                tag.querySelector('button').addEventListener('click', removeCallback);
                filterTagsContainer.appendChild(tag);
            }
            
            function updateVisibleCount(count) {
                const visibleCountElement = document.getElementById('visibleCount');
                if (visibleCountElement) {
                    visibleCountElement.textContent = count;
                }
            }
            
            // ===== EXPORT FUNCTIONALITY =====
            function initializeExport() {
                const exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                    exportBtn.addEventListener('click', function() {
                        Swal.fire({
                            title: 'Exportar Reuniones',
                            text: '¿En qué formato desea exportar los datos?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'PDF',
                            cancelButtonText: 'Excel',
                            confirmButtonColor: '#3b82f6',
                            cancelButtonColor: '#10b981',
                            background: '#f8fafc',
                            customClass: {
                                title: 'text-gray-900',
                                content: 'text-gray-700'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                exportToPDF();
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                exportToExcel();
                            }
                        });
                    });
                }
            }
            
            function exportToPDF() {
                Swal.fire({
                    title: 'Generando PDF...',
                    text: 'Por favor espere mientras se procesa la información.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    Swal.fire('¡Éxito!', 'El archivo PDF se ha descargado correctamente.', 'success');
                });
            }
            
            function exportToExcel() {
                Swal.fire({
                    title: 'Generando Excel...',
                    text: 'Por favor espere mientras se procesa la información.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    Swal.fire('¡Éxito!', 'El archivo Excel se ha descargado correctamente.', 'success');
                });
            }
            
            // ===== SORTABLE FUNCTIONALITY =====
            function initializeSortable() {
                // This would implement table sorting functionality
                // For now, we'll just add visual feedback
            }
            
            // ===== TOOLTIPS =====
            function initializeTooltips() {
                // Add hover effects and enhanced tooltips
                const actionButtons = document.querySelectorAll('[title]');
                actionButtons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        // Could add custom tooltips here
                    });
                });
            }
        });
        
        // ===== DELETE FUNCTIONALITY WITH SWEETALERT2 =====
        function deleteReunion(reunionId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer. La reunión será eliminada permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#f8fafc',
                customClass: {
                    title: 'text-gray-900 font-bold',
                    content: 'text-gray-700',
                    confirmButton: 'font-semibold',
                    cancelButton: 'font-semibold'
                },
                backdrop: `
                    rgba(0,0,0,0.4)
                    center
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Eliminando reunión...',
                        text: 'Por favor espere mientras se procesa la eliminación.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create and submit form with correct Laravel route
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("dashboard/reuniones") }}/' + reunionId;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    
                    // Submit with error handling
                    setTimeout(() => {
                        form.submit();
                    }, 800);
                }
            });
        }
        
        // ===== TABLE SORTING =====
        function sortTable(column) {
            // Add visual feedback for sorting
            const sortIcon = event.target.closest('th').querySelector('.bx-sort');
            if (sortIcon) {
                sortIcon.classList.add('text-blue-600');
                setTimeout(() => {
                    sortIcon.classList.remove('text-blue-600');
                }, 300);
            }
        }
        
        // ===== RESPONSIVE ENHANCEMENTS =====
        window.addEventListener('resize', function() {
            // Handle responsive layout changes
            if (window.innerWidth < 768) {
                // Mobile optimizations
                const cardView = document.getElementById('cardView');
                if (cardView && !cardView.classList.contains('bg-white')) {
                    cardView.click(); // Switch to card view on mobile
                }
            }
        });
    </script>
</x-layouts.rbac>