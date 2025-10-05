<x-layouts.rbac>
    @section('title', 'Editar Reunión')

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class='bx bx-edit text-white text-xl'></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Editar Reunión</h1>
                                <p class="text-sm text-gray-600">{{ $reunion->titulo }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.reuniones.show', $reunion) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-show mr-2'></i>
                            Ver Detalles
                        </a>
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
                            <i class='bx bx-calendar-edit text-blue-600 mr-2'></i>
                            Modificar Información de la Reunión
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Actualice la información necesaria de la reunión.</p>
                    </div>

                    <form action="{{ route('dashboard.reuniones.update', $reunion) }}" method="POST">
                        @method('PUT')
                        @include('reuniones._form', ['submitButtonText' => 'Actualizar Reunión'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>