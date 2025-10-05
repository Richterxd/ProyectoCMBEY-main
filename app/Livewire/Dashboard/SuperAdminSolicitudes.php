<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Ambito;
use App\Models\Personas;
use App\Models\Sectores;
use App\Models\SolicitudPersonaAsociada;
use App\Models\Trabajador;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;    
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\search;

class SuperAdminSolicitudes extends Component
{
    use WithPagination;

    // pagination theme
    protected $paginationTheme = 'disenoPagination'; 

    //ordenar solicitudes
    public $search = '', $sort = 'fecha_creacion', $direction = 'desc';
    public $estadoSolicitud = 'Pendiente';
    public $solicitudes = [];

    public $solicitudEstados = [
        'Pendiente' => 'Pendiente',
        'Aprobada' => 'Aprobada',
        'Rechazada' => 'Rechazada',
        'Asignada' => 'Asignada'
    ];

    //cambiar vistas
    public $activeTab = 'list';

    //data
    public $showSolicitud = null;
    public $editingSolicitud = null;
    public $deleteSolicitud = null;

    
    // Personal data (read-only from database)
    public $personalData = [
        'cedula' => '',
        'nombre_completo' => '',
        'telefono' => '',
        'email' => ''
    ];

    // Form fields
    public $titulo = '';
    public $categoria = '';
    public $subcategoria = '';
    public $descripcion = '';
    public $derecho_palabra = false;
    public $tipo_solicitud = 'individual';
    
    // Admin fields
    public $estado_detallado = '';
    public $observaciones_admin = '';

    public $parroquias = [
        'chivacoa' => 'Chivacoa',
        'campo_elias' => 'Campo Elías',
    ];

    public $detailedAddress = [
        'pais' => 'Venezuela',
        'estado_region' => 'Yaracuy',
        'municipio' => 'Bruzual',
        'parroquia' => '',
        'comunidad' => '',
        'direccion_detallada' => ''
    ];
    
    public $sectores = '';
    
    public $categories = [
        'servicios' => [
            'title' => 'Servicios',
            'icon' => 'bx-wrench',
            'subcategories' => [
                'agua' => 'Agua',
                'electricidad' => 'Electricidad',
                'telecomunicaciones' => 'Telecomunicaciones',
                'gas_comunal' => 'Gas Comunal',
                'gas_directo_tuberia' => 'Gas Directo por Tubería'
            ]
        ],
        'social' => [
            'title' => 'Social',
            'icon' => 'bx-group',
            'subcategories' => [
                'educacion_inicial' => 'Educación Inicial',
                'educacion_basica' => 'Educación Básica',
                'educacion_secundaria' => 'Educación Secundaria',
                'educacion_universitaria' => 'Educación Universitaria'
            ]
        ],
        'sucesos_naturales' => [
            'title' => 'Sucesos Naturales',
            'icon' => 'bx-cloud-lightning',
            'subcategories' => [
                'huracanes' => 'Huracanes',
                'tormentas_tropicales' => 'Tormentas Tropicales',
                'terremotos' => 'Terremotos'
            ]
        ]
    ];

    protected $rules = [
        'personalData.nombre_completo' => 'required|max:100',
        'personalData.cedula' => 'required|min:7|max:8',
        'personalData.telefono' => 'required|max:13',
        'personalData.email' => 'required|email|max:100',
        'titulo' => 'required|min:5|max:50',
        'categoria' => 'required|in:servicios,social,sucesos_naturales',
        'subcategoria' => 'required',
        'detailedAddress.parroquia' => 'required|min:5|max:50',
        'detailedAddress.comunidad' => 'required|exists:sectores,sector',
        'detailedAddress.direccion_detallada' => 'required|min:10|max:200',
        'descripcion' => 'required|min:50|max:5000',
        'derecho_palabra' => 'boolean',
        'tipo_solicitud' => 'required|in:individual,colectivo_institucional',
    ];

