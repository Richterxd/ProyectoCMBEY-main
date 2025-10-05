<x-layouts.rbac>
    @section('title', 'Crear Nueva Reunión')

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                                <i class='bx bx-plus text-white text-xl'></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Reunión</h1>
                                <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.reuniones.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class='bx bx-calendar-plus text-green-600 mr-2'></i>
                            Información de la Reunión
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Complete todos los campos requeridos para registrar la nueva reunión.</p>
                    </div>

                    <form action="{{ route('dashboard.reuniones.store') }}" method="POST">
                        @include('reuniones._form', ['submitButtonText' => 'Crear Reunión'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>