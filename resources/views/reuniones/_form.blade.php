@csrf

<style>
    /* Estilos personalizados para formularios reactivos */
    .form-input {
        @apply block w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-gray-900 bg-white;
    }
    
    .form-input.error {
        @apply border-red-300 focus:border-red-500 focus:ring-red-200 bg-red-50;
    }
    
    .form-input.success {
        @apply border-green-300 focus:border-green-500 focus:ring-green-200 bg-green-50;
    }
    
    .form-input.loading {
        @apply border-yellow-300 bg-yellow-50;
    }
    
    .form-group {
        @apply space-y-3;
    }
    
    .form-label {
        @apply block text-sm font-semibold text-gray-700 flex items-center;
    }
    
    .form-label.required::after {
        content: " *";
        @apply text-red-500 ml-1;
    }
    
    .error-message {
        @apply text-red-600 text-sm flex items-center space-x-1 mt-2;
    }
    
    .success-message {
        @apply text-green-600 text-sm flex items-center space-x-1 mt-2;
    }
    
    .warning-message {
        @apply text-yellow-600 text-sm flex items-center space-x-1 mt-2;
    }
    
    .checkbox-custom, .radio-custom {
        @apply w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200;
    }
    
    .radio-custom {
        @apply rounded-full;
    }
    
    .card-section {
        @apply bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 transition-all duration-200 hover:shadow-md;
    }
    
    .section-header {
        @apply flex items-center mb-6 pb-4 border-b border-gray-100;
    }
    
    .section-icon {
        @apply w-12 h-12 rounded-full flex items-center justify-center mr-4 shadow-lg;
    }
    
    .field-counter {
        @apply text-xs text-gray-400 mt-1;
    }
    
    .input-icon {
        @apply absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none;
    }
    
    .select-wrapper {
        @apply relative;
    }
    
    .select-wrapper::after {
        content: '';
        @apply absolute right-3 top-1/2 transform -translate-y-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-400 pointer-events-none;
    }
    
    .participant-card {
        @apply flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 cursor-pointer;
    }
    
    .participant-card.selected {
        @apply bg-blue-50 border-blue-300;
    }
    
    .participant-card.concejal {
        @apply bg-green-50 border-green-300;
    }
</style>

