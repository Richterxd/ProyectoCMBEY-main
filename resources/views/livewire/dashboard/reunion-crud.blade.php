<div class="min-h-screen bg-gray-50">

    <!-- Enhanced Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="bx bx-group text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Reuniones</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row items-center gap-3">
                    @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                        <button wire:click="setActiveTab('create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Reunión
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="flex border-b border-gray-200">
                <button wire:click="setActiveTab('list')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'list' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <i class='bx bx-list-ul mr-2'></i>
                    Lista de Reuniones
                </button>
                
                @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                    <button wire:click="setActiveTab('create')" 
                            class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'create' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        <i class='bx bx-plus mr-2'></i>
                        Nueva Reunión
                    </button>
                @endif
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class='bx bx-x-circle text-red-600 text-xl mr-3'></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Content -->
    @if($activeTab === 'list')
        <!-- Reuniones List -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center mb-4 sm:mb-0">
                        <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                        @if(Auth::user()->isSuperAdministrador())
                            Todas las Reuniones
                        @elseif(Auth::user()->isAdministrador())
                            Gestión de Reuniones
                        @else
                            Mis Reuniones
                        @endif
                    </h2>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <input type="text" placeholder="Buscar reunión..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        </div>
                        <span class="text-sm text-gray-500">{{ $reuniones->count() }} reuniones</span>
                    </div>
                </div>

                @if($reuniones->isEmpty())
                    <div class="text-center py-20">
                        <div class="flex flex-col items-center">
                            <div class="relative mb-8">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center shadow-xl">
                                    <i class='bx bx-calendar-x text-5xl text-gray-400'></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class='bx bx-plus text-white text-lg'></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No hay reuniones registradas</h3>
                            <p class="text-gray-600 mb-8 max-w-md text-center leading-relaxed">
                                @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                    Comience creando una nueva reunión para gestionar las actividades municipales y coordinar con las instituciones del municipio.
                                @else
                                    No se han programado reuniones relacionadas a tus solicitudes
                                @endif
                            </p>
                            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                <button wire:click="setActiveTab('create')"
                                       class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white rounded-2xl hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105">
                                    <i class='bx bx-plus mr-3 text-2xl group-hover:rotate-90 transition-transform duration-300'></i>
                                    <span class="font-bold text-lg">Crear Primera Reunión</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-group mr-2'></i>
                                        Reunión
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-file-blank mr-2'></i>
                                        Solicitud
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-buildings mr-2'></i>
                                        Institución
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-calendar mr-2'></i>
                                        Fecha & Hora
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-user-circle mr-2'></i>
                                        Asistentes
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                    <div class="flex items-center">
                                        <i class='bx bx-cog mr-2'></i>
                                        Acciones
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reuniones as $reunion)
                                <tr class="hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                {{ substr($reunion->titulo, 0, 1) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $reunion->titulo }}
                                                </div>
                                                @if($reunion->ubicacion)
                                                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                                                        <i class='bx bx-map-pin mr-1 text-red-500'></i>
                                                        {{ Str::limit($reunion->ubicacion, 40) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="text-sm font-medium text-gray-900">{{ $reunion->solicitud->titulo ?? 'N/A' }}</div>
                                        @if($reunion->solicitud)
                                            <div class="text-xs text-gray-500 mt-1">ID: {{ $reunion->solicitud->solicitud_id }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                                <i class='bx bx-buildings text-white text-xs'></i>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">{{ $reunion->institucion->titulo ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="space-y-1">
                                            <div class="text-sm font-semibold text-gray-900">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                                            <div class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full inline-flex items-center">
                                                <i class='bx bx-time mr-1'></i>
                                                {{ $reunion->fecha_reunion->format('H:i') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class='bx bx-user mr-1'></i>{{ $reunion->asistentes->count() }}
                                            </span>
                                            @php
                                                $concejal = $reunion->asistentes->where('pivot.es_concejal', true)->first();
                                            @endphp
                                            @if($concejal)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class='bx bx-star mr-1'></i>Concejal
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 md:px-6">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- View Button -->
                                            <button wire:click="viewReunion({{ $reunion->id }})" 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                                    title="Ver detalles">
                                                <i class='bx bx-show text-lg'></i>
                                            </button>
                                            
                                            <!-- Edit Button -->
                                            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                                <button wire:click="editReunion({{ $reunion->id }})" 
                                                        class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-200" 
                                                        title="Editar">
                                                    <i class='bx bx-edit text-lg'></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Delete Button -->
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="deleteReunion({{ $reunion->id }})" 
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200" 
                                                        title="Eliminar">
                                                    <i class='bx bx-trash text-lg'></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($activeTab === 'create')
        <!-- Create New Reunion -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Nueva Reunión</h1>
                            <p class="mt-2 text-gray-600">Complete todos los campos para programar una nueva reunión</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                <i class='bx bx-check-circle mr-1'></i>
                                Reunión Completa
                            </div>
                            <button wire:click="setActiveTab('list')" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class='bx bx-arrow-back mr-1'></i>
                                Volver
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    1
                                </div>
                                <span class="ml-2 text-sm font-medium text-blue-600">Información Básica</span>
                            </div>
                            <div class="w-16 h-1 bg-blue-600 rounded"></div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    2
                                </div>
                                <span class="ml-2 text-sm font-medium text-blue-600">Relaciones</span>
                            </div>
                            <div class="w-16 h-1 bg-blue-600 rounded"></div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    3
                                </div>
                                <span class="ml-2 text-sm font-medium text-blue-600">Participantes</span>
                            </div>
                            <div class="w-16 h-1 bg-blue-600 rounded"></div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    4
                                </div>
                                <span class="ml-2 text-sm font-medium text-blue-600">Confirmación</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="createReunion">
                    @include('livewire.dashboard.components.reunion-form')
                </form>
            </div>
        </div>
    @endif

    @if($activeTab === 'edit' && $editingReunion)
        <!-- Edit Reunion -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Editar Reunión</h1>
                            <p class="mt-2 text-gray-600">Modifique los datos de la reunión</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <i class='bx bx-edit mr-1'></i>
                                Editando
                            </div>
                            <button wire:click="setActiveTab('list')" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class='bx bx-arrow-back mr-1'></i>
                                Volver
                            </button>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="updateReunion">
                    @include('livewire.dashboard.components.reunion-form', ['isEditing' => true])
                </form>
            </div>
        </div>
    @endif

    @if($activeTab === 'view' && $selectedReunion)
        <!-- View Reunion Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Detalles de la Reunión</h2>
                        <p class="text-gray-600">Información completa de la reunión</p>
                    </div>
                    <button wire:click="setActiveTab('list')" 
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Volver a la Lista
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->titulo }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->fecha_reunion->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Solicitud</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                {{ $selectedReunion->solicitud->titulo ?? 'N/A' }}
                                @if($selectedReunion->solicitud)
                                    <br><span class="text-sm text-gray-500">ID: {{ $selectedReunion->solicitud->solicitud_id }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Institución</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->institucion->titulo ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @if($selectedReunion->ubicacion)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->ubicacion }}</div>
                        </div>
                    @endif

                    @if($selectedReunion->descripcion)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedReunion->descripcion }}</div>
                        </div>
                    @endif

                    <!-- Asistentes -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Asistentes ({{ $selectedReunion->asistentes->count() }})</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($selectedReunion->asistentes as $asistente)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $asistente->nombre }} {{ $asistente->apellido }}</div>
                                        <div class="text-sm text-gray-500">{{ $asistente->cedula }}</div>
                                    </div>
                                    @if($asistente->pivot->es_concejal)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class='bx bx-star mr-1'></i>Concejal
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <button wire:click="setActiveTab('list')" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Volver a la Lista
                        </button>
                        
                        <div class="flex space-x-3">
                            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                <button wire:click="editReunion({{ $selectedReunion->id }})" 
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class='bx bx-edit mr-2'></i>
                                    Editar Reunión
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- SweetAlert2 Script for confirmations -->
<script>
function confirmDelete(reunionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            @this.deleteReunion(reunionId);
        }
    });
}

// Show success/error notifications
document.addEventListener('DOMContentLoaded', function () {
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session("success") }}',
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showConfirmButton: false
        });
    @endif

    @if (session()->has('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session("error") }}',
            timer: 5000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showConfirmButton: false
        });
    @endif
});
</script>