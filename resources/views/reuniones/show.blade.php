<x-layouts.rbac>
    @section('title', 'Detalles de la Reunión')

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h2 class="text-2xl font-semibold leading-tight">Detalles de la Reunión</h2>

            <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Título</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->titulo }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Fecha</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->fecha_reunion->format('d F, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Solicitud Asociada</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->solicitud->titulo ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Institución</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->institucion->titulo ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">Descripción</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->descripcion ?: 'No se proporcionó descripción.' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">Ubicación</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $reunion->ubicacion ?: 'No se proporcionó ubicación.' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">Asistentes</h3>
                        @if($reunion->asistentes->count() > 0)
                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($reunion->asistentes as $asistente)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class='bx bx-user text-blue-600'></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $asistente->nombre }} {{ $asistente->apellido }}</p>
                                                <p class="text-xs text-gray-500">{{ $asistente->cedula }}</p>
                                            </div>
                                        </div>
                                        @if($asistente->pivot->es_concejal)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class='bx bx-star mr-1'></i>
                                                Concejal
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-600">No hay asistentes registrados para esta reunión.</p>
                        @endif
                    </div>
                </div>

                <div class="py-4 mt-6 border-t border-gray-200 text-right">
                    <a href="{{ route('dashboard.reuniones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Volver al Listado
                    </a>
                    <a href="{{ route('dashboard.reuniones.edit', $reunion) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.rbac>