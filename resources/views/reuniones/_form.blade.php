@csrf

<style>
    /* Estilos personalizados para formularios reactivos */
    .form-input {
        @apply block w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-gray-900;
    }
    
    .form-input.error {
        @apply border-red-300 focus:border-red-500 focus:ring-red-200;
    }
    
    .form-input.success {
        @apply border-green-300 focus:border-green-500 focus:ring-green-200;
    }
    
    .form-group {
        @apply space-y-2;
    }
    
    .form-label {
        @apply block text-sm font-semibold text-gray-700 flex items-center;
    }
    
    .form-label.required::after {
        content: " *";
        @apply text-red-500;
    }
    
    .error-message {
        @apply text-red-600 text-sm flex items-center space-x-1;
    }
    
    .success-message {
        @apply text-green-600 text-sm flex items-center space-x-1;
    }
    
    .checkbox-custom, .radio-custom {
        @apply w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200;
    }
    
    .radio-custom {
        @apply rounded-full;
    }
</style>

<div class="space-y-8">
    <!-- Información Básica -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                <i class='bx bx-info-circle text-white'></i>
            </div>
            Información Básica de la Reunión
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Título -->
            <div class="form-group lg:col-span-2">
                <label for="titulo" class="form-label required">
                    <i class='bx bx-edit-alt mr-2 text-blue-600'></i>
                    Título de la Reunión
                </label>
                <input type="text" 
                       name="titulo" 
                       id="titulo" 
                       value="{{ old('titulo', $reunion->titulo ?? '') }}" 
                       class="form-input {{ $errors->has('titulo') ? 'error' : '' }}"
                       placeholder="Ej: Reunión de seguimiento sobre solicitud de agua potable"
                       required
                       maxlength="255">
                @error('titulo')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Ingrese un título descriptivo para la reunión</p>
                @enderror
            </div>

            <!-- Fecha de Reunión -->
            <div class="form-group">
                <label for="fecha_reunion" class="form-label required">
                    <i class='bx bx-calendar mr-2 text-blue-600'></i>
                    Fecha y Hora de la Reunión
                </label>
                <input type="datetime-local" 
                       name="fecha_reunion" 
                       id="fecha_reunion" 
                       value="{{ old('fecha_reunion', isset($reunion) ? $reunion->fecha_reunion->format('Y-m-d\TH:i') : '') }}" 
                       class="form-input {{ $errors->has('fecha_reunion') ? 'error' : '' }}"
                       required
                       min="{{ date('Y-m-d\TH:i') }}">
                @error('fecha_reunion')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Seleccione fecha y hora futura</p>
                @enderror
            </div>

            <!-- Ubicación -->
            <div class="form-group">
                <label for="ubicacion" class="form-label">
                    <i class='bx bx-map-pin mr-2 text-blue-600'></i>
                    Ubicación
                </label>
                <input type="text" 
                       name="ubicacion" 
                       id="ubicacion" 
                       value="{{ old('ubicacion', $reunion->ubicacion ?? '') }}" 
                       class="form-input {{ $errors->has('ubicacion') ? 'error' : '' }}"
                       placeholder="Ej: Sala de reuniones - Edificio Municipal"
                       maxlength="255">
                @error('ubicacion')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Especifique el lugar donde se realizará la reunión</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Relaciones -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                <i class='bx bx-link-alt text-white'></i>
            </div>
            Relaciones y Contexto
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Solicitud Asociada -->
            <div class="form-group">
                <label for="solicitud_id" class="form-label required">
                    <i class='bx bx-file-blank mr-2 text-green-600'></i>
                    Solicitud Asociada
                </label>
                <div class="relative">
                    <select name="solicitud_id" 
                            id="solicitud_id" 
                            class="form-input {{ $errors->has('solicitud_id') ? 'error' : '' }}"
                            required>
                        <option value="">Seleccione una solicitud...</option>
                        @foreach($solicitudes as $id => $titulo)
                            <option value="{{ $id }}" {{ (old('solicitud_id', $reunion->solicitud_id ?? '') == $id) ? 'selected' : '' }}>
                                {{ Str::limit($titulo, 60) }}
                            </option>
                        @endforeach
                    </select>
                    <i class='bx bx-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none'></i>
                </div>
                @error('solicitud_id')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Seleccione la solicitud que originó esta reunión</p>
                @enderror
            </div>

            <!-- Institución Responsable -->
            <div class="form-group">
                <label for="institucion_id" class="form-label required">
                    <i class='bx bx-buildings mr-2 text-green-600'></i>
                    Institución Responsable
                </label>
                <div class="relative">
                    <select name="institucion_id" 
                            id="institucion_id" 
                            class="form-input {{ $errors->has('institucion_id') ? 'error' : '' }}"
                            required>
                        <option value="">Seleccione una institución...</option>
                        @foreach($instituciones as $id => $titulo)
                            <option value="{{ $id }}" {{ (old('institucion_id', $reunion->institucion_id ?? '') == $id) ? 'selected' : '' }}>
                                {{ $titulo }}
                            </option>
                        @endforeach
                    </select>
                    <i class='bx bx-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none'></i>
                </div>
                @error('institucion_id')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Institución que coordinará la reunión</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="form-group lg:col-span-2">
                <label for="descripcion" class="form-label">
                    <i class='bx bx-detail mr-2 text-green-600'></i>
                    Descripción y Objetivos
                </label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          rows="4" 
                          class="form-input {{ $errors->has('descripcion') ? 'error' : '' }}"
                          placeholder="Describa los objetivos, agenda y temas a tratar en la reunión...">{{ old('descripcion', $reunion->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <p class="text-gray-500 text-xs mt-1">Detalles opcionales sobre la reunión</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Asistentes -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                <i class='bx bx-group text-white'></i>
            </div>
            Participantes de la Reunión
        </h3>
        
        <div class="form-group">
            <div class="bg-white rounded-lg border-2 border-gray-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <label class="form-label">
                        <i class='bx bx-user-check mr-2 text-purple-600'></i>
                        Seleccionar Asistentes
                    </label>
                    <div class="flex items-center space-x-4 text-xs">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-100 border-2 border-blue-300 rounded mr-2"></div>
                            <span class="text-gray-600">Asistente</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-100 border-2 border-green-300 rounded-full mr-2"></div>
                            <span class="text-gray-600">Concejal</span>
                        </div>
                    </div>
                </div>
                
                <div class="max-h-64 overflow-y-auto space-y-2">
                    @foreach($personas as $persona)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <div class="flex items-center flex-1">
                                <input type="checkbox" 
                                       name="asistentes[]" 
                                       value="{{ $persona->cedula }}" 
                                       id="asistente_{{ $persona->cedula }}"
                                       class="checkbox-custom mr-4"
                                       {{ (isset($reunion) && $reunion->asistentes->contains('cedula', $persona->cedula)) ? 'checked' : '' }}>
                                <label for="asistente_{{ $persona->cedula }}" class="cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900">
                                        {{ $persona->nombre }} {{ $persona->apellido }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        C.I: {{ number_format($persona->cedula, 0, '.', '.') }}
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center ml-4">
                                <input type="radio" 
                                       name="concejal" 
                                       value="{{ $persona->cedula }}" 
                                       id="concejal_{{ $persona->cedula }}"
                                       class="radio-custom text-green-600 focus:ring-green-500"
                                       {{ (isset($reunion) && $reunion->concejal() && $reunion->concejal()->cedula === $persona->cedula) ? 'checked' : '' }}>
                                <label for="concejal_{{ $persona->cedula }}" class="ml-2 text-sm text-green-700 cursor-pointer font-medium">
                                    Concejal
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800 flex items-center">
                        <i class='bx bx-info-circle mr-2'></i>
                        Seleccione los participantes y designe uno como Concejal responsable
                    </p>
                </div>
            </div>
            
            @error('asistentes')
                <div class="error-message">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
            @error('concejal')
                <div class="error-message">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <!-- Estado de Solicitud -->
    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center mr-3">
                <i class='bx bx-refresh text-white'></i>
            </div>
            Actualización de Estado (Opcional)
        </h3>
        
        <div class="form-group">
            <label for="nuevo_estado_solicitud" class="form-label">
                <i class='bx bx-edit mr-2 text-orange-600'></i>
                Nuevo Estado de la Solicitud
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class='bx bx-sync text-gray-400'></i>
                </div>
                <input type="text" 
                       name="nuevo_estado_solicitud" 
                       id="nuevo_estado_solicitud" 
                       class="form-input pl-10 {{ $errors->has('nuevo_estado_solicitud') ? 'error' : '' }}"
                       placeholder="Ej: En proceso: Reunión programada para seguimiento"
                       value="{{ old('nuevo_estado_solicitud') }}"
                       maxlength="255">
            </div>
            @error('nuevo_estado_solicitud')
                <div class="error-message">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ $message }}</span>
                </div>
            @else
                <p class="text-gray-500 text-xs mt-1">
                    <i class='bx bx-lightbulb mr-1'></i>
                    Si completa este campo, se actualizará automáticamente el estado de la solicitud asociada
                </p>
            @enderror
        </div>
    </div>
</div>

<div class="py-4 text-right">
    <a href="{{ route('dashboard.reuniones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Cancelar
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $submitButtonText ?? 'Guardar' }}
    </button>
</div>