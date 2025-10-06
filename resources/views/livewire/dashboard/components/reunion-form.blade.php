<!-- Main Form Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="p-8">
        <!-- Step 1: Basic Information -->
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <i class='bx bx-info-circle text-blue-600 text-xl'></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Información Básica</h2>
                    <p class="text-gray-600">Datos principales de la reunión</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Título de la Reunión *</label>
                    <input type="text" wire:model="titulo" 
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Ej: Reunión de seguimiento sobre solicitud de agua potable">
                    @error('titulo') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Fecha y Hora -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha y Hora *</label>
                    <input type="datetime-local" wire:model="fecha_reunion" 
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           min="{{ date('Y-m-d\TH:i') }}">
                    @error('fecha_reunion') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ubicación</label>
                    <input type="text" wire:model="ubicacion" 
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Ej: Sala de reuniones - Edificio Municipal">
                    @error('ubicacion') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                    <textarea wire:model="descripcion" rows="3" 
                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                              placeholder="Descripción de la reunión (opcional)"></textarea>
                    @error('descripcion') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Step 2: Relations -->
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <i class='bx bx-link-alt text-green-600 text-xl'></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Relaciones y Contexto</h2>
                    <p class="text-gray-600">Vincule la reunión con solicitudes e instituciones</p>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Solicitud -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Solicitud Asociada *</label>
                        <select wire:model="solicitud_id" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Seleccione una solicitud...</option>
                            @foreach($solicitudes as $solicitud)
                                <option value="{{ $solicitud->id }}">{{ $solicitud->titulo }} ({{ $solicitud->solicitud_id }})</option>
                            @endforeach
                        </select>
                        @error('solicitud_id') 
                            <div class="flex items-center text-red-600 text-sm mt-2">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Institución -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Institución Responsable *</label>
                        <select wire:model="institucion_id" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Seleccione una institución...</option>
                            @foreach($instituciones as $institucion)
                                <option value="{{ $institucion->id }}">{{ $institucion->titulo }}</option>
                            @endforeach
                        </select>
                        @error('institucion_id') 
                            <div class="flex items-center text-red-600 text-sm mt-2">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Participants -->
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                    <i class='bx bx-group text-purple-600 text-xl'></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Participantes de la Reunión</h2>
                    <p class="text-gray-600">Seleccione asistentes y designe un concejal responsable</p>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <!-- Lista de participantes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-white">
                    @foreach($personas as $persona)
                        <label class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 cursor-pointer">
                            <input type="checkbox" wire:model="asistentes" value="{{ $persona->cedula }}" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $persona->nombre }} {{ $persona->apellido }}</div>
                                <div class="text-xs text-gray-500">C.I: {{ number_format($persona->cedula, 0, '.', '.') }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('asistentes') 
                    <div class="flex items-center text-red-600 text-sm mt-2">
                        <i class='bx bx-error-circle mr-1'></i>
                        {{ $message }}
                    </div>
                @enderror

                @if(count($asistentes) > 0)
                    <!-- Concejal Selection -->
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Concejal Responsable</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($asistentes as $cedula)
                                @php
                                    $persona = $personas->firstWhere('cedula', $cedula);
                                @endphp
                                @if($persona)
                                    <label class="flex items-center p-3 rounded-lg border border-green-200 bg-green-50 cursor-pointer hover:bg-green-100 transition-colors">
                                        <input type="radio" wire:model="concejal" value="{{ $cedula }}" 
                                               class="text-green-600 focus:ring-green-500">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-green-900">{{ $persona->nombre }} {{ $persona->apellido }}</div>
                                            <div class="text-xs text-green-700">
                                                <i class='bx bx-crown mr-1'></i>
                                                Designar como concejal
                                            </div>
                                        </div>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        @error('concejal') 
                            <div class="flex items-center text-red-600 text-sm mt-2">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
            </div>
        </div>

        <!-- Step 4: Optional Status Update -->
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                    <i class='bx bx-refresh text-orange-600 text-xl'></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Actualización de Estado</h2>
                    <p class="text-gray-600">Opcional: Actualice el estado de la solicitud asociada</p>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nuevo Estado de la Solicitud</label>
                    <input type="text" wire:model="nuevo_estado_solicitud" 
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Ej: En proceso: Reunión programada para seguimiento">
                    
                    <!-- Estados sugeridos -->
                    <div class="mt-3">
                        <p class="text-xs text-gray-600 mb-2">Estados comunes:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" 
                                    onclick="document.querySelector('input[wire\\:model=\"nuevo_estado_solicitud\"]').value = 'En proceso: Reunión programada'; @this.set('nuevo_estado_solicitud', 'En proceso: Reunión programada')"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                                En proceso: Reunión programada
                            </button>
                            <button type="button" 
                                    onclick="document.querySelector('input[wire\\:model=\"nuevo_estado_solicitud\"]').value = 'Evaluación: En reunión técnica'; @this.set('nuevo_estado_solicitud', 'Evaluación: En reunión técnica')"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                                Evaluación: En reunión técnica
                            </button>
                            <button type="button" 
                                    onclick="document.querySelector('input[wire\\:model=\"nuevo_estado_solicitud\"]').value = 'Seguimiento: Reunión de coordinación'; @this.set('nuevo_estado_solicitud', 'Seguimiento: Reunión de coordinación')"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                                Seguimiento: Reunión de coordinación
                            </button>
                        </div>
                    </div>
                    
                    @error('nuevo_estado_solicitud') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <div class="mt-3 p-3 bg-yellow-100 rounded-lg border border-yellow-300">
                        <p class="text-sm text-yellow-800 flex items-start">
                            <i class='bx bx-lightbulb mr-2 mt-0.5'></i>
                            <span>Si completa este campo, se actualizará automáticamente el estado detallado de la solicitud asociada cuando se guarde la reunión.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center pt-8 border-t border-gray-200">
            <button type="button" wire:click="setActiveTab('list')" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                <i class='bx bx-arrow-back mr-2'></i>
                Cancelar
            </button>

            <div class="flex items-center space-x-4">
                <button type="button" wire:click="resetForm" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    <i class='bx bx-refresh mr-2'></i>
                    Reiniciar Formulario
                </button>
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                    <i class='bx bx-check mr-2'></i>
                    {{ isset($isEditing) && $isEditing ? 'Actualizar Reunión' : 'Crear Reunión' }}
                </button>
            </div>
        </div>
    </div>
</div>