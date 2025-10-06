<x-layouts.rbac>
    @section('title', 'Detalles de la Reunión')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50/30 to-purple-50/20">
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm shadow-2xl border-b border-gray-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center py-8">
                    <div class="flex items-center mb-6 lg:mb-0 animate-slide-in-left">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class='bx bx-calendar-event text-white text-3xl'></i>
                                </div>
                                <!-- Status Badge -->
                                @if($reunion->fecha_reunion->isToday())
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                        <span class="text-white text-xs font-bold">HOY</span>
                                    </div>
                                @elseif($reunion->fecha_reunion->isFuture())
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                        <i class='bx bx-time text-white text-sm'></i>
                                    </div>
                                @else
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center shadow-lg">
                                        <i class='bx bx-check text-white text-sm'></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">Detalles de la Reunión</h1>
                                <p class="text-indigo-600 font-semibold flex items-center mb-2">
                                    <i class='bx bx-text mr-2'></i>
                                    {{ $reunion->titulo }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class='bx bx-buildings mr-1'></i>
                                    Sistema Municipal CMBEY - Vista Detallada
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-4 animate-slide-in-right">
                        <!-- Quick Info Display -->
                        <div class="hidden xl:flex items-center space-x-4 bg-indigo-50 px-6 py-3 rounded-xl border border-indigo-200">
                            <div class="text-center">
                                <div class="text-xs text-indigo-600 font-medium">Participantes</div>
                                <div class="text-lg font-bold text-indigo-800">{{ $reunion->asistentes->count() }}</div>
                            </div>
                            <div class="w-px h-8 bg-indigo-300"></div>
                            <div class="text-center">
                                <div class="text-xs text-indigo-600 font-medium">Estado</div>
                                <div class="text-sm font-bold text-indigo-800">
                                    @if($reunion->fecha_reunion->isToday())
                                        En Curso
                                    @elseif($reunion->fecha_reunion->isFuture())
                                        Programada
                                    @else
                                        Finalizada
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Print Button -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class='bx bx-printer mr-2 group-hover:scale-110 transition-transform duration-200'></i>
                                <span class="font-medium">Imprimir</span>
                                <i class='bx bx-chevron-down ml-2 transition-transform duration-200' :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                                <div class="p-2">
                                    <a href="{{ route('dashboard.reuniones.pdf', $reunion) }}" 
                                       class="group flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-all duration-200">
                                        <i class='bx bx-file-pdf text-red-600 mr-3 text-lg group-hover:scale-110 transition-transform'></i>
                                        <div>
                                            <div class="font-semibold">Descargar PDF</div>
                                            <div class="text-xs text-gray-500">Con DomPDF</div>
                                        </div>
                                    </a>
                                    <button onclick="printMeeting()" 
                                            class="group flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all duration-200">
                                        <i class='bx bx-printer text-blue-600 mr-3 text-lg group-hover:scale-110 transition-transform'></i>
                                        <div>
                                            <div class="font-semibold">Imprimir Navegador</div>
                                            <div class="text-xs text-gray-500">Vista optimizada</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Button -->
                        <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                           class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class='bx bx-edit mr-2 group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Editar</span>
                        </a>
                        
                        <!-- Back Button -->
                        <a href="{{ route('dashboard.reuniones.index') }}" 
                           class="group inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                            <i class='bx bx-arrow-back mr-2 group-hover:-translate-x-1 transition-transform duration-200'></i>
                            <span>Volver</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Status Banner -->
        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center py-4">
                    @if($reunion->fecha_reunion->isToday())
                        <div class="flex items-center bg-red-100 px-6 py-3 rounded-xl border border-red-200 animate-pulse">
                            <i class='bx bx-time-five text-red-600 mr-3 text-xl'></i>
                            <span class="text-red-800 font-bold">Reunión programada para HOY - {{ $reunion->fecha_reunion->format('H:i') }}</span>
                        </div>
                    @elseif($reunion->fecha_reunion->isFuture())
                        <div class="flex items-center bg-blue-100 px-6 py-3 rounded-xl border border-blue-200">
                            <i class='bx bx-calendar-check text-blue-600 mr-3 text-xl'></i>
                            <span class="text-blue-800 font-semibold">Reunión programada para {{ $reunion->fecha_reunion->format('d/m/Y') }} - {{ $reunion->fecha_reunion->diffForHumans() }}</span>
                        </div>
                    @else
                        <div class="flex items-center bg-green-100 px-6 py-3 rounded-xl border border-green-200">
                            <i class='bx bx-check-circle text-green-600 mr-3 text-xl'></i>
                            <span class="text-green-800 font-semibold">Reunión finalizada - {{ $reunion->fecha_reunion->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Date Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Fecha</p>
                            <p class="text-xl font-bold">{{ $reunion->fecha_reunion->format('d/m/Y') }}</p>
                            <p class="text-blue-200 text-sm">{{ $reunion->fecha_reunion->format('H:i') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-calendar text-2xl'></i>
                        </div>
                    </div>
                </div>

                <!-- Participants Card -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Participantes</p>
                            <p class="text-xl font-bold">{{ $reunion->asistentes->count() }}</p>
                            <p class="text-green-200 text-sm">Personas</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-group text-2xl'></i>
                        </div>
                    </div>
                </div>

                <!-- Institution Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Institución</p>
                            <p class="text-sm font-bold">{{ Str::limit($reunion->institucion->titulo ?? 'N/A', 12) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-buildings text-2xl'></i>
                        </div>
                    </div>
                </div>

                <!-- Councilor Card -->
                <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Concejal</p>
                            <p class="text-sm font-bold">
                                @if($reunion->concejal())
                                    Asignado
                                @else
                                    Sin asignar
                                @endif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class='bx bx-crown text-2xl'></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Main Information Panel -->
                <div class="space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-600 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Información Principal</h3>
                                    <p class="text-indigo-100">Detalles generales de la reunión</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                    <i class='bx bx-info-circle text-2xl'></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8 space-y-6">
                            <!-- Title -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-text text-white text-xl'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-2">Título de la Reunión</h4>
                                        <p class="text-lg font-bold text-gray-900 leading-relaxed">{{ $reunion->titulo }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-calendar text-white text-xl'></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-green-600 uppercase tracking-wide mb-3">Fecha y Hora</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-green-600 font-medium mb-1">Fecha</p>
                                                <p class="text-lg font-bold text-gray-900">{{ $reunion->fecha_reunion->format('d/m/Y') }}</p>
                                                <p class="text-sm text-gray-600">{{ $reunion->fecha_reunion->locale('es')->dayName }}, {{ $reunion->fecha_reunion->locale('es')->monthName }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-green-600 font-medium mb-1">Hora</p>
                                                <p class="text-lg font-bold text-gray-900">{{ $reunion->fecha_reunion->format('H:i') }}</p>
                                                <p class="text-sm text-gray-600">{{ $reunion->fecha_reunion->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            @if($reunion->ubicacion)
                                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-2xl p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class='bx bx-map-pin text-white text-xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-red-600 uppercase tracking-wide mb-2">Ubicación</h4>
                                            <p class="text-lg font-semibold text-gray-900">{{ $reunion->ubicacion }}</p>
                                            <button onclick="openMaps('{{ urlencode($reunion->ubicacion) }}')" class="mt-3 inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                                                <i class='bx bx-map mr-2'></i>
                                                Abrir en Maps
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description Card -->
                    @if($reunion->descripcion)
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold mb-2">Descripción y Objetivos</h3>
                                        <p class="text-purple-100">Detalles específicos de la reunión</p>
                                    </div>
                                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                        <i class='bx bx-detail text-2xl'></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-8">
                                <div class="prose prose-lg max-w-none">
                                    <p class="text-gray-700 leading-relaxed text-lg">{{ $reunion->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Panel -->
                <div class="space-y-6">
                    <!-- Related Information -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Información Relacionada</h3>
                                    <p class="text-green-100">Solicitud e institución asociadas</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                    <i class='bx bx-link-alt text-2xl'></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8 space-y-6">
                            <!-- Associated Request -->
                            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-file-blank text-white text-xl'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-2">Solicitud Asociada</h4>
                                        @if($reunion->solicitud)
                                            <p class="text-lg font-semibold text-gray-900 mb-2">{{ $reunion->solicitud->titulo }}</p>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                    <i class='bx bx-hash mr-1'></i>
                                                    ID: {{ $reunion->solicitud->solicitud_id }}
                                                </span>
                                            </div>
                                        @else
                                            <p class="text-gray-500 italic">No hay solicitud asociada</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Institution -->
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-buildings text-white text-xl'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-purple-600 uppercase tracking-wide mb-2">Institución Responsable</h4>
                                        <p class="text-lg font-semibold text-gray-900">{{ $reunion->institucion->titulo ?? 'No especificada' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Participants Panel -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">Participantes</h3>
                                    <p class="text-orange-100">{{ $reunion->asistentes->count() }} personas registradas</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                    <i class='bx bx-group text-2xl'></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            @if($reunion->asistentes->count() > 0)
                                <div class="space-y-4">
                                    @foreach($reunion->asistentes as $asistente)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                                            <div class="flex items-center space-x-4">
                                                <div class="relative">
                                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                        {{ substr($asistente->nombre, 0, 1) }}{{ substr($asistente->apellido, 0, 1) }}
                                                    </div>
                                                    @if($asistente->pivot->es_concejal)
                                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                                            <i class='bx bx-crown text-white text-xs'></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $asistente->nombre }} {{ $asistente->apellido }}</p>
                                                    <p class="text-sm text-gray-600 flex items-center">
                                                        <i class='bx bx-id-card mr-1'></i>
                                                        C.I: {{ number_format($asistente->cedula, 0, '.', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if($asistente->pivot->es_concejal)
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 shadow-sm">
                                                        <i class='bx bx-crown mr-1'></i>
                                                        Concejal Responsable
                                                    </span>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class='bx bx-user mr-1'></i>
                                                    Participante
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Councilor Summary -->
                                @if($reunion->concejal())
                                    <div class="mt-6 p-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                                                <i class='bx bx-crown text-white text-xl'></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-yellow-800 mb-1">Concejal Responsable</h4>
                                                <p class="text-yellow-700 font-semibold">{{ $reunion->concejal()->nombre }} {{ $reunion->concejal()->apellido }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                        <i class='bx bx-user-x text-4xl text-gray-400'></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">No hay participantes</h3>
                                    <p class="text-gray-500 mb-6">Esta reunión no tiene participantes registrados.</p>
                                    <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition-all duration-200">
                                        <i class='bx bx-plus mr-2'></i>
                                        Agregar Participantes
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Styles -->
    <style>
        /* Custom animations */
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
        .animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            .print-optimized {
                background: white !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
        }
        
        /* Enhanced hover effects */
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .grid-cols-1.md\\:grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .space-x-4 > *:not(:first-child) {
                margin-left: 0.75rem;
            }
        }
        
        @media (max-width: 640px) {
            .grid-cols-1.md\\:grid-cols-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            initializeAnimations();
            initializeInteractiveFeatures();
            
            // ===== ANIMATION SYSTEM =====
            function initializeAnimations() {
                // Animate cards on load
                const cards = document.querySelectorAll('.bg-white\\/90, .bg-gradient-to-br');
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.6s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
                
                // Animate stats counters
                animateCounters();
            }
            
            function animateCounters() {
                const counters = document.querySelectorAll('.text-xl.font-bold');
                counters.forEach(counter => {
                    const target = parseInt(counter.textContent) || 0;
                    if (target > 0) {
                        let current = 0;
                        const increment = target / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = target;
                                clearInterval(timer);
                            } else {
                                counter.textContent = Math.floor(current);
                            }
                        }, 50);
                    }
                });
            }
            
            // ===== INTERACTIVE FEATURES =====
            function initializeInteractiveFeatures() {
                // Add hover effects
                addHoverEffects();
                
                // Initialize keyboard shortcuts
                initializeKeyboardShortcuts();
                
                // Add copy to clipboard functionality
                addCopyToClipboard();
            }
            
            function addHoverEffects() {
                const cards = document.querySelectorAll('.bg-gradient-to-br, .bg-white\\/90');
                cards.forEach(card => {
                    card.classList.add('hover-lift');
                    card.addEventListener('mouseenter', function() {
                        this.style.transition = 'all 0.3s ease';
                    });
                });
            }
            
            function initializeKeyboardShortcuts() {
                document.addEventListener('keydown', function(e) {
                    // Ctrl + E to edit
                    if (e.ctrlKey && e.key === 'e') {
                        e.preventDefault();
                        window.location.href = '{{ route('dashboard.reuniones.edit', $reunion) }}';
                    }
                    
                    // Ctrl + P to print
                    if (e.ctrlKey && e.key === 'p') {
                        e.preventDefault();
                        printMeeting();
                    }
                    
                    // Escape to go back
                    if (e.key === 'Escape') {
                        window.location.href = '{{ route('dashboard.reuniones.index') }}';
                    }
                });
            }
            
            function addCopyToClipboard() {
                // Add copy buttons to important information
                const copyButtons = document.querySelectorAll('[data-copy]');
                copyButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const text = this.dataset.copy;
                        navigator.clipboard.writeText(text).then(() => {
                            showToast('Copiado al portapapeles', 'success');
                        });
                    });
                });
            }
        });
        
        // ===== UTILITY FUNCTIONS =====
        function printMeeting() {
            // Add print-specific styling
            document.body.classList.add('printing');
            
            Swal.fire({
                title: 'Preparando impresión...',
                text: 'Generando vista optimizada para impresión',
                icon: 'info',
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
                didClose: () => {
                    window.print();
                    document.body.classList.remove('printing');
                }
            });
        }
        
        function openMaps(location) {
            const googleMapsUrl = `https://maps.google.com/maps?q=${location}`;
            window.open(googleMapsUrl, '_blank');
        }
        
        function showToast(message, type = 'info', duration = 3000) {
            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: duration,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            toast.fire({
                icon: type,
                title: message
            });
        }
        
        // Add floating effect to main icon
        const mainIcon = document.querySelector('.rotate-3');
        if (mainIcon) {
            mainIcon.classList.add('animate-float');
        }
    </script>
</x-layouts.rbac>