    protected $messages = [
        'personalData.cedula.required' => 'La cédula es obligatoria',
        'personalData.cedula.min' => 'La cédula debe tener al menos 7 caracteres',
        'personalData.cedula.max' => 'La cédula no puede exceder los 8 caracteres',
        'personalData.email.email' => 'El correo electrónico debe ser una dirección válida',
        'personalData.email.required' => 'El correo electrónico es obligatorio',
        'personalData.email.max' => 'El correo electrónico no puede exceder los 100 caracteres',
        'personalData.telefono.required' => 'El teléfono es obligatorio',
        'personalData.telefono.max' => 'El teléfono no puede exceder los 13 caracteres',
        'personalData.nombre_completo.required' => 'El nombre completo es obligatorio',
        'personalData.nombre_completo.max' => 'El nombre completo no puede exceder los 100 caracteres',
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener al menos 5 caracteres',
        'titulo.max' => 'El título no puede exceder los 50 caracteres',
        'categoria.required' => 'La categoría es obligatoria',
        'categoria.in' => 'La categoría seleccionada no es válida',
        'subcategoria.required' => 'La subcategoría es obligatoria',
        'detailedAddress.parroquia.required' => 'La parroquia es obligatoria',
        'detailedAddress.parroquia.min' => 'La parroquia debe tener al menos 5 caracteres',
        'detailedAddress.parroquia.max' => 'La parroquia no puede exceder los 50 caracteres',
        'detailedAddress.comunidad.required' => 'La comunidad es obligatoria',
        'detailedAddress.comunidad.exists' => 'La comunidad no existe en nuestra base de datos',
        'detailedAddress.direccion_detallada.required' => 'La dirección detallada es obligatoria',
        'detailedAddress.direccion_detallada.min' => 'La dirección detallada debe tener al menos 10 caracteres',
        'detailedAddress.direccion_detallada.max' => 'La dirección detallada no puede exceder los 200 caracteres',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener al menos 50 caracteres',
        'descripcion.max' => 'La descripción no puede exceder los 5000 caracteres',
        'derecho_palabra.boolean' => 'El valor de derecho a la palabra debe ser verdadero o falso',
        'tipo_solicitud.required' => 'El tipo de solicitud es obligatorio',
        'tipo_solicitud.in' => 'El tipo de solicitud seleccionado no es válido',
    ];

    public function mount()
    {
        $this->sectores = Sectores::all();
        $this->resetForm();
        $this->loadSolicitudes();
    }

