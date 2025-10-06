<x-layouts.rbac>
    @section('title', 'Crear Nueva Reunión')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-indigo-50/20">
        <!-- Header Section -->
        <div class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center py-6">
                    <div class="flex items-center mb-4 lg:mb-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class='bx bx-calendar-plus text-white text-2xl'></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Crear Nueva Reunión</h1>
                                <p class="text-sm text-gray-600 flex items-center mt-1">
                                    <i class='bx bx-buildings mr-1'></i>
                                    Sistema Municipal CMBEY
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.reuniones.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Progress Indicator with Animations -->
        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center py-8">
                    <div class="flex items-center space-x-8 text-sm">
                        <!-- Step 1: Información Básica -->
                        <div class="flex items-center" id="step1">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-xl transform transition-all duration-300 hover:scale-110 step-indicator" data-step="1">
                                    <i class='bx bx-info-circle text-xl'></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full items-center justify-center text-white text-xs font-bold shadow-lg hidden step-check" id="check1">
                                    <i class='bx bx-check text-sm'></i>
                                </div>
                            </div>
                            <div class="ml-4 hidden sm:block">
                                <div class="font-bold text-blue-600">Paso 1</div>
                                <div class="text-gray-600">Información Básica</div>
                            </div>
                        </div>
                        
                        <!-- Connection Line 1 -->
                        <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden max-w-20">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transform -translate-x-full transition-transform duration-500 step-progress" id="progress1"></div>
                        </div>
                        
                        <!-- Step 2: Relaciones -->
                        <div class="flex items-center" id="step2">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg shadow-lg transform transition-all duration-300 step-indicator" data-step="2">
                                    <i class='bx bx-link-alt text-xl'></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg hidden step-check" id="check2">
                                    <i class='bx bx-check text-sm'></i>
                                </div>
                            </div>
                            <div class="ml-4 hidden sm:block">
                                <div class="font-bold text-gray-500 step-title" data-step="2">Paso 2</div>
                                <div class="text-gray-400">Relaciones</div>
                            </div>
                        </div>
                        
                        <!-- Connection Line 2 -->
                        <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden max-w-20">
                            <div class="h-full bg-gradient-to-r from-green-500 to-green-600 rounded-full transform -translate-x-full transition-transform duration-500 step-progress" id="progress2"></div>
                        </div>
                        
                        <!-- Step 3: Participantes -->
                        <div class="flex items-center" id="step3">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg shadow-lg transform transition-all duration-300 step-indicator" data-step="3">
                                    <i class='bx bx-group text-xl'></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg hidden step-check" id="check3">
                                    <i class='bx bx-check text-sm'></i>
                                </div>
                            </div>
                            <div class="ml-4 hidden sm:block">
                                <div class="font-bold text-gray-500 step-title" data-step="3">Paso 3</div>
                                <div class="text-gray-400">Participantes</div>
                            </div>
                        </div>
                        
                        <!-- Connection Line 3 -->
                        <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden max-w-20">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full transform -translate-x-full transition-transform duration-500 step-progress" id="progress3"></div>
                        </div>
                        
                        <!-- Step 4: Finalizar -->
                        <div class="flex items-center" id="step4">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg shadow-lg transform transition-all duration-300 step-indicator" data-step="4">
                                    <i class='bx bx-check-circle text-xl'></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg hidden step-check" id="check4">
                                    <i class='bx bx-check text-sm'></i>
                                </div>
                            </div>
                            <div class="ml-4 hidden sm:block">
                                <div class="font-bold text-gray-500 step-title" data-step="4">Finalizar</div>
                                <div class="text-gray-400">Completado</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="pb-4">
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 via-green-500 to-purple-500 rounded-full transform -translate-x-full transition-transform duration-1000" id="overallProgress"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
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
                            title: '¡Errores en el formulario!',
                            html: `<div class="text-gray-700 mb-4">Por favor corrija los siguientes errores:</div>${errorList}`,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#ef4444',
                            background: '#fef2f2',
                            customClass: {
                                title: 'text-red-800 font-bold',
                                content: 'text-red-700',
                                confirmButton: 'font-semibold'
                            },
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
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

            <!-- Main Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Registrar Nueva Reunión
                        </h2>
                        <p class="text-gray-600">
                            Complete la información necesaria para programar y registrar la reunión en el sistema
                        </p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('dashboard.reuniones.store') }}" method="POST" id="reunionForm" novalidate>
                        @include('reuniones._form', ['submitButtonText' => 'Crear Reunión'])
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4 mt-0.5">
                        <i class='bx bx-help-circle text-white'></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Ayuda para crear reuniones</h3>
                        <ul class="text-blue-800 text-sm space-y-1">
                            <li>• Asegúrese de seleccionar la solicitud correcta que origina la reunión</li>
                            <li>• La fecha debe ser futura y en horario laboral recomendado</li>
                            <li>• Designe un concejal responsable entre los asistentes</li>
                            <li>• El estado de solicitud se actualizará automáticamente si especifica uno nuevo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animaciones adicionales */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slideInUp {
            animation: slideInUp 0.5s ease-out;
        }
    </style>
    
    <!-- Enhanced Styles -->
    <style>
        /* Enhanced animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
            }
            50% { 
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
            }
        }
        
        @keyframes step-complete {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .animate-slideInUp { animation: slideInUp 0.6s ease-out; }
        .animate-pulse-glow { animation: pulse-glow 2s infinite; }
        .animate-step-complete { animation: step-complete 0.5s ease-out; }
        
        /* Step indicators */
        .step-indicator.active {
            background: linear-gradient(135deg, #3b82f6, #1e40af) !important;
            color: white !important;
            animation: pulse-glow 2s infinite;
        }
        
        .step-indicator.completed {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            color: white !important;
        }
        
        .step-title.active {
            color: #3b82f6 !important;
            font-weight: bold;
        }
        
        .step-title.completed {
            color: #10b981 !important;
            font-weight: bold;
        }
        
        /* Form enhancements */
        .form-section {
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
        }
        
        .form-section.visible {
            transform: translateY(0);
            opacity: 1;
        }
        
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }
        
        /* Mobile responsive enhancements */
        @media (max-width: 640px) {
            .step-indicator {
                width: 2.5rem !important;
                height: 2.5rem !important;
            }
            
            .flex.items-center.space-x-8 {
                space-x: 1rem;
            }
        }
        
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f4f6;
            border-top: 6px solid #3b82f6;
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
                <p class="mt-4 text-gray-600 font-medium">Creando reunión...</p>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== INITIALIZATION =====
            initializeAnimations();
            initializeFormProgress();
            initializeEnhancedValidation();
            initializeFormSections();
            initializeQuickFill();
            
            // ===== ANIMATION SYSTEM =====
            function initializeAnimations() {
                const mainForm = document.querySelector('.bg-white.rounded-2xl');
                if (mainForm) {
                    mainForm.classList.add('animate-slideInUp');
                }
                
                // Animate form sections
                const sections = document.querySelectorAll('.card-section');
                sections.forEach((section, index) => {
                    setTimeout(() => {
                        section.classList.add('form-section', 'visible');
                    }, index * 200);
                });
                
                // Animate stats cards on load
                animateStatsCards();
            }
            
            function animateStatsCards() {
                const statsCards = document.querySelectorAll('.bg-gradient-to-br');
                statsCards.forEach((card, index) => {
                    card.style.transform = 'translateY(20px)';
                    card.style.opacity = '0';
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.5s ease';
                        card.style.transform = 'translateY(0)';
                        card.style.opacity = '1';
                    }, index * 100);
                });
            }
            
            // ===== FORM PROGRESS SYSTEM =====
            function initializeFormProgress() {
                updateProgressStep(1); // Start at step 1
                
                // Listen for form changes
                const form = document.getElementById('reunionForm');
                if (form) {
                    form.addEventListener('input', updateFormProgress);
                    form.addEventListener('change', updateFormProgress);
                }
            }
            
            function updateFormProgress() {
                const step1Complete = validateBasicInfo();
                const step2Complete = validateRelations();
                const step3Complete = validateParticipants();
                
                if (step1Complete && !step2Complete && !step3Complete) {
                    updateProgressStep(2);
                } else if (step1Complete && step2Complete && !step3Complete) {
                    updateProgressStep(3);
                } else if (step1Complete && step2Complete && step3Complete) {
                    updateProgressStep(4);
                } else {
                    updateProgressStep(1);
                }
            }
            
            function updateProgressStep(step) {
                // Update step indicators
                for (let i = 1; i <= 4; i++) {
                    const indicator = document.querySelector(`[data-step="${i}"]`);
                    const title = document.querySelector(`.step-title[data-step="${i}"]`);
                    const check = document.getElementById(`check${i}`);
                    const progress = document.getElementById(`progress${i}`);
                    
                    if (indicator) {
                        indicator.classList.remove('active', 'completed');
                        if (title) title.classList.remove('active', 'completed');
                        if (check) check.classList.add('hidden');
                        
                        if (i < step) {
                            indicator.classList.add('completed');
                            if (title) title.classList.add('completed');
                            if (check) {
                                check.classList.remove('hidden');
                                check.classList.add('flex');
                            }
                        } else if (i === step) {
                            indicator.classList.add('active');
                            if (title) title.classList.add('active');
                        }
                    }
                    
                    if (progress) {
                        if (i < step) {
                            progress.style.transform = 'translateX(0)';
                        } else {
                            progress.style.transform = 'translateX(-100%)';
                        }
                    }
                }
                
                // Update overall progress bar
                const overallProgress = document.getElementById('overallProgress');
                if (overallProgress) {
                    const percentage = ((step - 1) / 3) * 100;
                    overallProgress.style.transform = `translateX(-${100 - percentage}%)`;
                }
            }
            
            function validateBasicInfo() {
                const titulo = document.getElementById('titulo');
                const fechaReunion = document.getElementById('fecha_reunion');
                
                return titulo && titulo.value.trim().length >= 5 &&
                       fechaReunion && fechaReunion.value &&
                       new Date(fechaReunion.value) > new Date();
            }
            
            function validateRelations() {
                const solicitudId = document.getElementById('solicitud_id');
                const institucionId = document.getElementById('institucion_id');
                
                return solicitudId && solicitudId.value &&
                       institucionId && institucionId.value;
            }
            
            function validateParticipants() {
                const checkedParticipants = document.querySelectorAll('input[name="asistentes[]"]:checked');
                return checkedParticipants.length > 0;
            }
            
            // ===== ENHANCED VALIDATION =====
            function initializeEnhancedValidation() {
                const inputs = document.querySelectorAll('.form-input');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.classList.add('animate-pulse-glow');
                    });
                    
                    input.addEventListener('blur', function() {
                        this.classList.remove('animate-pulse-glow');
                        validateFieldRealTime(this);
                    });
                    
                    input.addEventListener('input', function() {
                        clearTimeout(this.validationTimeout);
                        this.validationTimeout = setTimeout(() => {
                            validateFieldRealTime(this);
                        }, 500);
                    });
                });
            }
            
            function validateFieldRealTime(field) {
                const value = field.value.trim();
                const fieldName = field.name || field.id;
                let isValid = true;
                let message = '';
                
                // Field-specific validation
                switch (fieldName) {
                    case 'titulo':
                        if (!value) {
                            isValid = false;
                            message = 'El título es obligatorio';
                        } else if (value.length < 5) {
                            isValid = false;
                            message = 'El título debe tener al menos 5 caracteres';
                        }
                        break;
                    case 'fecha_reunion':
                        if (!value) {
                            isValid = false;
                            message = 'La fecha es obligatoria';
                        } else if (new Date(value) <= new Date()) {
                            isValid = false;
                            message = 'La fecha debe ser futura';
                        }
                        break;
                    case 'solicitud_id':
                    case 'institucion_id':
                        if (!value) {
                            isValid = false;
                            message = 'Este campo es obligatorio';
                        }
                        break;
                }
                
                showFieldFeedback(field, isValid, message);
            }
            
            function showFieldFeedback(field, isValid, message) {
                // Remove existing classes
                field.classList.remove('error', 'success');
                
                // Add appropriate class
                if (isValid && field.value.trim()) {
                    field.classList.add('success');
                    showToast('Campo válido', 'success', 1000);
                } else if (!isValid) {
                    field.classList.add('error');
                    if (message) {
                        showToast(message, 'error', 3000);
                    }
                }
            }
            
            // ===== FORM SECTIONS MANAGEMENT =====
            function initializeFormSections() {
                const sections = document.querySelectorAll('.card-section');
                sections.forEach(section => {
                    section.classList.add('form-section');
                });
                
                // Show first section immediately
                setTimeout(() => {
                    sections[0]?.classList.add('visible');
                }, 100);
            }
            
            // ===== QUICK FILL FUNCTIONALITY =====
            function initializeQuickFill() {
                // Add quick fill buttons for testing
                if (window.location.hostname === 'localhost' || window.location.hostname.includes('dev')) {
                    addQuickFillButton();
                }
            }
            
            function addQuickFillButton() {
                const header = document.querySelector('.flex.items-center.space-x-4');
                if (header) {
                    const quickFillBtn = document.createElement('button');
                    quickFillBtn.type = 'button';
                    quickFillBtn.className = 'px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all duration-200 text-sm';
                    quickFillBtn.innerHTML = '<i class="bx bx-zap mr-2"></i>Llenar Rápido';
                    quickFillBtn.onclick = quickFillForm;
                    header.appendChild(quickFillBtn);
                }
            }
            
            function quickFillForm() {
                Swal.fire({
                    title: 'Llenar formulario automáticamente',
                    text: '¿Desea llenar el formulario con datos de prueba?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, llenar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Fill form with test data
                        const titulo = document.getElementById('titulo');
                        const fechaReunion = document.getElementById('fecha_reunion');
                        const ubicacion = document.getElementById('ubicacion');
                        const descripcion = document.getElementById('descripcion');
                        const solicitudId = document.getElementById('solicitud_id');
                        const institucionId = document.getElementById('institucion_id');
                        
                        if (titulo) titulo.value = 'Reunión de Seguimiento Ejemplo';
                        if (fechaReunion) {
                            const tomorrow = new Date();
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            fechaReunion.value = tomorrow.toISOString().slice(0, 16);
                        }
                        if (ubicacion) ubicacion.value = 'Sala de Reuniones Municipal';
                        if (descripcion) descripcion.value = 'Reunión de seguimiento para revisar el progreso de las solicitudes pendientes.';
                        
                        // Select first options in dropdowns
                        if (solicitudId && solicitudId.options.length > 1) {
                            solicitudId.selectedIndex = 1;
                        }
                        if (institucionId && institucionId.options.length > 1) {
                            institucionId.selectedIndex = 1;
                        }
                        
                        // Select first participant
                        const firstParticipant = document.querySelector('input[name="asistentes[]"]');
                        if (firstParticipant) {
                            firstParticipant.checked = true;
                        }
                        
                        // Trigger change events
                        [titulo, fechaReunion, ubicacion, descripcion, solicitudId, institucionId].forEach(field => {
                            if (field) {
                                field.dispatchEvent(new Event('input', { bubbles: true }));
                                field.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        });
                        
                        showToast('Formulario llenado automáticamente', 'success');
                    }
                });
            }
            
            // ===== TOAST NOTIFICATION SYSTEM =====
            function showToast(message, type = 'info', duration = 3000) {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 p-4 rounded-xl shadow-2xl z-50 transition-all duration-300 transform translate-x-full max-w-sm`;
                
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
                        <i class='bx ${icons[type]} mr-3 text-xl'></i>
                        <span class="font-medium">${message}</span>
                        <button class="ml-4 hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                // Show animation
                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                
                // Auto remove
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentNode) toast.remove();
                    }, 300);
                }, duration);
            }
            
            // ===== FORM SUBMISSION ENHANCEMENT =====
            const form = document.getElementById('reunionForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show loading
                    document.getElementById('loadingOverlay').style.display = 'flex';
                    
                    // Validate all sections
                    if (!validateBasicInfo()) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        Swal.fire('Error', 'Complete correctamente la información básica', 'error');
                        return;
                    }
                    
                    if (!validateRelations()) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        Swal.fire('Error', 'Seleccione la solicitud e institución asociadas', 'error');
                        return;
                    }
                    
                    if (!validateParticipants()) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        Swal.fire('Error', 'Debe seleccionar al menos un participante', 'error');
                        return;
                    }
                    
                    // Success animation
                    Swal.fire({
                        title: 'Creando reunión...',
                        text: 'Por favor espere mientras se procesa la información.',
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
                });
            }
        });
    </script>
</x-layouts.rbac>