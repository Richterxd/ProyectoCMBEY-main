<div class="min-h-screen bg-gray-50">
        <style>
        @supports(-webkit-appearance: none) or (-moz-appearance: none) {
            input[type='checkbox'],
            input[type='radio'] {
                --active: #275EFE;
                --active-inner: #fff;
                --focus: 2px rgba(39, 94, 254, .3);
                --border: #BBC1E1;
                --border-hover: #275EFE;
                --background: #fff;
                --disabled: #F6F8FF;
                --disabled-inner: #E1E6F9;
                -webkit-appearance: none;
                -moz-appearance: none;
                height: 21px;
                outline: none;
                display: inline-block;
                vertical-align: top;
                position: relative;
                margin: 0;
                border: 1px solid var(--bc, var(--border));
                background: var(--b, var(--background));
                transition: background .3s, border-color .3s, box-shadow .2s;
                &:after {
                content: '';
                display: block;
                left: 0;
                top: 0;
                position: absolute;
                transition: transform var(--d-t, .3s) var(--d-t-e, ease), opacity var(--d-o, .2s);
                }
                &:checked {
                --b: var(--active);
                --bc: var(--active);
                --d-o: .3s;
                --d-t: .6s;
                --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
                }
                &:disabled {
                --b: var(--disabled);
                cursor: not-allowed;
                opacity: .9;
                &:checked {
                    --b: var(--disabled-inner);
                    --bc: var(--border);
                }
                & + label {
                    cursor: not-allowed;
                }
                }
                &:hover {
                &:not(:checked) {
                    &:not(:disabled) {
                    --bc: var(--border-hover);
                    }
                }
                }
                &:focus {
                box-shadow: 0 0 0 var(--focus);
                }
                &:not(.switch) {
                width: 21px;
                &:after {
                    opacity: var(--o, 0);
                }
                &:checked {
                    --o: 1;
                }
                }
                & + label {
                font-size: 14px;
                line-height: 21px;
                display: inline-block;
                vertical-align: top;
                margin-left: 4px;
                }
            }
            input[type='checkbox'] {
                &:not(.switch) {
                border-radius: 7px;
                &:after {
                    width: 5px;
                    height: 9px;
                    border: 2px solid var(--active-inner);
                    border-top: 0;
                    border-left: 0;
                    left: 7px;
                    top: 4px;
                    transform: rotate(var(--r, 20deg));
                }
                &:checked {
                    --r: 43deg;
                }
                }
                &.switch {
                width: 38px;
                border-radius: 11px;
                &:after {
                    left: 2px;
                    top: 2px;
                    border-radius: 50%;
                    width: 15px;
                    height: 15px;
                    background: var(--ab, var(--border));
                    transform: translateX(var(--x, 0));
                }
                &:checked {
                    --ab: var(--active-inner);
                    --x: 17px;
                }
                &:disabled {
                    &:not(:checked) {
                    &:after {
                        opacity: .6;
                    }
                    }
                }
                }
            }
    </style>
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-file-blank text-white text-xl'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Solicitudes</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if($activeTab !== 'create' && Auth::user()->isSuperAdministrador())
                        <button wire:click="setActiveTab('create')" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Solicitud
                        </button>
                    @endif
                    @if($activeTab !== 'list' && count($solicitudes) > 0)
                        <button wire:click="setActiveTab('list')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Ver Solicitudes
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($deleteSolicitud)
        <div class="fixed inset-0 bg-black/10 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class='bx bx-trash text-red-600 text-xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h3>
                            <p class="text-sm text-gray-600">Esta acción no se puede deshacer</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-6">
                        ¿Estás seguro de que deseas eliminar esta solicitud? Se perderán todos los datos asociados.
                    </p>
                    <p class="text-sm text-gray-400">ID: {{ $deleteSolicitud->solicitud_id }} - {{$deleteSolicitud->persona->nombre}} {{$deleteSolicitud->persona->apellido}}</p>
                    
                    <div class="flex justify-end space-x-4">
                        <button wire:click="cancelDelete" 
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="deleteSolicitudDefinitive" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($activeTab === 'list')
            <!-- Solicitudes List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl max-md:text-md font-semibold text-gray-900">
                            <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                            @if(Auth::user()->isSuperAdministrador())
                                Todas las Solicitudes
                            @elseif(Auth::user()->isAdministrador())
                                Solicitudes (Solo Lectura)
                            @endif
                        </h2>
                        <div class="flex items-center justify-end space-x-2">
                            <div class="relative" x-data="{selectActive: 0}">
                                <div class="w-full h-full rounded-lg flex items-center justify-center cursor-pointer transition-colors border border-gray-300 hover:bg-gray-100"
                                    @click="selectActive = selectActive === 1 ? 0 : 1">
                                    
                                    
                                    <i class='bx bx-filter text-black/60 text-xl max-md:py-2 px-1'></i>
                                    <span class="py-2 px-1 inline-flex text-sm leading-5 rounded-full text-black/60  max-md:hidden">
                                        {{$estadoSolicitud === 'Aprobada' ? 'Aprobadas' : 
                                        ($estadoSolicitud === 'Rechazada' ? 'Rechazadas' :
                                        ($estadoSolicitud === 'Asignada' ? 'Asignadas': 'Pendientes'))}}
                                    </span>
                                    <i class='bx bx-caret-down text-xl mr-1 text-black/65'
                                    :class="{
                                        'transform rotate-180': selectActive === 1,
                                    }"></i>

                                </div>
                                <div class="absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg"
                                    x-show="selectActive === 1" x-transition @click.away="selectActive = 0" x-cloak x-bind
                                    :class="{
                                        'hidden': selectActive !== 1,
                                    }">
                                    <ul>
                                        <li class="text-black/60 p-2 transition-colors cursor-default hover:bg-gray-100 hover:text-gray-800"
                                        wire:click="ordenEstados('Pendiente')">Pendientes</li>
                                        <li class="text-black/60 p-2 transition-colors cursor-default hover:bg-gray-100 hover:text-gray-800"
                                        wire:click="ordenEstados('Aprobada')">Aprobadas</li>
                                        <li class="text-black/60 p-2 transition-colors cursor-default hover:bg-gray-100 hover:text-gray-800"
                                        wire:click="ordenEstados('Rechazada')">Rechazadas</li>
                                        <li class="text-black/60 p-2 transition-colors cursor-default hover:bg-gray-100 hover:text-gray-800"
                                        wire:click="ordenEstados('Asignada')">Asignadas</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="relative w-full sm:w-auto">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar solicitud..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('solicitud_id')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-purchase-tag-alt'></i>
                                            Solicitud
                                        </div>
                                        @if ($sort == 'solicitud_id')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('categoria')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-folder'></i>
                                            Categoría
                                        </div>
                                        @if ($sort == 'categoria')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('fecha_creacion')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-group'></i>
                                            D/P
                                        </div>
                                        @if ($sort == 'derecho_palabra')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('fecha_creacion')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-calendar-alt'></i>
                                            Fecha
                                        </div>
                                        @if ($sort == 'fecha_creacion')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="orden('persona.nombre')">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <i class='bx bx-user'></i>
                                                Solicitante
                                            </div>
                                            @if ($sort == 'persona.nombre')
                                                @if ($direction == 'asc')
                                                    <i class='bx bx-caret-up mr-2'></i>
                                                @else
                                                    <i class='bx bx-caret-down mr-2'></i>
                                                @endif
                                            @else
                                                <i class='bx bx-carets-up-down mr-2'></i>
                                            @endif
                                        </div>
                                    </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    <div class="flex justify-start items-center">
                                        <i class='bx bx-cog'></i>
                                        Acciones
                                    </div>
                                </th>
                                @if(Auth::user()->isSuperAdministrador())
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <i class='bx bx-check-shield'></i>
                                                Cambiar el Estado
                                            </div>
                                        </div>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($solicitudes as $solicitud)
                                <tr class="hover:bg-gray-50">
                                    <td class="flex items-center px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 w-60 truncate " title="{{ $solicitud->titulo }}">
                                                {{ $solicitud->titulo }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: {{ $solicitud->solicitud_id }}
                                            </div>
                                        </div>
                                        @if ($solicitud->fecha_actualizacion_usuario)
                                            <i class="bx bx-edit bg-gray-300/70 text-gray-800 p-1 ml-2 rounded-full" title="Solicitud editada por el solicitante"></i>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $solicitud->categoria_formatted }}</div>
                                        <div class="text-sm text-gray-500">{{ $solicitud->subcategoria_formatted }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" title="Derecho de palabra">
                                        @if ($solicitud->derecho_palabra)
                                            <div class="w-5 h-5 bg-blue-600 rounded-full shadow-md shadow-blue-400 relative justify-center" title="Derecho de palabra"></div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $solicitud->fecha_creacion->format('d/m/Y') }}
                                    </td>
                                    @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $solicitud->persona->nombre ?? 'N/A' }} {{ $solicitud->persona->apellido ?? '' }}
                                        </td>
                                    @endif
                                    <td class="px-2 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- View Button -->
                                            <button wire:click="viewSolicitud({{ $solicitud->solicitud_id }})" 
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Ver detalles">
                                                <i class='bx bx-show'></i>
                                            </button>
                                            
                                            <!-- Edit Button -->
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="editSolicitud({{ $solicitud->solicitud_id }})" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="Editar">
                                                    <i class='bx bx-edit'></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Delete Button -->
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="confirmDelete({{ $solicitud->solicitud_id }})"
                                                class="p-2 text-red-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="Eliminar">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            @endif
                                            
                                        </div>
                                    </td>
                                    <!-- Status Change (Super Admin Only) -->
                                    @if(Auth::user()->isSuperAdministrador())
                                        <td class="flex items-center justify-end space-x-2 px-6 py-4 whitespace-nowrap" x-data="{selectActiveUpdateStatus: 0}">
                                            <div class="relative items-center space-x-1">
                                                <div class="w-30 h-7 rounded-full flex items-center justify-center cursor-pointer transition-colors border
                                                    {{ $solicitud->estado_detallado === 'Aprobada' ? 'bg-green-100 hover:bg-green-200 border-green-300' : 
                                                    ($solicitud->estado_detallado  === 'Pendiente' ? 'bg-yellow-100 hover:bg-yellow-200 border-yellow-300' : 
                                                    ($solicitud->estado_detallado  === 'Rechazada' ? 'bg-red-100 hover:bg-red-200 border-red-300' : 
                                                    ($solicitud->estado_detallado  === 'Asignada' ? 'bg-blue-100 hover:bg-blue-200 border-blue-300': 'bg-gray-100 text-gray-800 border-gray-300'))) }}"
                                                    @click="selectActiveUpdateStatus = selectActiveUpdateStatus === 1 ? 0 : 1">
                                                        
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $solicitud->estado_detallado  === 'Aprobada' ? 'text-green-800' : 
                                                        ($solicitud->estado_detallado  === 'Pendiente' ? 'text-yellow-800' : 
                                                        ($solicitud->estado_detallado  === 'Rechazada' ? 'text-red-800' : 
                                                        ($solicitud->estado_detallado  === 'Asignada' ? 'text-blue-800' : 'text-gray-800'))) }}">
                                                        {{$solicitud->estado_detallado  === 'Aprobada' ? 'Aprobadas' : 
                                                        ($solicitud->estado_detallado  === 'Rechazada' ? 'Rechazadas' :
                                                        ($solicitud->estado_detallado  === 'Asignada' ? 'Asignadas': 'Pendientes'))}}
                                                    </span>

                                                    <i class='bx bx-caret-down text-xl
                                                    {{ $solicitud->estado_detallado  === 'Aprobada' ? 'text-green-800' : 
                                                    ($solicitud->estado_detallado  === 'Pendiente' ? 'text-yellow-800/70' : 
                                                    ($solicitud->estado_detallado  === 'Rechazada' ? 'text-red-800' : 
                                                    ($solicitud->estado_detallado  === 'Asignada' ? ' text-blue-800' : 'text-gray-500'))) }}'
                                                    :class="{
                                                        'transform rotate-180': selectActiveUpdateStatus === 1,
                                                    }"></i>

                                                </div>
                                                <div class="absolute w-30 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-30"
                                                    x-show="selectActiveUpdateStatus === 1" x-transition @click.away="selectActiveUpdateStatus = 0" x-cloak x-bind
                                                    :class="{
                                                        'hidden': selectActiveUpdateStatus !== 1,
                                                    }">
                                                    <ul>
                                                        <li class="p-2 transition-colors cursor-default hover:bg-yellow-100 hover:text-yellow-800"
                                                        wire:click="updateStatus({{ $solicitud->solicitud_id }}, 'Pendiente')">Pendiente</li>
                                                        <li class="p-2 transition-colors cursor-default hover:bg-green-100 hover:text-green-800"
                                                        wire:click="updateStatus({{ $solicitud->solicitud_id }}, 'Aprobada')">Aprobadar</li>
                                                        <li class="p-2 transition-colors cursor-default hover:bg-red-100 hover:text-red-800"
                                                        wire:click="updateStatus({{ $solicitud->solicitud_id }}, 'Rechazada')">Rechazadar</li>
                                                        <li class="p-2 transition-colors cursor-default hover:bg-blue-100 hover:text-blue-800"
                                                        wire:click="updateStatus({{ $solicitud->solicitud_id }}, 'Asignada')">Asignar</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($solicitudesRender->isEmpty() && $solicitudesRender->currentPage() == 1)
                        <div class="text-center py-8">
                            <i class='bx bx-file text-4xl text-gray-400 mb-4'></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay solicitudes</h3>
                            <p class="text-gray-500">
                                No se encontraron solicitudes en el sistema
                            </p>
                        </div>
                    @else
                        <div class="mx-5">
                            {{ $solicitudesRender->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

        @if($activeTab === 'create' || $activeTab === 'edit' && $editingSolicitud)
            <!-- Create/Edit Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $editingSolicitud ? 'Editar Solicitud' : 'Nueva Solicitud Completa' }}
                            </h2>
                            <div class="flex items-center space-x-2">
                                @if($editingSolicitud)
                                    <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-edit mr-1'></i>
                                        Editando
                                    </div>
                                @else
                                    <div class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-plus mr-1'></i>
                                        Creando
                                    </div>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600">Complete todos los campos requeridos para {{ $editingSolicitud ? 'actualizar' : 'crear' }} su solicitud</p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? '✓' : '1' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'text-blue-600' : 'text-gray-500' }}">Datos Personales</span>
                                </div>
                                <div class="max-lg:hidden w-8 h-1 {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $categoria ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $categoria ? '✓' : '2' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $categoria ? 'text-blue-600' : 'text-gray-500' }}">Categoría</span>
                                </div>
                                <div class="max-lg:hidden w-8 h-1 {{ $categoria && $subcategoria ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $detailedAddress['parroquia'] && $detailedAddress['comunidad'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $detailedAddress['parroquia'] && $detailedAddress['comunidad'] ? '✓' : '3' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $detailedAddress['parroquia'] && $detailedAddress['comunidad'] ? 'text-blue-600' : 'text-gray-500' }}">Ubicación</span>
                                </div>
                                <div class="max-lg:hidden w-8 h-1 {{ strlen($descripcion) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ strlen($descripcion) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strlen($descripcion) >= 50 ? '✓' : '4' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ strlen($descripcion) >= 50 ? 'text-blue-600' : 'text-gray-500' }}">Descripción</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-8">
                        
                        <!-- Step 1: Personal Data Display -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-user text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Datos Personales</h3>
                                    @if($personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'])
                                        <p class="text-sm text-gray-600">Información registrada en el sistema</p>
                                    @else
                                        <p class="text-sm text-gray-600">Ingresar información personal</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cédula de Identidad</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-id-card text-blue-600 mr-2'></i>
                                        @if($personalData['cedula'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['cedula'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="text" maxlength="8" wire:model.live="personalData.cedula" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Cédula...">
                                        @endif
                                    </div>
                                    @error('personalData.cedula') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-user text-blue-600 mr-2'></i>
                                        @if($personalData['nombre_completo'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['nombre_completo'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="text" wire:model.live="personalData.nombre_completo" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Nombre Completo...">
                                        @endif
                                    </div>
                                    @error('personalData.nombre_completo') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-envelope text-blue-600 mr-2'></i>
                                        @if($personalData['email'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['email'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="email" wire:model.live="personalData.email" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Correo...">
                                        @endif
                                    </div>
                                    @error('personalData.email') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-phone text-blue-600 mr-2'></i>
                                        @if($personalData['telefono'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['telefono'] ?? 'No registrado' }}</span>
                                        @else
                                        <input type="text" id="telefono_solicitud" wire:model.live="personalData.telefono" class="font-medium text-gray-900 focus:outline-none"                 
                                            pattern="\d{4}-\d{3}-\d{4}"
                                            oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3').slice(0, 13);"
                                            placeholder="XXXX-XXX-XXXX" maxlength="13">
                                        @endif
                                    </div>
                                    @error('personalData.telefono') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Category Selection -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-category text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Categoría de Solicitud</h3>
                                    <p class="text-sm text-gray-600">Seleccione el tipo de solicitud que desea realizar</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($categories as $key => $category)
                                    <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                        {{ $categoria === $key ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                        wire:click="$set('categoria', '{{ $key }}')">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                <i class='bx {{ $category['icon'] }} text-3xl text-blue-600'></i>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $category['title'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ count($category['subcategories']) }} opciones</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categoria') 
                                <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Subcategory Selection -->
                            @if ($categoria)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4">
                                        Subcategorías de {{ $categories[$categoria]['title'] }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach ($categories[$categoria]['subcategories'] as $key => $subcategory)
                                            <div class="border-2 rounded-lg p-4 cursor-pointer transition-all duration-300 hover:shadow-md
                                                {{ $subcategoria === $key ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}"
                                                wire:click="$set('subcategoria', '{{ $key }}')">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                                        <i class='bx bx-check text-white text-sm'></i>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $subcategory }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('subcategoria') 
                                        <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Step 3: Location Details -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-map text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Ubicación de la Solicitud</h3>
                                    <p class="text-sm text-gray-600">Proporcione los detalles de ubicación donde se requiere el servicio</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">País</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-world text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['pais'] }}</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-map-pin text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['estado_region'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Municipio</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-buildings text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['municipio'] }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Parroquia *</label>
                                            <select wire:model.live="detailedAddress.parroquia" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                                <option value="" disabled selected>Seleccione una parroquia</option>
                                                @foreach ($parroquias as $key => $parroquia)
                                                    <option value="{{$key}}">{{$parroquia}}</option>
                                                @endforeach
                                            </select>
                                            @error('detailedAddress.parroquia') 
                                                <div class="flex items-center text-red-600 text-sm mt-1">
                                                    <i class='bx bx-error-circle mr-1'></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Comunidad *</label>
                                            <select wire:model.live="detailedAddress.comunidad" @if(!$detailedAddress['parroquia']) disabled @endif
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @if(!$detailedAddress['parroquia']) bg-gray-100 cursor-not-allowed @endif">
                                                <option value="" disabled selected>Seleccione una comunidad</option>
                                                <option value="OTRO...">OTRO...</option>
                                                @foreach ($sectores as $sector)
                                                    @if ($sector->parroquia === 'CHIVACOA' && $detailedAddress['parroquia'] === 'chivacoa')
                                                        <option value="{{$sector->sector}}">{{$sector->sector}}</option>
                                                    @elseif($sector->parroquia === 'CAMPO_ELIAS' && $detailedAddress['parroquia'] === 'campo_elias')
                                                        <option value="{{$sector->sector}}">{{$sector->sector}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('detailedAddress.comunidad') 
                                                <div class="flex items-center text-red-600 text-sm mt-1">
                                                    <i class='bx bx-error-circle mr-1'></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Detallada *</label>
                                    <textarea wire:model.live="detailedAddress.direccion_detallada" rows="4" 
                                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Proporcione la dirección completa incluyendo puntos de referencia importantes..."></textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            <span>Caracteres: {{ strlen($detailedAddress['direccion_detallada']) }}/200 (mínimo 10)</span>
                                        </div>
                                        <div class="flex items-center">
                                            @if($detailedAddress['direccion_detallada'])
                                                @if(strlen($detailedAddress['direccion_detallada']) >= 10 && strlen($detailedAddress['direccion_detallada']) <= 200)
                                                    <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                    <span class="text-green-600 text-sm font-medium">Válida</span>
                                                @elseif(strlen($detailedAddress['direccion_detallada']) < 10)
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                                @else
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @error('detailedAddress.direccion_detallada') 
                                        <div class="flex justify-end items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Description -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-edit text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Descripción de la Solicitud</h3>
                                    <p class="text-sm text-gray-600">Describa detalladamente su solicitud (mínimo 50 caracteres)</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Titulo *</label>
                                <input type="text" wire:model.live="titulo" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Escriba un breve titulo para su solicitud">
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        <span>Caracteres: {{ strlen($titulo) }}/50 (mínimo 5)</span>
                                    </div>
                                    <div class="flex items-center">
                                        @if($titulo)
                                            @if(strlen($titulo) >= 5 && strlen($titulo) <= 50)
                                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                <span class="text-green-600 text-sm font-medium">Válida</span>
                                            @elseif(strlen($titulo) < 5)
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                            @else
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                @error('titulo') 
                                    <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                    
                                <textarea wire:model.live="descripcion" rows="8" 
                                          class="w-full p-4 mt-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                          placeholder="Describa detalladamente su solicitud. Incluya información relevante como el problema específico"></textarea>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        <span>Caracteres: {{ strlen($descripcion) }}/5000 (mínimo 50)</span>
                                    </div>
                                    <div class="flex items-center">
                                        @if($descripcion)
                                            @if(strlen($descripcion) >= 50 && strlen($descripcion) <= 5000)
                                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                <span class="text-green-600 text-sm font-medium">Válida</span>
                                            @elseif(strlen($descripcion) < 50)
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                            @else
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                @error('descripcion') 
                                    <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Super Admin Only Fields -->
                        @if(Auth::user()->isSuperAdministrador())
                            <div class="">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class='bx bx-map text-blue-600 text-xl'></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Administración</h3>
                                        <p class="text-sm text-gray-600">Observaciones de la solicitud</p>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <textarea wire:model="observaciones_admin" rows="3" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Escribir una observación o inquietud {{$tipo_solicitud}}"></textarea>
                                </div>
                            </div>
                        @endif

                        <!-- Checkbox Derecho de Palabra -->
                        <div class="flex justify-between space-x-6 mt-4 max-md:flex-col">
                            <div class="flex justify-start gap-2 items-center max-md:justify-between">
                                <input type="radio" wire:model.live="tipo_solicitud" id="radio1_tipo_solicitud" value="individual" class="rounded-full" 
                                title="Seleccionar esta opción si su solicitud es para su beneficio personal">
                                <label for="radio1_tipo_solicitud" title="Seleccionar esta opción si su solicitud es para su beneficio personal">Solicitud personal</label>
                                <input type="radio" wire:model.live="tipo_solicitud" id="radio2_tipo_solicitud" value="colectivo_institucional" class="rounded-full" 
                                title="Seleccionar esta opción si su solicitud es para fines colectevos institucionales">
                                <label for="radio2_tipo_solicitud" title="Seleccionar esta opción si su solicitud es para fines colectevos institucionales">Solicitud para un Colectivo Institucional</label>
                            </div>
                            <div class="flex items-center justify-end space-x-6 max-md:mt-8">
                                <div class="flex justify-end gap-2 items-center">
                                    <input wire:model.live="derecho_palabra" id="s1" type="checkbox" class="switch">
                                    <label for="s1">Solicitar Derecho de Palabra</label>
                                </div>
                            </div>
                        </div>
                        @error('tipo_solicitud') 
                            <div class="flex justify-end items-center text-red-600 text-sm mt-1">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center pt-8 border-t border-gray-200 space-y-4 sm:space-y-0"
                        :class="{
                            'justify-between': @json($activeTab === 'create' && !$editingSolicitud),
                            'justify-end': @json(!($activeTab === 'create' && !$editingSolicitud))
                        }">
                            @if($activeTab === 'create' && !$editingSolicitud)
                                <button type="button" wire:click="resetForm" 
                                        class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                    <i class='bx bx-refresh mr-2'></i>
                                    Reiniciar Formulario
                                </button>
                            @endif

                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <button type="button" wire:click="setActiveTab('list')"
                                       class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                    <i class='bx bx-arrow-back mr-2'></i>
                                    Cancelar
                                </button>
                                <button type="submit" 
                                        class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                                    <i class='bx {{ $editingSolicitud ? 'bx-save' : 'bx-check' }} mr-2'></i>
                                    {{ $editingSolicitud ? 'Actualizar Solicitud' : 'Crear Solicitud' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- View -->
        @if($activeTab === 'show' && $showSolicitud)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class='bx bx-show text-blue-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Detalle de Solicitud</h3>
                                <p class="text-sm text-gray-600">ID: {{ $showSolicitud->solicitud_id }}</p>
                            </div>
                        </div>
                        @if($activeTab !== 'create' && Auth::user()->isSuperAdministrador())
                            <button wire:click="editSolicitud('{{$showSolicitud->solicitud_id}}')" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                <i class='bx bx-edit mr-2'></i>
                                Editar la Solicitud
                            </button>
                        @endif
                    </div>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900 font-medium">{{ $showSolicitud->titulo }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estados</label>
                            <div class="p-3 bg-gray-50 rounded-lg space-x-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($showSolicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($showSolicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                    @elseif($showSolicitud->estado_detallado === 'Rechazada') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $showSolicitud->estado_detallado }}
                                </span>
                                @if($showSolicitud->derecho_palabra)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-600/20 text-blue-800">
                                        Derecho de Palabra
                                    </span>
                                @endif
                                @if($showSolicitud->fecha_actualizacion_usuario)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-600/20">
                                        Editado por el solicitante
                                    </span>
                                @endif
                                @if($showSolicitud->fecha_actualizacion_super_admin)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-600/20">
                                        Editado por la Administración
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $categories[$showSolicitud->categoria]['title'] ?? 'Sin categoría' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subcategoría</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $categories[$showSolicitud->categoria]['subcategories'][$showSolicitud->subcategoria] ?? 'Sin subcategoría' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-900">{{ $showSolicitud->descripcion }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Parroquia</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $showSolicitud->parroquia_formatted  }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comunidad</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $showSolicitud->comunidad }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Detallada</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-900">{{ $showSolicitud->direccion_detallada }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Creación</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $showSolicitud->fecha_creacion->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Última Actualización del Usuario</label>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-gray-900">@if($showSolicitud->fecha_actualizacion_usuario) {{$showSolicitud->fecha_actualizacion_usuario->format('d/m/Y H:i') }} @else N/A @endif</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Última Actualización de la Administración</label>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-gray-900">@if($showSolicitud->fecha_actualizacion_super_admin) {{$showSolicitud->fecha_actualizacion_super_admin->format('d/m/Y H:i') }} @else N/A @endif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Solicitud</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $showSolicitud->tipo_solicitud_formatted }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-200">
                    <button type="button" wire:click="setActiveTab('list')"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        <i class='bx bx-arrow-back mr-2'></i>
                        Regresar Atras
                    </button>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('element.updated', () => {
                initToggles();
                initInputs();
            });

            const initInputs = () => {
                const phoneInput = document.getElementById('telefono_solicitud');
                if (phoneInput) {
                    const newPhoneInput = phoneInput.cloneNode(true);
                    phoneInput.parentNode.replaceChild(newPhoneInput, phoneInput);
                    
                    newPhoneInput.addEventListener('input', (e) => {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 3) {
                            value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 11);
                        }
                        e.target.value = value;
                    });
                }
            };

            initToggles();
            initInputs();
        });
    </script>
</div>