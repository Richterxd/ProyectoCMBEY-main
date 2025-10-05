<x-layouts.rbac>
    @section('title', 'Crear Nueva Reunión')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
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

        <!-- Progress Indicator -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center py-4">
                    <div class="flex items-center space-x-4 text-sm">
                        <div class="flex items-center text-green-600">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-medium mr-2">
                                1
                            </div>
                            <span class="font-medium">Información Básica</span>
                        </div>
                        <div class="w-12 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center text-green-600">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-medium mr-2">
                                2
                            </div>
                            <span class="font-medium">Relaciones</span>
                        </div>
                        <div class="w-12 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center text-green-600">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-medium mr-2">
                                3
                            </div>
                            <span class="font-medium">Participantes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Alerts Section -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class='bx bx-error-circle text-red-600 mr-2'></i>
                        <h3 class="text-red-800 font-medium">Hay errores en el formulario</h3>
                    </div>
                    <ul class="text-red-700 text-sm space-y-1 ml-6">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class='bx bx-check-circle text-green-600 mr-2'></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
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