<div class="space-y-6">
    <!-- Información Básica -->
    <div class="card-section">
        <div class="section-header">
            <div class="section-icon bg-gradient-to-r from-blue-500 to-blue-600">
                <i class='bx bx-info-circle text-white text-xl'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Información Básica</h3>
                <p class="text-sm text-gray-600">Datos principales de la reunión</p>
            </div>
            <div class="ml-auto">
                <div id="basic-info-status" class="w-3 h-3 rounded-full bg-gray-300"></div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Título -->
            <div class="form-group lg:col-span-2">
                <label for="titulo" class="form-label required">
                    <i class='bx bx-edit-alt mr-2 text-blue-600'></i>
                    Título de la Reunión
                </label>
                <div class="relative">
                    <input type="text" 
                           name="titulo" 
                           id="titulo" 
                           value="{{ old('titulo', $reunion->titulo ?? '') }}" 
                           class="form-input {{ $errors->has('titulo') ? 'error' : '' }}"
                           placeholder="Ej: Reunión de seguimiento sobre solicitud de agua potable"
                           required
                           maxlength="255"
                           data-validation="required|min:5|max:255">
                    <div id="titulo-counter" class="field-counter text-right">0/255</div>
                </div>
                <div id="titulo-messages" class="validation-messages">
                    @error('titulo')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Ingrese un título descriptivo y claro para la reunión</p>
                    @enderror
                </div>
            </div>

            <!-- Fecha de Reunión -->
            <div class="form-group">
                <label for="fecha_reunion" class="form-label required">
                    <i class='bx bx-calendar mr-2 text-blue-600'></i>
                    Fecha y Hora de la Reunión
                </label>
                <div class="relative">
                    <input type="datetime-local" 
                           name="fecha_reunion" 
                           id="fecha_reunion" 
                           value="{{ old('fecha_reunion', isset($reunion) ? $reunion->fecha_reunion->format('Y-m-d\TH:i') : '') }}" 
                           class="form-input {{ $errors->has('fecha_reunion') ? 'error' : '' }}"
                           required
                           min="{{ date('Y-m-d\TH:i') }}"
                           data-validation="required|future">
                </div>
                <div id="fecha_reunion-messages" class="validation-messages">
                    @error('fecha_reunion')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Debe ser una fecha y hora futura</p>
                    @enderror
                </div>
            </div>

            <!-- Ubicación -->
            <div class="form-group">
                <label for="ubicacion" class="form-label">
                    <i class='bx bx-map-pin mr-2 text-blue-600'></i>
                    Ubicación
                </label>
                <div class="relative">
                    <i class='bx bx-map input-icon'></i>
                    <input type="text" 
                           name="ubicacion" 
                           id="ubicacion" 
                           value="{{ old('ubicacion', $reunion->ubicacion ?? '') }}" 
                           class="form-input pl-10 {{ $errors->has('ubicacion') ? 'error' : '' }}"
                           placeholder="Ej: Sala de reuniones - Edificio Municipal"
                           maxlength="255"
                           data-validation="max:255">
                    <div id="ubicacion-counter" class="field-counter text-right">0/255</div>
                </div>
                <div id="ubicacion-messages" class="validation-messages">
                    @error('ubicacion')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Especifique dónde se realizará la reunión (opcional)</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Relaciones -->
    <div class="card-section">
        <div class="section-header">
            <div class="section-icon bg-gradient-to-r from-green-500 to-green-600">
                <i class='bx bx-link-alt text-white text-xl'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Relaciones y Contexto</h3>
                <p class="text-sm text-gray-600">Vincule la reunión con solicitudes e instituciones</p>
            </div>
            <div class="ml-auto">
                <div id="relations-status" class="w-3 h-3 rounded-full bg-gray-300"></div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Solicitud Asociada -->
            <div class="form-group">
                <label for="solicitud_id" class="form-label required">
                    <i class='bx bx-file-blank mr-2 text-green-600'></i>
                    Solicitud Asociada
                </label>
                <div class="select-wrapper">
                    <select name="solicitud_id" 
                            id="solicitud_id" 
                            class="form-input {{ $errors->has('solicitud_id') ? 'error' : '' }}"
                            required
                            data-validation="required">
                        <option value="">Seleccione una solicitud...</option>
                        @foreach($solicitudes as $id => $titulo)
                            <option value="{{ $id }}" 
                                    {{ (old('solicitud_id', $reunion->solicitud_id ?? '') == $id) ? 'selected' : '' }}
                                    data-title="{{ $titulo }}">
                                {{ Str::limit($titulo, 60) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="solicitud_id-messages" class="validation-messages">
                    @error('solicitud_id')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Seleccione la solicitud que originó esta reunión</p>
                    @enderror
                </div>
            </div>

            <!-- Institución Responsable -->
            <div class="form-group">
                <label for="institucion_id" class="form-label required">
                    <i class='bx bx-buildings mr-2 text-green-600'></i>
                    Institución Responsable
                </label>
                <div class="select-wrapper">
                    <select name="institucion_id" 
                            id="institucion_id" 
                            class="form-input {{ $errors->has('institucion_id') ? 'error' : '' }}"
                            required
                            data-validation="required">
                        <option value="">Seleccione una institución...</option>
                        @foreach($instituciones as $id => $titulo)
                            <option value="{{ $id }}" 
                                    {{ (old('institucion_id', $reunion->institucion_id ?? '') == $id) ? 'selected' : '' }}
                                    data-title="{{ $titulo }}">
                                {{ $titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="institucion_id-messages" class="validation-messages">
                    @error('institucion_id')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Institución que coordinará la reunión</p>
                    @enderror
                </div>
            </div>

            <!-- Descripción -->
            <div class="form-group lg:col-span-2">
                <label for="descripcion" class="form-label">
                    <i class='bx bx-detail mr-2 text-green-600'></i>
                    Descripción y Objetivos
                </label>
                <div class="relative">
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="4" 
                              class="form-input {{ $errors->has('descripcion') ? 'error' : '' }}"
                              placeholder="Describa los objetivos, agenda y temas a tratar en la reunión..."
                              maxlength="1000"
                              data-validation="max:1000">{{ old('descripcion', $reunion->descripcion ?? '') }}</textarea>
                    <div id="descripcion-counter" class="field-counter text-right">0/1000</div>
                </div>
                <div id="descripcion-messages" class="validation-messages">
                    @error('descripcion')
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Detalles opcionales sobre objetivos y agenda de la reunión</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Participantes -->
    <div class="card-section">
        <div class="section-header">
            <div class="section-icon bg-gradient-to-r from-purple-500 to-purple-600">
                <i class='bx bx-group text-white text-xl'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Participantes de la Reunión</h3>
                <p class="text-sm text-gray-600">Seleccione asistentes y designe un concejal responsable</p>
            </div>
            <div class="ml-auto flex items-center space-x-3">
                <div id="participants-counter" class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                    0 seleccionados
                </div>
                <div id="participants-status" class="w-3 h-3 rounded-full bg-gray-300"></div>
            </div>
        </div>
        
        <!-- Filtros y búsqueda -->
        <div class="mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class='bx bx-search input-icon'></i>
                        <input type="text" 
                               id="participants-search" 
                               class="form-input pl-10"
                               placeholder="Buscar participante por nombre o cédula...">
                    </div>
                </div>
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
        </div>
        
        <!-- Lista de participantes -->
        <div class="form-group">
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="max-h-80 overflow-y-auto space-y-3" id="participants-list">
                    @foreach($personas as $persona)
                        <div class="participant-card" 
                             data-name="{{ strtolower($persona->nombre . ' ' . $persona->apellido) }}"
                             data-cedula="{{ $persona->cedula }}"
                             id="participant-card-{{ $persona->cedula }}">
                            <div class="flex items-center flex-1">
                                <input type="checkbox" 
                                       name="asistentes[]" 
                                       value="{{ $persona->cedula }}" 
                                       id="asistente_{{ $persona->cedula }}"
                                       class="checkbox-custom mr-4 participant-checkbox"
                                       data-cedula="{{ $persona->cedula }}"
                                       {{ (isset($reunion) && $reunion->asistentes->contains('cedula', $persona->cedula)) ? 'checked' : '' }}>
                                <label for="asistente_{{ $persona->cedula }}" class="cursor-pointer flex-1">
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
                                       name="concejal" 
                                       value="{{ $persona->cedula }}" 
                                       id="concejal_{{ $persona->cedula }}"
                                       class="radio-custom text-green-600 focus:ring-green-500 concejal-radio"
                                       data-cedula="{{ $persona->cedula }}"
                                       {{ (isset($reunion) && $reunion->concejal() && $reunion->concejal()->cedula === $persona->cedula) ? 'checked' : '' }}>
                                <label for="concejal_{{ $persona->cedula }}" class="ml-2 text-sm text-green-700 cursor-pointer font-medium">
                                    <i class='bx bx-crown mr-1'></i>
                                    Concejal
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="no-participants-found" class="hidden text-center py-8">
                    <i class='bx bx-search text-gray-400 text-3xl mb-2'></i>
                    <p class="text-gray-500">No se encontraron participantes</p>
                </div>
            </div>
            
            <!-- Resumen de selección -->
            <div id="selection-summary" class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200 hidden">
                <div class="flex items-start">
                    <i class='bx bx-info-circle text-blue-600 text-xl mr-3 mt-0.5'></i>
                    <div>
                        <h4 class="font-medium text-blue-900 mb-2">Resumen de Participantes</h4>
                        <div id="selection-details" class="text-sm text-blue-800">
                            <!-- Se llena dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="participants-messages" class="validation-messages">
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
    </div>

    <!-- Estado de Solicitud -->
    <div class="card-section">
        <div class="section-header">
            <div class="section-icon bg-gradient-to-r from-orange-500 to-orange-600">
                <i class='bx bx-refresh text-white text-xl'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Actualización de Estado</h3>
                <p class="text-sm text-gray-600">Opcional: Actualice el estado de la solicitud asociada</p>
            </div>
            <div class="ml-auto">
                <div class="text-xs text-gray-500 bg-yellow-100 px-2 py-1 rounded-full">
                    Opcional
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="nuevo_estado_solicitud" class="form-label">
                <i class='bx bx-edit mr-2 text-orange-600'></i>
                Nuevo Estado de la Solicitud
            </label>
            <div class="relative">
                <i class='bx bx-sync input-icon'></i>
                <input type="text" 
                       name="nuevo_estado_solicitud" 
                       id="nuevo_estado_solicitud" 
                       class="form-input pl-10 {{ $errors->has('nuevo_estado_solicitud') ? 'error' : '' }}"
                       placeholder="Ej: En proceso: Reunión programada para seguimiento"
                       value="{{ old('nuevo_estado_solicitud') }}"
                       maxlength="255"
                       data-validation="max:255">
                <div id="nuevo_estado_solicitud-counter" class="field-counter text-right">0/255</div>
            </div>
            
            <!-- Estados sugeridos -->
            <div class="mt-3">
                <p class="text-xs text-gray-600 mb-2">Estados comunes:</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" 
                            class="status-suggestion px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors"
                            data-status="En proceso: Reunión programada">
                        En proceso: Reunión programada
                    </button>
                    <button type="button" 
                            class="status-suggestion px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors"
                            data-status="Evaluación: En reunión técnica">
                        Evaluación: En reunión técnica
                    </button>
                    <button type="button" 
                            class="status-suggestion px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors"
                            data-status="Seguimiento: Reunión de coordinación">
                        Seguimiento: Reunión de coordinación
                    </button>
                </div>
            </div>
            
            <div id="nuevo_estado_solicitud-messages" class="validation-messages">
                @error('nuevo_estado_solicitud')
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-sm text-yellow-800 flex items-start">
                            <i class='bx bx-lightbulb mr-2 mt-0.5'></i>
                            <span>Si completa este campo, se actualizará automáticamente el estado detallado de la solicitud asociada cuando se guarde la reunión.</span>
                        </p>
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- Botones de Acción -->
<div class="flex justify-between items-center pt-8 border-t border-gray-200">
    <a href="{{ route('dashboard.reuniones.index') }}" 
       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
        <i class='bx bx-arrow-back mr-2'></i>
        Cancelar
    </a>
    
    <button type="submit" 
            id="submitButton"
            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
        <i class='bx bx-save mr-2'></i>
        <span id="submitText">{{ $submitButtonText ?? 'Guardar Reunión' }}</span>
        <div id="submitSpinner" class="hidden ml-2">
            <i class='bx bx-loader bx-spin'></i>
        </div>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== CONFIGURACIÓN INICIAL =====
    const form = document.querySelector('form');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    // Elementos del formulario
    const titulo = document.getElementById('titulo');
    const fechaReunion = document.getElementById('fecha_reunion');
    const ubicacion = document.getElementById('ubicacion');
    const descripcion = document.getElementById('descripcion');
    const solicitudId = document.getElementById('solicitud_id');
    const institucionId = document.getElementById('institucion_id');
    const nuevoEstadoSolicitud = document.getElementById('nuevo_estado_solicitud');
    const participantsSearch = document.getElementById('participants-search');
    
    // Contadores y elementos reactivos
    const formSections = {
        'basic-info': { status: document.getElementById('basic-info-status'), isValid: false },
        'relations': { status: document.getElementById('relations-status'), isValid: false },
        'participants': { status: document.getElementById('participants-status'), isValid: false }
    };
    
    // ===== SISTEMA DE VALIDACIÓN REACTIVA =====
    
    function initializeValidationSystem() {
        // Configurar validaciones para cada campo
        setupFieldValidation(titulo, 'titulo', {
            required: true,
            minLength: 5,
            maxLength: 255,
            section: 'basic-info'
        });
        
        setupFieldValidation(fechaReunion, 'fecha', {
            required: true,
            futureDate: true,
            section: 'basic-info'
        });
        
        setupFieldValidation(ubicacion, 'text', {
            maxLength: 255,
            section: 'basic-info'
        });
        
        setupFieldValidation(descripcion, 'textarea', {
            maxLength: 1000,
            section: 'basic-info'
        });
        
        setupFieldValidation(solicitudId, 'select', {
            required: true,
            section: 'relations'
        });
        
        setupFieldValidation(institucionId, 'select', {
            required: true,
            section: 'relations'
        });
        
        setupFieldValidation(nuevoEstadoSolicitud, 'text', {
            maxLength: 255
        });
        
        // Configurar contadores de caracteres
        setupCharacterCounter(titulo, 255);
        setupCharacterCounter(ubicacion, 255);
        setupCharacterCounter(descripcion, 1000);
        setupCharacterCounter(nuevoEstadoSolicitud, 255);
    }
    
    function setupFieldValidation(field, type, rules) {
        if (!field) return;
        
        const events = ['input', 'change', 'blur'];
        events.forEach(event => {
            field.addEventListener(event, function() {
                validateField(this, type, rules);
            });
        });
        
        // Validación inicial si tiene valor
        if (field.value.trim()) {
            validateField(field, type, rules);
        }
    }
    
    function setupCharacterCounter(field, maxLength) {
        if (!field) return;
        
        const counter = document.getElementById(field.id + '-counter');
        if (!counter) return;
        
        function updateCounter() {
            const currentLength = field.value.length;
            counter.textContent = `${currentLength}/${maxLength}`;
            
            if (currentLength > maxLength * 0.8) {
                counter.classList.add('text-yellow-600');
                counter.classList.remove('text-gray-400');
            } else {
                counter.classList.remove('text-yellow-600');
                counter.classList.add('text-gray-400');
            }
            
            if (currentLength > maxLength) {
                counter.classList.add('text-red-600');
                counter.classList.remove('text-yellow-600');
            }
        }
        
        field.addEventListener('input', updateCounter);
        updateCounter(); // Inicial
    }
    
    function validateField(field, type, rules) {
        const value = field.value.trim();
        const messagesContainer = document.getElementById(field.id + '-messages');
        let isValid = true;
        let message = '';
        
        // Limpiar mensajes previos
        if (messagesContainer) {
            const existingMessages = messagesContainer.querySelectorAll('.error-message, .success-message, .warning-message');
            existingMessages.forEach(msg => msg.remove());
        }
        
        // Validar según las reglas
        if (rules.required && !value) {
            isValid = false;
            message = 'Este campo es obligatorio';
        } else if (rules.minLength && value && value.length < rules.minLength) {
            isValid = false;
            message = `Mínimo ${rules.minLength} caracteres`;
        } else if (rules.maxLength && value.length > rules.maxLength) {
            isValid = false;
            message = `Máximo ${rules.maxLength} caracteres`;
        } else if (rules.futureDate && value) {
            const selectedDate = new Date(value);
            const now = new Date();
            if (selectedDate <= now) {
                isValid = false;
                message = 'La fecha debe ser futura';
            }
        }
        
        // Actualizar estado visual del campo
        updateFieldState(field, isValid, message);
        
        // Actualizar estado de la sección
        if (rules.section && formSections[rules.section]) {
            updateSectionStatus(rules.section);
        }
        
        return isValid;
    }
    
    function updateFieldState(field, isValid, message) {
        field.classList.remove('error', 'success', 'loading');
        
        if (!field.value.trim() && !message) {
            // Campo vacío sin error
            return;
        }
        
        if (isValid && field.value.trim()) {
            field.classList.add('success');
            // Mostrar mensaje de éxito brevemente
            setTimeout(() => field.classList.remove('success'), 2000);
        } else if (!isValid) {
            field.classList.add('error');
            
            // Mostrar mensaje de error
            const messagesContainer = document.getElementById(field.id + '-messages');
            if (messagesContainer && message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.innerHTML = `<i class='bx bx-error-circle'></i><span>${message}</span>`;
                messagesContainer.appendChild(errorDiv);
            }
        }
    }
    
    function updateSectionStatus(sectionName) {
        const section = formSections[sectionName];
        if (!section || !section.status) return;
        
        let isValid = false;
        
        switch(sectionName) {
            case 'basic-info':
                isValid = validateBasicInfoSection();
                break;
            case 'relations':
                isValid = validateRelationsSection();
                break;
            case 'participants':
                isValid = validateParticipantsSection();
                break;
        }
        
        section.isValid = isValid;
        section.status.className = `w-3 h-3 rounded-full ${isValid ? 'bg-green-500' : 'bg-gray-300'}`;
    }
    
    function validateBasicInfoSection() {
        return titulo.value.trim().length >= 5 && 
               fechaReunion.value && 
               new Date(fechaReunion.value) > new Date();
    }
    
    function validateRelationsSection() {
        return solicitudId.value && institucionId.value;
    }
    
    function validateParticipantsSection() {
        const selectedParticipants = document.querySelectorAll('input[name="asistentes[]"]:checked');
        return selectedParticipants.length > 0; // Al menos un participante
    }
    
    // ===== SISTEMA DE PARTICIPANTES =====
    
    function initializeParticipantsSystem() {
        setupParticipantsSearch();
        setupParticipantsSelection();
        setupStatusSuggestions();
        updateParticipantsDisplay();
    }
    
    function setupParticipantsSearch() {
        if (!participantsSearch) return;
        
        participantsSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const participantCards = document.querySelectorAll('.participant-card');
            let visibleCount = 0;
            
            participantCards.forEach(card => {
                const name = card.dataset.name || '';
                const cedula = card.dataset.cedula || '';
                const isVisible = name.includes(searchTerm) || cedula.includes(searchTerm);
                
                card.style.display = isVisible ? 'flex' : 'none';
                if (isVisible) visibleCount++;
            });
            
            const noResultsDiv = document.getElementById('no-participants-found');
            if (noResultsDiv) {
                noResultsDiv.classList.toggle('hidden', visibleCount > 0);
            }
        });
    }
    
    function setupParticipantsSelection() {
        const participantCheckboxes = document.querySelectorAll('.participant-checkbox');
        const concejalRadios = document.querySelectorAll('.concejal-radio');
        
        // Manejar selección de participantes
        participantCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cedula = this.dataset.cedula;
                const card = document.getElementById('participant-card-' + cedula);
                const concejalRadio = document.querySelector(`.concejal-radio[data-cedula="${cedula}"]`);
                
                // Actualizar visual de la card
                if (card) {
                    card.classList.toggle('selected', this.checked);
                }
                
                // Si se deselecciona un participante que era concejal
                if (!this.checked && concejalRadio && concejalRadio.checked) {
                    concejalRadio.checked = false;
                    showNotification('El concejal fue removido de la selección', 'warning');
                    updateConcejalVisual();
                }
                
                updateParticipantsDisplay();
                updateSectionStatus('participants');
            });
        });
        
        // Manejar selección de concejal
        concejalRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const cedula = this.dataset.cedula;
                    const checkbox = document.querySelector(`.participant-checkbox[data-cedula="${cedula}"]`);
                    
                    // Auto-seleccionar como participante
                    if (checkbox && !checkbox.checked) {
                        checkbox.checked = true;
                        checkbox.dispatchEvent(new Event('change'));
                        showNotification('Concejal agregado automáticamente como participante', 'success');
                    }
                    
                    updateConcejalVisual();
                    updateParticipantsDisplay();
                }
            });
        });
    }
    
    function updateConcejalVisual() {
        const cards = document.querySelectorAll('.participant-card');
        cards.forEach(card => {
            card.classList.remove('concejal');
        });
        
        const selectedConcejal = document.querySelector('.concejal-radio:checked');
        if (selectedConcejal) {
            const cedula = selectedConcejal.dataset.cedula;
            const card = document.getElementById('participant-card-' + cedula);
            if (card) {
                card.classList.add('concejal');
            }
        }
    }
    
    function updateParticipantsDisplay() {
        const selectedParticipants = document.querySelectorAll('.participant-checkbox:checked');
        const selectedConcejal = document.querySelector('.concejal-radio:checked');
        const counter = document.getElementById('participants-counter');
        const summary = document.getElementById('selection-summary');
        const summaryDetails = document.getElementById('selection-details');
        
        if (counter) {
            counter.textContent = `${selectedParticipants.length} seleccionados`;
        }
        
        if (summary && summaryDetails) {
            if (selectedParticipants.length > 0) {
                summary.classList.remove('hidden');
                
                let details = `<strong>${selectedParticipants.length}</strong> participante(s) seleccionado(s)`;
                if (selectedConcejal) {
                    const concejalName = selectedConcejal.closest('.participant-card').querySelector('label .font-medium').textContent;
                    details += `<br><strong>Concejal responsable:</strong> ${concejalName}`;
                }
                
                summaryDetails.innerHTML = details;
            } else {
                summary.classList.add('hidden');
            }
        }
    }
    
    function setupStatusSuggestions() {
        const suggestions = document.querySelectorAll('.status-suggestion');
        suggestions.forEach(button => {
            button.addEventListener('click', function() {
                const status = this.dataset.status;
                if (nuevoEstadoSolicitud) {
                    nuevoEstadoSolicitud.value = status;
                    nuevoEstadoSolicitud.dispatchEvent(new Event('input'));
                    showNotification('Estado sugerido aplicado', 'success');
                }
            });
        });
    }
    
    // ===== SISTEMA DE NOTIFICACIONES =====
    
    function showNotification(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full max-w-sm`;
        
        const typeClasses = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-black',
            info: 'bg-blue-500 text-white'
        };
        
        const icons = {
            success: 'bx-check-circle',
            error: 'bx-x-circle',
            warning: 'bx-error',
            info: 'bx-info-circle'
        };
        
        toast.className += ` ${typeClasses[type]}`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class='bx ${icons[type]} mr-2'></i>
                <span class="text-sm font-medium">${message}</span>
                <button class="ml-3 hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Mostrar
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        
        // Auto-ocultar
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }, duration);
    }
    
    // ===== VALIDACIÓN Y ENVÍO DEL FORMULARIO =====
    
    function setupFormSubmission() {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar todas las secciones
            const isBasicValid = validateBasicInfoSection();
            const isRelationsValid = validateRelationsSection();
            const isParticipantsValid = validateParticipantsSection();
            
            // Actualizar estados visuales
            updateSectionStatus('basic-info');
            updateSectionStatus('relations');
            updateSectionStatus('participants');
            
            if (!isBasicValid) {
                showNotification('Complete la información básica correctamente', 'error');
                titulo.focus();
                return;
            }
            
            if (!isRelationsValid) {
                showNotification('Seleccione la solicitud e institución asociadas', 'error');
                solicitudId.focus();
                return;
            }
            
            if (!isParticipantsValid) {
                showNotification('Debe seleccionar al menos un participante', 'warning');
                document.querySelector('.participant-checkbox').focus();
                return;
            }
            
            // Envío exitoso
            submitButton.disabled = true;
            submitText.textContent = 'Guardando reunión...';
            submitSpinner.classList.remove('hidden');
            
            showNotification('Guardando reunión...', 'info');
            
            setTimeout(() => {
                this.submit();
            }, 500);
        });
    }
    
    // ===== INICIALIZACIÓN GENERAL =====
    
    function initialize() {
        initializeValidationSystem();
        initializeParticipantsSystem();
        setupFormSubmission();
        
        // Validar estado inicial
        Object.keys(formSections).forEach(sectionName => {
            updateSectionStatus(sectionName);
        });
        
        showNotification('Formulario cargado correctamente', 'success', 2000);
    }
    
    // Inicializar cuando todo esté listo
    initialize();
});
</script>