    public function loadSolicitudes()
    {
        if (Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador()) {
            
            $query = Solicitud::where('estado_detallado', $this->estadoSolicitud)->with(['persona', 'ambito']);

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('solicitud_id', 'like', '%' . $this->search . '%')
                        ->orWhere('titulo', 'like', '%' . $this->search . '%')
                        ->orWhere('categoria', 'like', '%' . $this->search . '%')
                        ->orWhere('derecho_palabra', 'like', '%' . $this->search . '%')
                        ->orWhere('subcategoria', 'like', '%' . $this->search . '%')
                        ->orWhere('fecha_creacion', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('persona', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orwhere('apellido', 'like', '%' . $this->search . '%');
                })->where('estado_detallado', $this->estadoSolicitud);
            }

            
            if (strpos($this->sort, '.') !== false) {
                list($table, $column) = explode('.', $this->sort);
                
                $query->leftJoin($table . 's', $table . 's.cedula', '=', 'solicitudes.' . $table . '_cedula')
                    ->select('solicitudes.*')
                    ->orderBy($table . 's.' . $column, $this->direction);
            } else {
                $query->orderBy($this->sort, $this->direction);
            }

            $this->solicitudes = $query->get();
            
            return $query->paginate(10);

        } else {
            $this->dispatch('show-message', [
                'message' => 'Error al cargar las solicitudes: No tienes permisos para ver esta sección',
                'type' => 'error'
            ]);
        }
    }

    //open create
    public function setActiveTab($tab)
    {
        if($tab === 'create' && !$this->canCreateSolicitud()){
            session()->flash('error', 'No tienes permisos para ver esta solicitud');
            return;
        }

        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function submit()
    {
        $this->validate(); 
        
        try {
            // Find appropriate ambito based on category and subcategory
            $ambitoTitle = $this->categories[$this->categoria]['title'] . ' - ' . 
                          $this->categories[$this->categoria]['subcategories'][$this->subcategoria];
            
            $ambito = Ambito::where('titulo', $ambitoTitle)->first();

            if (!$ambito) {
                $ambito = Ambito::first(); // Fallback to first ambito
            }
            
            if ($this->editingSolicitud && Auth::user()->isSuperAdministrador()) {
                // Update existing solicitud
                    
                if (!$this->canEditSolicitud($this->editingSolicitud)) {
                    session()->flash('error', 'No tienes permisos para editar esta solicitud');
                    return;
                }
                
                $this->editingSolicitud->update([
                    'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                    'descripcion' => $this->descripcion,
                    'categoria' => $this->categoria,
                    'subcategoria' => $this->subcategoria,
                    'tipo_solicitud' => $this->tipo_solicitud,
                    'pais' => $this->detailedAddress['pais'],
                    'estado_region' => $this->detailedAddress['estado_region'],
                    'municipio' => $this->detailedAddress['municipio'],
                    'parroquia' => $this->detailedAddress['parroquia'],
                    'comunidad' => $this->detailedAddress['comunidad'],
                    'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                    'estado_detallado' => $this->estado_detallado,
                    'fecha_actualizacion_super_admin' => now(),
                    'ambito_id' => $ambito->ambito_id,
                    'derecho_palabra' => $this->derecho_palabra,
                    'direccion' => $this->detailedAddress['direccion_detallada'],
                    'observaciones_admin' => $this->observaciones_admin,
                ]);
                
                $this->dispatch('show-message', [
                    'message' => 'Solicitud actualizada exitosamente',
                    'type' => 'success'
                ]);

            } else {

                $persona = Personas::find($this->personalData['cedula']);

                if (!$persona) {
                    Personas::create([
                        'cedula' => $this->personalData['cedula'],
                        'nombre' => $this->personalData['nombre_completo'],
                        'telefono' => $this->personalData['telefono'],
                        'email' => $this->personalData['email'],
                    ]);
                }
                
                // Create new solicitud
                $solicitudId = Solicitud::generateSolicitudId($this->personalData['cedula']);
                
                Solicitud::create([
                    'solicitud_id' => $solicitudId,
                    'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                    'descripcion' => $this->descripcion,
                    'categoria' => $this->categoria,
                    'subcategoria' => $this->subcategoria,
                    'tipo_solicitud' => $this->tipo_solicitud,
                    'pais' => $this->detailedAddress['pais'],
                    'estado_region' => $this->detailedAddress['estado_region'],
                    'municipio' => $this->detailedAddress['municipio'],
                    'parroquia' => $this->detailedAddress['parroquia'],
                    'comunidad' => $this->detailedAddress['comunidad'],
                    'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                    'estado_detallado' => 'Pendiente',
                    'fecha_creacion' => now(),
                    'persona_cedula' => $this->personalData['cedula'],
                    'ambito_id' => $ambito->ambito_id,
                    'derecho_palabra' => $this->derecho_palabra,
                    'direccion' => $this->detailedAddress['direccion_detallada'],
                ]);
                
                $this->estadoSolicitud = 'Pendiente';

                $this->dispatch('show-message', [
                    'message' => 'Solicitud creada exitosamente con ID: ' . $solicitudId,
                    'type' => 'success'
                ]);
            }
            
            $this->resetForm();
            $this->loadSolicitudes();
            $this->setActiveTab('list');
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function viewSolicitud($solicitudId)
    {
        $this->showSolicitud = Solicitud::with(['persona', 'ambito'])
            ->find($solicitudId);
        
        if (!$this->showSolicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        // Check permissions
        if (!$this->canViewSolicitud($this->showSolicitud)) {
            session()->flash('error', 'No tienes permisos para ver esta solicitud');
            return;
        }
        
        $this->activeTab = 'show';
    }

    public function editSolicitud($solicitudId)
    {
        $solicitud = Solicitud::with('persona')->find($solicitudId);
        
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        if (!$this->canEditSolicitud($solicitud)) {
            session()->flash('error', 'No tienes permisos para editar esta solicitud');
            return;
        }

        if (!$solicitud->persona) {
            session()->flash('error', 'Error de datos: La solicitud con ID ' . $solicitudId . ' no tiene una persona asociada válida.');
            return;
        }

        $this->personalData = [
            'cedula' => $solicitud->persona->cedula,
            'nombre_completo' => ($solicitud->persona->nombre ?? '') . ' ' . ($solicitud->persona->apellido ?? ''), 
            'telefono' => $solicitud->persona->telefono,
            'email' => $solicitud->persona->email
        ];
        
        $this->editingSolicitud = $solicitud;
        $this->titulo = str_replace($this->categories[$solicitud->categoria]['subcategories'][$solicitud->subcategoria] . ' - ', '', $solicitud->titulo);
        $this->descripcion = $solicitud->descripcion;
        $this->categoria = $solicitud->categoria;
        $this->subcategoria = $solicitud->subcategoria;
        $this->detailedAddress = [
            'pais' => $solicitud->pais ?? 'Venezuela',
            'estado_region' => $solicitud->estado_region ?? 'Yaracuy',
            'municipio' => $solicitud->municipio ?? 'Bruzual',
            'parroquia' => $solicitud->parroquia,
            'comunidad' => $solicitud->comunidad,
            'direccion_detallada' => $solicitud->direccion_detallada
        ];
        $this->estado_detallado = $solicitud->estado_detallado;
        $this->derecho_palabra = $solicitud->derecho_palabra;
        $this->tipo_solicitud = $solicitud->tipo_solicitud;
        $this->observaciones_admin = $solicitud->observaciones_admin;

        
        $this->activeTab = 'edit';
        $this->showSolicitud = null;
        $this->resetValidation();
    }

    public function confirmDelete($solicitudId)
    {
        $solicitud = Solicitud::with('persona')->find($solicitudId);
        
        if (!$solicitud) {
            $this->dispatch('show-message', [
                'message' => 'Solicitud no encontrada',
                'type' => 'error'
            ]);
            return;
        }

        if (!$this->canDeleteSolicitud($solicitud)) {
            session()->flash('error', 'No tienes permisos para eliminar esta solicitud');
            return;
        }
        
        $this->deleteSolicitud = $solicitud;
    }

    public function deleteSolicitudDefinitive()
    {
        $solicitud = Solicitud::find($this->deleteSolicitud->solicitud_id);
        
        if (!$solicitud) {
            $this->dispatch('show-message', [
                'message' => 'Solicitud no encontrada',
                'type' => 'error'
            ]);
            return;
        }

        if (!$this->canDeleteSolicitud($solicitud)) {
            session()->flash('error', 'No tienes permisos para eliminar esta solicitud');
            return;
        }
        
        try {
            
            if ($solicitud && Auth::user()->isSuperAdministrador()) {

                $solicitud->delete();
                
                $this->dispatch('show-message', [
                    'message' => 'Solicitud eliminada exitosamente',
                    'type' => 'success'
                ]);
                
                $this->loadSolicitudes();
            }
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al eliminar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
        
        $this->deleteSolicitud = null;
    }

    public function cancelDelete()
    {
        $this->deleteSolicitud = null;
    }

    public function updateStatus($solicitudId, $newStatus)
    {
        $solicitud = Solicitud::find($solicitudId);
        
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        if (!Auth::user()->isSuperAdministrador()) {
            session()->flash('error', 'No tienes permisos para cambiar el estado');
            return;
        }
        
        try {
            $solicitud->update([
                'estado_detallado' => $newStatus,
                'updated_at' => now()
            ]);
            
            $this->loadSolicitudes();
            session()->flash('success', 'Estado actualizado exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->personalData = [
            'cedula' => '',
            'nombre_completo' => '',
            'telefono' => '',
            'email' => ''
        ];

        $this->titulo = '';
        $this->descripcion = '';
        $this->categoria = '';
        $this->subcategoria = '';

        $this->detailedAddress = [
            'pais' => 'Venezuela',
            'estado_region' => 'Yaracuy',
            'municipio' => 'Bruzual',
            'parroquia' => '',
            'comunidad' => '',
            'direccion_detallada' => ''
        ];

        $this->estado_detallado = '';
        $this->observaciones_admin = '';
        $this->derecho_palabra = false;
        $this->tipo_solicitud = 'individual';

        $this->showSolicitud = null;
        $this->editingSolicitud = null;
        $this->resetValidation();
    }

    // Permission check methods
    private function canCreateSolicitud()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()){
            return true;
        }

        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return false; // Regular users can create
    }

    private function canViewSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador() || $user->isAdministrador()) {
            return true;
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }

    private function canEditSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }

    private function canDeleteSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }
    
   /*  ordernar labla */
    public function orden($sort)
    {
        if ($this->sort == $sort) {
            $this->direction = ($this->direction == 'asc') ? 'desc' : 'asc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function ordenEstados($estado){
        
        $this->estadoSolicitud = $estado;
    }

    public function render()
    {
        $solicitudesRender = $this->loadSolicitudes();

        return view('livewire.dashboard.super-admin-solicitudes' , [
            'solicitudesRender' => $solicitudesRender,
        ])->layout('components.layouts.rbac');
    }
}