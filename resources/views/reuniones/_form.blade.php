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
    const solicitudId = document.getElementById('solicitud_id');
    const institucionId = document.getElementById('institucion_id');
    const asistentesCheckboxes = document.querySelectorAll('input[name="asistentes[]"]');
    const concejalRadios = document.querySelectorAll('input[name="concejal"]');
    
    // ===== VALIDACIONES EN TIEMPO REAL =====
    
    // Validar título
    titulo.addEventListener('input', function() {
        validateField(this, 'titulo', {
            required: true,
            minLength: 5,
            maxLength: 255
        });
    });
    
    // Validar fecha
    fechaReunion.addEventListener('change', function() {
        validateField(this, 'fecha', {
            required: true,
            futureDate: true
        });
    });
    
    // Validar selects
    [solicitudId, institucionId].forEach(select => {
        select.addEventListener('change', function() {
            validateField(this, 'select', {
                required: true
            });
        });
    });
    
    // ===== LÓGICA DE ASISTENTES Y CONCEJAL =====
    
    // Manejar selección de asistentes
    asistentesCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const cedula = this.value;
            const concejalRadio = document.getElementById('concejal_' + cedula);
            
            // Si se deselecciona un asistente que era concejal
            if (!this.checked && concejalRadio && concejalRadio.checked) {
                concejalRadio.checked = false;
                showNotification('El concejal fue removido de la selección', 'warning');
            }
            
            // Actualizar contador de asistentes
            updateAsistentesCounter();
            validateAsistentes();
        });
    });
    
    // Manejar selección de concejal
    concejalRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const cedula = this.value;
                const asistenteCheckbox = document.getElementById('asistente_' + cedula);
                
                // Auto-seleccionar como asistente si no está seleccionado
                if (!asistenteCheckbox.checked) {
                    asistenteCheckbox.checked = true;
                    showNotification('Concejal agregado automáticamente como asistente', 'success');
                }
                
                updateAsistentesCounter();
            }
        });
    });
    
    // ===== FUNCIONES DE VALIDACIÓN =====
    
    function validateField(field, type, rules) {
        const value = field.value.trim();
        const fieldGroup = field.closest('.form-group');
        
        // Limpiar mensajes previos
        clearFieldMessages(fieldGroup);
        
        // Validación requerido
        if (rules.required && !value) {
            setFieldError(field, fieldGroup, 'Este campo es obligatorio');
            return false;
        }
        
        // Validaciones específicas por tipo
        switch(type) {
            case 'titulo':
                if (rules.minLength && value.length < rules.minLength) {
                    setFieldError(field, fieldGroup, `Mínimo ${rules.minLength} caracteres`);
                    return false;
                }
                if (rules.maxLength && value.length > rules.maxLength) {
                    setFieldError(field, fieldGroup, `Máximo ${rules.maxLength} caracteres`);
                    return false;
                }
                break;
                
            case 'fecha':
                if (rules.futureDate && value) {
                    const selectedDate = new Date(value);
                    const now = new Date();
                    if (selectedDate <= now) {
                        setFieldError(field, fieldGroup, 'La fecha debe ser futura');
                        return false;
                    }
                }
                break;
                
            case 'select':
                if (rules.required && !value) {
                    setFieldError(field, fieldGroup, 'Debe seleccionar una opción');
                    return false;
                }
                break;
        }
        
        // Campo válido
        setFieldSuccess(field, fieldGroup);
        return true;
    }
    
    function validateAsistentes() {
        const selectedAsistentes = document.querySelectorAll('input[name="asistentes[]"]:checked');
        const asistenteContainer = document.querySelector('input[name="asistentes[]"]').closest('.form-group');
        
        if (selectedAsistentes.length === 0) {
            // No mostrar error si no hay asistentes (es opcional)
            return true;
        }
        
        return true;
    }
    
    function setFieldError(field, fieldGroup, message) {
        field.classList.remove('success');
        field.classList.add('error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `<i class='bx bx-error-circle'></i><span>${message}</span>`;
        fieldGroup.appendChild(errorDiv);
    }
    
    function setFieldSuccess(field, fieldGroup) {
        field.classList.remove('error');
        field.classList.add('success');
        
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = `<i class='bx bx-check-circle'></i><span>Válido</span>`;
        fieldGroup.appendChild(successDiv);
        
        // Auto-remover mensaje de éxito después de 2 segundos
        setTimeout(() => {
            if (successDiv.parentNode) {
                successDiv.remove();
                field.classList.remove('success');
            }
        }, 2000);
    }
    
    function clearFieldMessages(fieldGroup) {
        const messages = fieldGroup.querySelectorAll('.error-message, .success-message');
        messages.forEach(msg => msg.remove());
    }
    
    // ===== FUNCIONES AUXILIARES =====
    
    function updateAsistentesCounter() {
        const selectedCount = document.querySelectorAll('input[name="asistentes[]"]:checked').length;
        const concejalSelected = document.querySelector('input[name="concejal"]:checked');
        
        // Actualizar contador visual (si existe)
        const counter = document.querySelector('#asistentes-counter');
        if (counter) {
            counter.textContent = `${selectedCount} asistente(s) seleccionado(s)`;
            if (concejalSelected) {
                counter.textContent += ' (1 concejal designado)';
            }
        }
    }
    
    function showNotification(message, type = 'info') {
        // Crear notificación toast
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;
        
        const typeClasses = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        
        toast.className += ` ${typeClasses[type]}`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class='bx bx-${type === 'success' ? 'check' : type === 'error' ? 'x' : type === 'warning' ? 'error' : 'info'}-circle mr-2'></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Mostrar
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Ocultar y remover
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // ===== VALIDACIÓN Y ENVÍO DEL FORMULARIO =====
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar todos los campos
        let isValid = true;
        
        isValid &= validateField(titulo, 'titulo', {required: true, minLength: 5, maxLength: 255});
        isValid &= validateField(fechaReunion, 'fecha', {required: true, futureDate: true});
        isValid &= validateField(solicitudId, 'select', {required: true});
        isValid &= validateField(institucionId, 'select', {required: true});
        isValid &= validateAsistentes();
        
        if (isValid) {
            // Mostrar loading
            submitButton.disabled = true;
            submitText.textContent = 'Guardando...';
            submitSpinner.classList.remove('hidden');
            
            // Enviar formulario
            setTimeout(() => {
                form.submit();
            }, 500);
        } else {
            showNotification('Por favor, corrija los errores en el formulario', 'error');
        }
    });
    
    // ===== INICIALIZACIÓN =====
    updateAsistentesCounter();
    
    // Auto-validar campos al cargar si tienen valor
    [titulo, fechaReunion, solicitudId, institucionId].forEach(field => {
        if (field.value.trim()) {
            field.dispatchEvent(new Event(field.type === 'select-one' ? 'change' : 'input'));
        }
    });
});
</script>