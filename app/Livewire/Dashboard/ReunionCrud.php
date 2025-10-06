<?php

namespace App\Livewire\Dashboard;

use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ReunionCrud extends Component
{
    use WithPagination;

    public $activeTab = 'list';
    public $reuniones;
    public $selectedReunion = null;
    public $editingReunion = null;
    public $showingModal = false;
    
    // Form fields
    public $titulo = '';
    public $descripcion = '';
    public $fecha_reunion = '';
    public $ubicacion = '';
    public $solicitud_id = '';
    public $institucion_id = '';
    public $asistentes = [];
    public $concejal = '';
    
    // Available data for selects
    public $solicitudes = [];
    public $instituciones = [];
    public $personas = [];
    
    // Status options
    public $estadosSolicitud = [
        'Pendiente' => 'Pendiente',
        'Aprobada' => 'Aprobada', 
        'Rechazada' => 'Rechazada',
        'Asignada' => 'Asignada'
    ];

    protected $rules = [
        'titulo' => 'required|min:5|max:200',
        'descripcion' => 'nullable|max:1000',
        'fecha_reunion' => 'required|date|after_or_equal:today',
        'ubicacion' => 'required|min:5|max:200',
        'solicitud_id' => 'required|exists:solicitudes,id',
        'institucion_id' => 'required|exists:instituciones,id',
        'asistentes' => 'required|array|min:1',
        'concejal' => 'required'
    ];

    public function mount()
    {
        $this->loadReuniones();
        $this->loadSelectData();
    }

    public function loadReuniones()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador() || $user->isAdministrador()) {
            // Super admin and admin can see all reuniones
            $this->reuniones = Reunion::with(['solicitud', 'institucion', 'asistentes'])
                ->orderBy('fecha_reunion', 'desc')
                ->get();
        } else {
            // Users can only see reuniones related to their solicitudes
            $this->reuniones = Reunion::with(['solicitud', 'institucion', 'asistentes'])
                ->whereHas('solicitud', function($query) use ($user) {
                    $query->where('persona_cedula', $user->persona_cedula);
                })
                ->orderBy('fecha_reunion', 'desc')
                ->get();
        }
    }

    public function loadSelectData()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            // Super admin can create reuniones for any solicitud
            $this->solicitudes = Solicitud::select('id', 'titulo', 'solicitud_id')->get();
        } elseif ($user->isAdministrador()) {
            // Admin can see all but only create for approved solicitudes
            $this->solicitudes = Solicitud::select('id', 'titulo', 'solicitud_id')
                ->where('estado_detallado', 'Aprobada')
                ->get();
        } else {
            // Users can only create reuniones for their own solicitudes
            $this->solicitudes = Solicitud::select('id', 'titulo', 'solicitud_id')
                ->where('persona_cedula', $user->persona_cedula)
                ->get();
        }
        
        $this->instituciones = Institucion::select('id', 'titulo')->get();
        $this->personas = Personas::select('cedula', 'nombre', 'apellido')->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function viewReunion($reunionId)
    {
        $this->selectedReunion = Reunion::with(['solicitud', 'institucion', 'asistentes'])
            ->find($reunionId);
        
        if (!$this->selectedReunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        // Check permissions
        if (!$this->canViewReunion($this->selectedReunion)) {
            session()->flash('error', 'No tienes permisos para ver esta reunión');
            return;
        }
        
        $this->showingModal = true;
    }

    public function editReunion($reunionId)
    {
        $reunion = Reunion::with('asistentes')->find($reunionId);
        
        if (!$reunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        if (!$this->canEditReunion($reunion)) {
            session()->flash('error', 'No tienes permisos para editar esta reunión');
            return;
        }
        
        $this->editingReunion = $reunion;
        $this->titulo = $reunion->titulo;
        $this->descripcion = $reunion->descripcion;
        $this->fecha_reunion = $reunion->fecha_reunion->format('Y-m-d\TH:i');
        $this->ubicacion = $reunion->ubicacion;
        $this->solicitud_id = $reunion->solicitud_id;
        $this->institucion_id = $reunion->institucion_id;
        $this->asistentes = $reunion->asistentes->pluck('cedula')->toArray();
        
        // Find the concejal
        $concejal = $reunion->asistentes->where('pivot.es_concejal', true)->first();
        $this->concejal = $concejal ? $concejal->cedula : '';
        
        $this->activeTab = 'edit';
    }

    public function createReunion()
    {
        $this->validate();
        
        if (!Auth::user()->isSuperAdministrador() && !Auth::user()->isAdministrador()) {
            session()->flash('error', 'No tienes permisos para crear reuniones');
            return;
        }
        
        try {
            $reunion = Reunion::create([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'fecha_reunion' => $this->fecha_reunion,
                'ubicacion' => $this->ubicacion,
                'solicitud_id' => $this->solicitud_id,
                'institucion_id' => $this->institucion_id,
            ]);
            
            // Attach asistentes with concejal designation
            $asistentesData = [];
            foreach ($this->asistentes as $cedula) {
                $asistentesData[$cedula] = ['es_concejal' => ($cedula === $this->concejal)];
            }
            
            $reunion->asistentes()->sync($asistentesData);
            
            $this->resetForm();
            $this->activeTab = 'list';
            $this->loadReuniones();
            
            session()->flash('success', 'Reunión creada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la reunión: ' . $e->getMessage());
        }
    }

    public function updateReunion()
    {
        if (!$this->editingReunion) {
            session()->flash('error', 'No hay reunión seleccionada para editar');
            return;
        }
        
        if (!$this->canEditReunion($this->editingReunion)) {
            session()->flash('error', 'No tienes permisos para editar esta reunión');
            return;
        }
        
        $this->validate();
        
        try {
            $this->editingReunion->update([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'fecha_reunion' => $this->fecha_reunion,
                'ubicacion' => $this->ubicacion,
                'solicitud_id' => $this->solicitud_id,
                'institucion_id' => $this->institucion_id,
            ]);
            
            // Update asistentes with concejal designation
            $asistentesData = [];
            foreach ($this->asistentes as $cedula) {
                $asistentesData[$cedula] = ['es_concejal' => ($cedula === $this->concejal)];
            }
            
            $this->editingReunion->asistentes()->sync($asistentesData);
            
            $this->resetForm();
            $this->activeTab = 'list';
            $this->loadReuniones();
            
            session()->flash('success', 'Reunión actualizada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la reunión: ' . $e->getMessage());
        }
    }

    public function deleteReunion($reunionId)
    {
        $reunion = Reunion::find($reunionId);
        
        if (!$reunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        if (!$this->canDeleteReunion($reunion)) {
            session()->flash('error', 'No tienes permisos para eliminar esta reunión');
            return;
        }
        
        try {
            // Detach asistentes first
            $reunion->asistentes()->detach();
            
            // Delete reunion
            $reunion->delete();
            
            $this->loadReuniones();
            session()->flash('success', 'Reunión eliminada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la reunión: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showingModal = false;
        $this->selectedReunion = null;
    }

    public function resetForm()
    {
        $this->titulo = '';
        $this->descripcion = '';
        $this->fecha_reunion = '';
        $this->ubicacion = '';
        $this->solicitud_id = '';
        $this->institucion_id = '';
        $this->asistentes = [];
        $this->concejal = '';
        $this->editingReunion = null;
        $this->resetValidation();
    }

    // Permission check methods
    private function canViewReunion($reunion)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador() || $user->isAdministrador()) {
            return true;
        }
        
        // Users can only view reuniones related to their solicitudes
        return $reunion->solicitud && $reunion->solicitud->persona_cedula === $user->persona_cedula;
    }

    private function canEditReunion($reunion)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        if ($user->isAdministrador()) {
            return true; // Admins can edit reuniones
        }
        
        return false; // Regular users cannot edit reuniones
    }

    private function canDeleteReunion($reunion)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        return false; // Only super admin can delete reuniones
    }

    public function render()
    {
        return view('livewire.dashboard.reunion-crud')->layout('components.layouts.rbac');
    }
}