<div class="min-h-screen bg-gray-50">
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-group text-white text-xl'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Reuniones</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if($activeTab !== 'create' && Auth::user()->isSuperAdministrador())
                        <button wire:click="createReunion" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Reunión
                        </button>
                    @endif
                    @if($activeTab !== 'list' && count($reuniones) > 0)
                        <button wire:click="setActiveTab('list')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Ver Reuniones
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation -->
    @if($deleteReunion)
        <div class="fixed inset-0 bg-black/10 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class='bx bx-trash text-red-600 text-xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h3>
                            <p class="text-sm text-gray-600">Esta acción no se puede deshacer</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-6">
                        ¿Estás seguro de que deseas eliminar esta reunión? Se perderán todos los datos asociados.
                    </p>
                    <p class="text-sm text-gray-400">Reunión: {{ $deleteReunion->titulo }}</p>
                    
                    <div class="flex justify-end space-x-4 mt-6">
                        <button wire:click="cancelDelete" 
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="deleteReunionDefinitive" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($activeTab === 'list')
            <!-- Reuniones List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl max-md:text-md font-semibold text-gray-900">
                        <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                        @if(Auth::user()->isSuperAdministrador())
                            Todas las Reuniones
                        @elseif(Auth::user()->isAdministrador())
                            Reuniones (Solo Lectura)
                        @endif
                    </h2>
                    <div class="flex items-center justify-end space-x-2">
                        <div class="relative w-full sm:w-auto">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar reunión..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                @if (session()->has('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-x-circle text-red-600 text-xl mr-3'></i>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('titulo')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-group'></i>
                                            Reunión
                                        </div>
                                        @if ($sort == 'titulo')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('solicitud_id')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-file-blank'></i>
                                            Solicitud
                                        </div>
                                        @if ($sort == 'solicitud_id')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('fecha_reunion')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-calendar'></i>
                                            Fecha
                                        </div>
                                        @if ($sort == 'fecha_reunion')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('institucion_id')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-buildings'></i>
                                            Institución
                                        </div>
                                        @if ($sort == 'institucion_id')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex justify-start items-center">
                                        <i class='bx bx-user-circle'></i>
                                        Asistentes
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex justify-start items-center">
                                        <i class='bx bx-cog'></i>
                                        Acciones
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reuniones as $reunion)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 w-60 truncate" title="{{ $reunion->titulo }}">
                                                {{ $reunion->titulo }}
                                            </div>
                                            @if($reunion->ubicacion)
                                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                                    <i class='bx bx-map-pin mr-1 text-red-500'></i>
                                                    {{ Str::limit($reunion->ubicacion, 40) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ Str::limit($reunion->solicitud->titulo ?? 'N/A', 40) }}
                                            </div>
                                            @if($reunion->solicitud)
                                                <div class="inline-flex items-center text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full mt-1">
                                                    <i class='bx bx-hash mr-1'></i>
                                                    {{ $reunion->solicitud->solicitud_id }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="text-sm font-medium">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $reunion->fecha_reunion->format('H:i') }}</div>
                                        @if($reunion->fecha_reunion->isToday())
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium mt-1 inline-block">HOY</span>
                                        @elseif($reunion->fecha_reunion->isFuture())
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium mt-1 inline-block">PRÓXIMA</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ Str::limit($reunion->institucion->titulo ?? 'N/A', 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                                <i class='bx bx-user mr-1'></i>
                                                {{ $reunion->asistentes->count() }}
                                            </span>
                                            @if($reunion->concejal())
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <i class='bx bx-crown mr-1'></i>
                                                    Concejal
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- View Button -->
                                            <button wire:click="viewReunion({{ $reunion->id }})" 
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Ver detalles">
                                                <i class='bx bx-show'></i>
                                            </button>
                                            
                                            <!-- Edit Button -->
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="editReunion({{ $reunion->id }})" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="Editar">
                                                    <i class='bx bx-edit'></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Delete Button -->
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="confirmDelete({{ $reunion->id }})"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Eliminar">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            @endif

                                            <!-- PDF Button -->
                                            <a href="{{ route('dashboard.reuniones.pdf', $reunion) }}" 
                                            class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                            title="Descargar PDF" target="_blank">
                                                <i class='bx bx-download'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($reuniones->isEmpty())
                        <div class="text-center py-8">
                            <i class='bx bx-group text-4xl text-gray-400 mb-4'></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reuniones</h3>
                            <p class="text-gray-500">
                                No se encontraron reuniones en el sistema
                            </p>
                        </div>
                    @else
                        <div class="mx-5">
                            {{ $reuniones->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($activeTab === 'create' || $activeTab === 'edit')
            <!-- Create/Edit Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $editingReunion ? 'Editar Reunión' : 'Nueva Reunión' }}
                            </h2>
                            <div class="flex items-center space-x-2">
                                @if($editingReunion)
                                    <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-edit mr-1'></i>
                                        Editando
                                    </div>
                                @else
                                    <div class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-plus mr-1'></i>
                                        Creando
                                    </div>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600">Complete todos los campos requeridos para {{ $editingReunion ? 'actualizar' : 'crear' }} la reunión</p>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-8">
                        
                        <!-- Información Básica -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-info-circle text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Información Básica</h3>
                                    <p class="text-sm text-gray-600">Datos principales de la reunión</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2 bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Título de la Reunión *</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-edit-alt text-blue-600 mr-2'></i>
                                        <input type="text" wire:model="titulo" class="font-medium text-gray-900 focus:outline-none w-full" placeholder="Escribir título de la reunión...">
                                    </div>
                                    @error('titulo') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora *</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-calendar text-blue-600 mr-2'></i>
                                        <input type="datetime-local" wire:model="fecha_reunion" class="font-medium text-gray-900 focus:outline-none w-full" min="{{ date('Y-m-d\TH:i') }}">
                                    </div>
                                    @error('fecha_reunion') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-map-pin text-blue-600 mr-2'></i>
                                        <input type="text" wire:model="ubicacion" class="font-medium text-gray-900 focus:outline-none w-full" placeholder="Escribir ubicación...">
                                    </div>
                                    @error('ubicacion') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Relaciones -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-link-alt text-green-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Relaciones</h3>
                                    <p class="text-sm text-gray-600">Vincule con solicitudes e instituciones</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Solicitud Asociada *</label>
                                    <select wire:model="solicitud_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Seleccione una solicitud...</option>
                                        @foreach($solicitudes as $id => $titulo)
                                            <option value="{{ $id }}">{{ Str::limit($titulo, 60) }}</option>
                                        @endforeach
                                    </select>
                                    @error('solicitud_id') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Institución Responsable *</label>
                                    <select wire:model="institucion_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Seleccione una institución...</option>
                                        @foreach($instituciones as $id => $titulo)
                                            <option value="{{ $id }}">{{ $titulo }}</option>
                                        @endforeach
                                    </select>
                                    @error('institucion_id') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2 bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                                    <textarea wire:model="descripcion" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Descripción de la reunión..."></textarea>
                                    @error('descripcion') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Participantes -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-group text-purple-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Participantes</h3>
                                    <p class="text-sm text-gray-600">Seleccione asistentes y concejal responsable</p>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg border border-gray-200 p-4">
                                <div class="max-h-60 overflow-y-auto space-y-3">
                                    @foreach($personas as $persona)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       wire:model="asistentes" 
                                                       value="{{ $persona->cedula }}" 
                                                       id="asistente_{{ $persona->cedula }}"
                                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-4">
                                                <label for="asistente_{{ $persona->cedula }}" class="cursor-pointer">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $persona->nombre }} {{ $persona->apellido }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <i class='bx bx-id-card mr-1'></i>
                                                        C.I: {{ number_format($persona->cedula, 0, '.', '.') }}
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center ml-4">
                                                <input type="radio" 
                                                       wire:model="concejal" 
                                                       value="{{ $persona->cedula }}" 
                                                       id="concejal_{{ $persona->cedula }}"
                                                       class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                                <label for="concejal_{{ $persona->cedula }}" class="ml-2 text-sm text-green-700 cursor-pointer font-medium">
                                                    <i class='bx bx-crown mr-1'></i>
                                                    Concejal
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @error('asistentes') 
                                    <div class="flex items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado de Solicitud -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-refresh text-orange-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Actualización de Estado (Opcional)</h3>
                                    <p class="text-sm text-gray-600">Actualice el estado de la solicitud asociada</p>
                                </div>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo Estado de la Solicitud</label>
                                <input type="text" wire:model="nuevo_estado_solicitud" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Ej: En proceso: Reunión programada">
                                @error('nuevo_estado_solicitud') 
                                    <div class="flex items-center text-red-600 text-sm mt-1">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <button type="button" wire:click="setActiveTab('list')" 
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                <i class='bx bx-arrow-back mr-2'></i>
                                Cancelar
                            </button>
                            
                            <button type="submit" 
                                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                                <i class='bx bx-save mr-2'></i>
                                {{ $editingReunion ? 'Actualizar Reunión' : 'Crear Reunión' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($activeTab === 'view' && $editingReunion)
            <!-- View Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- View Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $editingReunion->titulo }}</h2>
                            <p class="text-gray-600">Detalles completos de la reunión</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button wire:click="editReunion({{ $editingReunion->id }})" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class='bx bx-edit mr-2'></i>
                                Editar
                            </button>
                            <a href="{{ route('dashboard.reuniones.pdf', $editingReunion) }}" 
                               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors" target="_blank">
                                <i class='bx bx-download mr-2'></i>
                                PDF
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class='bx bx-info-circle text-blue-600 mr-2'></i>
                                    Información Básica
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Fecha y Hora</label>
                                        <p class="font-semibold text-gray-900">{{ $editingReunion->fecha_reunion->format('d/m/Y H:i') }}</p>
                                    </div>
                                    @if($editingReunion->ubicacion)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Ubicación</label>
                                            <p class="font-semibold text-gray-900">{{ $editingReunion->ubicacion }}</p>
                                        </div>
                                    @endif
                                    @if($editingReunion->descripcion)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Descripción</label>
                                            <p class="text-gray-900">{{ $editingReunion->descripcion }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Relations -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class='bx bx-link-alt text-green-600 mr-2'></i>
                                    Relaciones
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Solicitud Asociada</label>
                                        <p class="font-semibold text-gray-900">{{ $editingReunion->solicitud->titulo ?? 'N/A' }}</p>
                                        @if($editingReunion->solicitud)
                                            <p class="text-sm text-gray-500">ID: {{ $editingReunion->solicitud->solicitud_id }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Institución</label>
                                        <p class="font-semibold text-gray-900">{{ $editingReunion->institucion->titulo ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Participants -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class='bx bx-group text-purple-600 mr-2'></i>
                                    Participantes ({{ $editingReunion->asistentes->count() }})
                                </h3>
                                @if($editingReunion->asistentes->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($editingReunion->asistentes as $asistente)
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $asistente->nombre }} {{ $asistente->apellido }}</p>
                                                    <p class="text-sm text-gray-500">C.I: {{ number_format($asistente->cedula, 0, '.', '.') }}</p>
                                                </div>
                                                @if($asistente->pivot->es_concejal)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                        <i class='bx bx-crown mr-1'></i>
                                                        Concejal
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <i class='bx bx-user mr-1'></i>
                                                        Participante
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No hay participantes registrados</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-8">
                        <button wire:click="setActiveTab('list')" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Volver al Listado
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>