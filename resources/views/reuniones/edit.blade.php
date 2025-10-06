<x-layouts.rbac>
    @section('title', 'Editar Reunión')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-orange-50/30 to-red-50/20">
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm shadow-xl border-b border-gray-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center py-8">
                    <div class="flex items-center mb-6 lg:mb-0 animate-slide-in-left">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class='bx bx-edit text-white text-3xl'></i>
                                </div>
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <i class='bx bx-pencil text-white text-sm'></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">Editar Reunión</h1>
                                <p class="text-orange-600 font-semibold flex items-center">
                                    <i class='bx bx-calendar-event mr-2'></i>
                                    {{ $reunion->titulo }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class='bx bx-buildings mr-1'></i>
                                    Sistema Municipal CMBEY - Módulo de Edición
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 animate-slide-in-right">
                        <!-- Quick Info Card -->
                        <div class="hidden xl:flex items-center space-x-4 bg-orange-50 px-6 py-3 rounded-xl border border-orange-200">
                            <div class="text-center">
                                <div class="text-xs text-orange-600 font-medium">Fecha Original</div>
                                <div class="text-sm font-bold text-orange-800">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                            </div>
                            <div class="w-px h-8 bg-orange-300"></div>
                            <div class="text-center">
                                <div class="text-xs text-orange-600 font-medium">Participantes</div>
                                <div class="text-sm font-bold text-orange-800">{{ $reunion->asistentes->count() }}</div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                           class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class='bx bx-show mr-2 group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Ver Detalles</span>
                        </a>
                        <a href="{{ route('dashboard.reuniones.index') }}" 
                           class="group inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                            <i class='bx bx-arrow-back mr-2 group-hover:-translate-x-1 transition-transform duration-200'></i>
                            <span>Volver</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Progress Indicator for Edit Mode -->
        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center py-6">
                    <div class="flex items-center space-x-6">
                        <!-- Edit Mode Badge -->
                        <div class="flex items-center bg-orange-100 px-4 py-2 rounded-xl">
                            <i class='bx bx-edit text-orange-600 mr-2'></i>
                            <span class="text-orange-800 font-semibold text-sm">Modo Edición</span>
                        </div>
                        
                        <!-- Current Status -->
                        <div class="flex items-center space-x-4 text-sm">
                            <div class="flex items-center text-green-600">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-medium mr-3 shadow-lg">
                                    <i class='bx bx-check text-lg'></i>
                                </div>
                                <span class="font-medium">Reunión Existente</span>
                            </div>
                            <div class="w-12 h-0.5 bg-orange-300 rounded-full"></div>
                            <div class="flex items-center text-orange-600">
                                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-medium mr-3 shadow-lg animate-pulse">
                                    <i class='bx bx-pencil text-lg'></i>
                                </div>
                                <span class="font-medium">Modificando</span>
                            </div>
                            <div class="w-12 h-0.5 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center text-gray-400">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white font-medium mr-3 shadow-lg">
                                    <i class='bx bx-save text-lg'></i>
                                </div>
                                <span class="font-medium">Guardar Cambios</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Enhanced Alerts with SweetAlert2 -->
            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const errors = @json($errors->all());
                        let errorList = '<ul class="text-left list-disc list-inside space-y-1">';
                        errors.forEach(error => {
                            errorList += `<li>${error}</li>`;
                        });
                        errorList += '</ul>';
                        
                        Swal.fire({
                            icon: 'error',
                            title: '¡Errores en la edición!',
                            html: `<div class="text-gray-700 mb-4">Por favor corrija los siguientes errores:</div>${errorList}`,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#ef4444',
                            background: '#fef2f2',
                            customClass: {
                                title: 'text-red-800 font-bold',
                                content: 'text-red-700',
                                confirmButton: 'font-semibold'
                            }
                        });
                    });
                </script>
            @endif

            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualización exitosa!',
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

            <!-- Comparison Card (Before/After Summary) -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Información Actual de la Reunión</h3>
                            <p class="text-orange-100">Revise los datos actuales antes de realizar cambios</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                            <i class='bx bx-data text-3xl'></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Current Date -->
                        <div class="bg-blue-50 rounded-2xl p-6 text-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-calendar text-white text-xl'></i>
                            </div>
                            <div class="text-sm text-blue-600 font-medium mb-1">Fecha Actual</div>
                            <div class="font-bold text-blue-800">{{ $reunion->fecha_reunion->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <!-- Current Institution -->
                        <div class="bg-purple-50 rounded-2xl p-6 text-center">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-buildings text-white text-xl'></i>
                            </div>
                            <div class="text-sm text-purple-600 font-medium mb-1">Institución</div>
                            <div class="font-bold text-purple-800">{{ $reunion->institucion->titulo ?? 'N/A' }}</div>
                        </div>
                        
                        <!-- Current Participants -->
                        <div class="bg-green-50 rounded-2xl p-6 text-center">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-group text-white text-xl'></i>
                            </div>
                            <div class="text-sm text-green-600 font-medium mb-1">Participantes</div>
                            <div class="font-bold text-green-800">{{ $reunion->asistentes->count() }} personas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 overflow-hidden">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center mr-4">
                                <i class='bx bx-edit-alt text-orange-600 text-3xl'></i>
                            </div>
                            <div class="text-left">
                                <h2 class="text-2xl font-bold text-gray-900">
                                    Modificar Información
                                </h2>
                                <p class="text-gray-600">
                                    Actualice los campos necesarios para la reunión
                                </p>
                            </div>
                        </div>
                        
                        <!-- Warning Notice -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 max-w-2xl mx-auto">
                            <div class="flex items-start">
                                <i class='bx bx-info-circle text-yellow-600 text-xl mr-3 mt-0.5'></i>
                                <div class="text-left">
                                    <h4 class="font-semibold text-yellow-800 mb-1">Importante</h4>
                                    <p class="text-yellow-700 text-sm">
                                        Los cambios se aplicarán inmediatamente. Asegúrese de verificar toda la información antes de guardar.
                                        Si la reunión ya ha ocurrido, algunos participantes podrían haber sido notificados.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Form -->
                    <form action="{{ route('dashboard.reuniones.update', $reunion) }}" method="POST" id="editReunionForm" novalidate>
                        @method('PUT')
                        @include('reuniones._form', ['submitButtonText' => 'Actualizar Reunión'])
                    </form>
                </div>
            </div>

            <!-- Help Section for Edit Mode -->
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class='bx bx-help-circle text-white text-2xl'></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 text-lg mb-3">Consejos para Editar Reuniones</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-800 text-sm">
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class='bx bx-check text-green-600 mr-2 mt-0.5'></i>
                                    <span>Verifique que la nueva fecha no conflicte con otras reuniones</span>
                                </div>
                                <div class="flex items-start">
                                    <i class='bx bx-check text-green-600 mr-2 mt-0.5'></i>
                                    <span>Confirme la disponibilidad de todos los participantes</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class='bx bx-check text-green-600 mr-2 mt-0.5'></i>
                                    <span>Actualice la descripción si cambia el enfoque de la reunión</span>
                                </div>
                                <div class="flex items-start">
                                    <i class='bx bx-check text-green-600 mr-2 mt-0.5'></i>
                                    <span>Notifique a los participantes sobre los cambios importantes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Styles for Edit Mode -->
    <style>
        /* Enhanced animations */
        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes highlight-change {
            0%, 100% { 
                background-color: transparent; 
            }
            50% { 
                background-color: rgba(251, 146, 60, 0.1); 
            }
        }
        
        .animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
        .animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
        .animate-highlight-change { animation: highlight-change 2s ease-in-out; }
        
        /* Enhanced form styling for edit mode */
        .form-input:focus {
            background-color: rgba(251, 146, 60, 0.05);
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.1);
        }
        
        .form-input.changed {
            background-color: rgba(251, 146, 60, 0.05);
            border-left: 4px solid #f97316;
            animation: highlight-change 2s ease-in-out infinite;
        }
        
        /* Loading states for edit mode */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f4f6;
            border-top: 6px solid #f97316;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <div class="flex flex-col items-center">
                <div class="loading-spinner"></div>
                <p class="mt-4 text-gray-600 font-medium">Actualizando reunión...</p>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript for Edit Mode -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== INITIALIZATION =====
            initializeEditMode();
            initializeChangeTracking();
            initializeFormValidation();
            initializeAdvancedFeatures();
            
            // Store original values for comparison
            const originalValues = {};
            
            // ===== EDIT MODE INITIALIZATION =====
            function initializeEditMode() {
                // Animate elements on load
                const sections = document.querySelectorAll('.bg-white\\/90');
                sections.forEach((section, index) => {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        section.style.transition = 'all 0.6s ease';
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, index * 200);
                });
                
                // Store original form values
                const inputs = document.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.name) {
                        originalValues[input.name] = input.value;
                    }
                });
            }
            
            // ===== CHANGE TRACKING =====
            function initializeChangeTracking() {
                const inputs = document.querySelectorAll('input, select, textarea');
                
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        trackFieldChange(this);
                    });
                    
                    input.addEventListener('change', function() {
                        trackFieldChange(this);
                    });
                });
            }
            
            function trackFieldChange(field) {
                const originalValue = originalValues[field.name] || '';
                const currentValue = field.value || '';
                
                if (originalValue !== currentValue) {
                    field.classList.add('changed');
                    showChangeIndicator(field);
                } else {
                    field.classList.remove('changed');
                    hideChangeIndicator(field);
                }
                
                updateChangesSummary();
            }
            
            function showChangeIndicator(field) {
                const existingIndicator = field.parentNode.querySelector('.change-indicator');
                if (!existingIndicator) {
                    const indicator = document.createElement('div');
                    indicator.className = 'change-indicator absolute -right-2 -top-2 w-4 h-4 bg-orange-500 rounded-full flex items-center justify-center shadow-lg animate-pulse';
                    indicator.innerHTML = '<i class="bx bx-pencil text-white text-xs"></i>';
                    
                    if (field.parentNode.style.position !== 'relative') {
                        field.parentNode.style.position = 'relative';
                    }
                    field.parentNode.appendChild(indicator);
                }
            }
            
            function hideChangeIndicator(field) {
                const indicator = field.parentNode.querySelector('.change-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }
            
            function updateChangesSummary() {
                const changedFields = document.querySelectorAll('.form-input.changed');
                const summaryElement = document.getElementById('changesSummary');
                
                if (changedFields.length > 0) {
                    if (!summaryElement) {
                        createChangesSummary(changedFields.length);
                    } else {
                        updateChangesSummaryCount(changedFields.length);
                    }
                } else {
                    if (summaryElement) {
                        summaryElement.remove();
                    }
                }
            }
            
            function createChangesSummary(count) {
                const form = document.getElementById('editReunionForm');
                const summary = document.createElement('div');
                summary.id = 'changesSummary';
                summary.className = 'fixed bottom-4 right-4 bg-orange-500 text-white p-4 rounded-2xl shadow-2xl z-50 animate-slide-in-right';
                summary.innerHTML = `
                    <div class="flex items-center">
                        <i class='bx bx-edit mr-3 text-xl'></i>
                        <div>
                            <div class="font-bold text-sm">${count} campo(s) modificado(s)</div>
                            <div class="text-orange-100 text-xs">Los cambios se resaltarán</div>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 hover:bg-orange-600 rounded-full p-1">
                            <i class='bx bx-x text-lg'></i>
                        </button>
                    </div>
                `;
                document.body.appendChild(summary);
            }
            
            function updateChangesSummaryCount(count) {
                const summaryElement = document.getElementById('changesSummary');
                if (summaryElement) {
                    const countElement = summaryElement.querySelector('.font-bold');
                    if (countElement) {
                        countElement.textContent = `${count} campo(s) modificado(s)`;
                    }
                }
            }
            
            // ===== FORM VALIDATION =====
            function initializeFormValidation() {
                const form = document.getElementById('editReunionForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const hasChanges = document.querySelectorAll('.form-input.changed').length > 0;
                        
                        if (!hasChanges) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Sin cambios detectados',
                                text: 'No se han realizado modificaciones en la reunión.',
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: '#f97316'
                            });
                            return;
                        }
                        
                        // Confirm changes
                        Swal.fire({
                            title: '¿Confirmar cambios?',
                            html: `Se actualizará la información de la reunión.<br><small class="text-gray-600">Los participantes podrían necesitar ser notificados.</small>`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#f97316',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Sí, actualizar',
                            cancelButtonText: 'Cancelar',
                            background: '#fff7ed',
                            customClass: {
                                title: 'text-gray-900 font-bold',
                                content: 'text-gray-700',
                                confirmButton: 'font-semibold',
                                cancelButton: 'font-semibold'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading
                                document.getElementById('loadingOverlay').style.display = 'flex';
                                
                                Swal.fire({
                                    title: 'Actualizando reunión...',
                                    text: 'Por favor espere mientras se guardan los cambios.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                
                                // Submit after delay
                                setTimeout(() => {
                                    this.submit();
                                }, 1000);
                            }
                        });
                    });
                }
            }
            
            // ===== ADVANCED FEATURES =====
            function initializeAdvancedFeatures() {
                // Add comparison mode button
                addComparisonModeButton();
                
                // Add reset changes button
                addResetChangesButton();
                
                // Add keyboard shortcuts
                addKeyboardShortcuts();
            }
            
            function addComparisonModeButton() {
                const header = document.querySelector('.animate-slide-in-right');
                if (header) {
                    const compareBtn = document.createElement('button');
                    compareBtn.type = 'button';
                    compareBtn.className = 'hidden lg:inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-all duration-200 text-sm font-medium shadow-lg';
                    compareBtn.innerHTML = '<i class="bx bx-compare mr-2"></i>Comparar';
                    compareBtn.onclick = showComparisonMode;
                    header.appendChild(compareBtn);
                }
            }
            
            function addResetChangesButton() {
                const header = document.querySelector('.animate-slide-in-right');
                if (header) {
                    const resetBtn = document.createElement('button');
                    resetBtn.type = 'button';
                    resetBtn.className = 'hidden lg:inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-200 text-sm font-medium shadow-lg';
                    resetBtn.innerHTML = '<i class="bx bx-reset mr-2"></i>Restaurar';
                    resetBtn.onclick = resetAllChanges;
                    header.appendChild(resetBtn);
                }
            }
            
            function showComparisonMode() {
                const changedFields = document.querySelectorAll('.form-input.changed');
                if (changedFields.length === 0) {
                    Swal.fire('Sin cambios', 'No hay campos modificados para comparar.', 'info');
                    return;
                }
                
                let comparisonHTML = '<div class="text-left space-y-3">';
                
                changedFields.forEach(field => {
                    const label = field.closest('.form-group')?.querySelector('label')?.textContent || field.name;
                    const originalValue = originalValues[field.name] || 'Vacío';
                    const currentValue = field.value || 'Vacío';
                    
                    comparisonHTML += `
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="font-semibold text-sm text-gray-700 mb-2">${label}</div>
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <div class="text-red-600 font-medium mb-1">Anterior:</div>
                                    <div class="bg-red-50 p-2 rounded border">${originalValue}</div>
                                </div>
                                <div>
                                    <div class="text-green-600 font-medium mb-1">Nuevo:</div>
                                    <div class="bg-green-50 p-2 rounded border">${currentValue}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                comparisonHTML += '</div>';
                
                Swal.fire({
                    title: 'Comparación de Cambios',
                    html: comparisonHTML,
                    width: 600,
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#f97316'
                });
            }
            
            function resetAllChanges() {
                const changedFields = document.querySelectorAll('.form-input.changed');
                if (changedFields.length === 0) {
                    Swal.fire('Sin cambios', 'No hay campos modificados para restaurar.', 'info');
                    return;
                }
                
                Swal.fire({
                    title: '¿Restaurar cambios?',
                    text: 'Se perderán todas las modificaciones realizadas.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, restaurar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reset all fields to original values
                        Object.keys(originalValues).forEach(fieldName => {
                            const field = document.querySelector(`[name="${fieldName}"]`);
                            if (field) {
                                field.value = originalValues[fieldName];
                                field.classList.remove('changed');
                                hideChangeIndicator(field);
                            }
                        });
                        
                        updateChangesSummary();
                        
                        Swal.fire('Restaurado', 'Los campos han sido restaurados a sus valores originales.', 'success');
                    }
                });
            }
            
            function addKeyboardShortcuts() {
                document.addEventListener('keydown', function(e) {
                    // Ctrl + S to save
                    if (e.ctrlKey && e.key === 's') {
                        e.preventDefault();
                        document.getElementById('editReunionForm')?.dispatchEvent(new Event('submit'));
                    }
                    
                    // Ctrl + R to reset
                    if (e.ctrlKey && e.key === 'r') {
                        e.preventDefault();
                        resetAllChanges();
                    }
                    
                    // Ctrl + C to compare
                    if (e.ctrlKey && e.key === 'c' && e.altKey) {
                        e.preventDefault();
                        showComparisonMode();
                    }
                });
            }
        });
    </script>
</x-layouts.rbac>