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
    
    <script>
        // Añadir animación al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const mainForm = document.querySelector('.bg-white.rounded-2xl');
            if (mainForm) {
                mainForm.classList.add('animate-slideInUp');
            }
        });
    </script>
</x-layouts.rbac>