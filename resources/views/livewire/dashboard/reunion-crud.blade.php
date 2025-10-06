<div class="min-h-screen bg-gray-50">
    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex border-b border-gray-200">
            <button wire:click="setActiveTab('list')" 
                    class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'list' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class='bx bx-list-ul mr-2'></i>
                Lista de Reuniones
            </button>
            
            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                <button wire:click="setActiveTab('create')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'create' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <i class='bx bx-plus mr-2'></i>
                    Nueva Reunión
                </button>
            @endif
        </div>
    </div>

    <!-- Content -->
    @if($activeTab === 'list')
        <!-- Reuniones List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">
                        @if(Auth::user()->isSuperAdministrador())
                            Todas las Reuniones
                        @elseif(Auth::user()->isAdministrador())
                            Gestión de Reuniones
                        @else
                            Mis Reuniones
                        @endif
                    </h2>
                    <span class="text-sm text-gray-500">{{ $reuniones->count() }} reuniones</span>
                </div>

                @if($reuniones->isEmpty())
                    <div class="text-center py-8">
                        <i class='bx bx-calendar-x text-4xl text-gray-400 mb-4'></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reuniones</h3>
                        <p class="text-gray-500">
                            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                Crea la primera reunión para comenzar a gestionar las actividades municipales
                            @else
                                No se han programado reuniones relacionadas a tus solicitudes
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reunión
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Solicitud
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Institución
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha & Hora
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Asistentes
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reuniones as $reunion)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reunion->titulo }}
                                                </div>
                                                @if($reunion->ubicacion)
                                                    <div class="text-sm text-gray-500">
                                                        <i class='bx bx-map-pin mr-1'></i>{{ $reunion->ubicacion }}
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
                                                    <i class='bx bx-group mr-1'></i>{{ $reunion->asistentes->count() }} personas
                                                </span>
                                                @php
                                                    $concejal = $reunion->asistentes->where('pivot.es_concejal', true)->first();
                                                @endphp
                                                @if($concejal)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class='bx bx-star mr-1'></i>Concejal
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- View Button -->
                                                <button wire:click="viewReunion({{ $reunion->id }})" 
                                                        class="text-blue-600 hover:text-blue-900">
                                                    <i class='bx bx-show'></i>
                                                </button>
                                                
                                                <!-- Edit Button -->
                                                @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                                    <button wire:click="editReunion({{ $reunion->id }})" 
                                                            class="text-blue-600 hover:text-blue-900">
                                                        <i class='bx bx-edit'></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Delete Button -->
                                                @if(Auth::user()->isSuperAdministrador())
                                                    <button wire:click="deleteReunion({{ $reunion->id }})" 
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta reunión?')"
                                                            class="text-red-600 hover:text-red-900">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($activeTab === 'create')
        <!-- Create New Reunion -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Nueva Reunión</h2>
                
                <form wire:submit.prevent="createReunion">
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                                <input type="text" wire:model="titulo" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Título de la reunión">
                                @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora *</label>
                                <input type="datetime-local" wire:model="fecha_reunion" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('fecha_reunion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Solicitud *</label>
                                <select wire:model="solicitud_id" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una solicitud</option>
                                    @foreach($solicitudes as $solicitud)
                                        <option value="{{ $solicitud->id }}">{{ $solicitud->titulo }} ({{ $solicitud->solicitud_id }})</option>
                                    @endforeach
                                </select>
                                @error('solicitud_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Institución *</label>
                                <select wire:model="institucion_id" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una institución</option>
                                    @foreach($instituciones as $institucion)
                                        <option value="{{ $institucion->id }}">{{ $institucion->titulo }}</option>
                                    @endforeach
                                </select>
                                @error('institucion_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación *</label>
                            <input type="text" wire:model="ubicacion" 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Lugar donde se realizará la reunión">
                            @error('ubicacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea wire:model="descripcion" rows="3" 
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Descripción de la reunión (opcional)"></textarea>
                            @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Asistentes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asistentes *</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-4">
                                @foreach($personas as $persona)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="asistentes" value="{{ $persona->cedula }}" 
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">{{ $persona->nombre }} {{ $persona->apellido }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('asistentes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if(count($asistentes) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Concejal *</label>
                                <select wire:model="concejal" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona el concejal</option>
                                    @foreach($asistentes as $cedula)
                                        @php
                                            $persona = $personas->firstWhere('cedula', $cedula);
                                        @endphp
                                        @if($persona)
                                            <option value="{{ $cedula }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('concejal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                        <button type="button" wire:click="setActiveTab('list')" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Crear Reunión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($activeTab === 'edit' && $editingReunion)
        <!-- Edit Reunion -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Editar Reunión</h2>
                
                <form wire:submit.prevent="updateReunion">
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                                <input type="text" wire:model="titulo" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora *</label>
                                <input type="datetime-local" wire:model="fecha_reunion" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('fecha_reunion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Solicitud *</label>
                                <select wire:model="solicitud_id" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una solicitud</option>
                                    @foreach($solicitudes as $solicitud)
                                        <option value="{{ $solicitud->id }}">{{ $solicitud->titulo }} ({{ $solicitud->solicitud_id }})</option>
                                    @endforeach
                                </select>
                                @error('solicitud_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Institución *</label>
                                <select wire:model="institucion_id" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una institución</option>
                                    @foreach($instituciones as $institucion)
                                        <option value="{{ $institucion->id }}">{{ $institucion->titulo }}</option>
                                    @endforeach
                                </select>
                                @error('institucion_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación *</label>
                            <input type="text" wire:model="ubicacion" 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('ubicacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea wire:model="descripcion" rows="3" 
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Asistentes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asistentes *</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-4">
                                @foreach($personas as $persona)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="asistentes" value="{{ $persona->cedula }}" 
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">{{ $persona->nombre }} {{ $persona->apellido }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('asistentes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if(count($asistentes) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Concejal *</label>
                                <select wire:model="concejal" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona el concejal</option>
                                    @foreach($asistentes as $cedula)
                                        @php
                                            $persona = $personas->firstWhere('cedula', $cedula);
                                        @endphp
                                        @if($persona)
                                            <option value="{{ $cedula }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('concejal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                        <button type="button" wire:click="setActiveTab('list')" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Actualizar Reunión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal for viewing reunion -->
    @if($showingModal && $selectedReunion)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-screen overflow-y-auto m-4">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Detalles de la Reunión</h2>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->titulo }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->fecha_reunion->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solicitud</label>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    {{ $selectedReunion->solicitud->titulo ?? 'N/A' }}
                                    @if($selectedReunion->solicitud)
                                        <br><span class="text-sm text-gray-500">ID: {{ $selectedReunion->solicitud->solicitud_id }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Institución</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->institucion->titulo ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->ubicacion }}</div>
                        </div>

                        @if($selectedReunion->descripcion)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->descripcion }}</div>
                            </div>
                        @endif

                        <!-- Asistentes -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Asistentes ({{ $selectedReunion->asistentes->count() }})</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($selectedReunion->asistentes as $asistente)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $asistente->nombre }} {{ $asistente->apellido }}</div>
                                            <div class="text-sm text-gray-500">{{ $asistente->cedula }}</div>
                                        </div>
                                        @if($asistente->pivot->es_concejal)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class='bx bx-star mr-1'></i>Concejal
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>