<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas;
use Illuminate\Support\Facades\Auth;

class SuperAdminReuniones extends Component
{
    use WithPagination;

    public $activeTab = 'list';
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    // Form properties
    public $editingReunion;
    public $deleteReunion;
    public $titulo = '';
    public $descripcion = '';
    public $fecha_reunion = '';
    public $ubicacion = '';
    public $solicitud_id = '';
    public $institucion_id = '';
    public $asistentes = [];
    public $concejal = '';
    public $nuevo_estado_solicitud = '';

    protected $queryString = ['search', 'sort', 'direction'];

    protected $rules = [
        'titulo' => 'required|min:5|max:255',
        'fecha_reunion' => 'required|date|after:now',
        'ubicacion' => 'nullable|max:255',
        'descripcion' => 'nullable|max:1000',
        'solicitud_id' => 'required|exists:solicitudes,solicitud_id',
        'institucion_id' => 'required|exists:instituciones,id',
        'asistentes' => 'required|array|min:1',
        'asistentes.*' => 'exists:personas,cedula',
        'concejal' => 'nullable|exists:personas,cedula',
        'nuevo_estado_solicitud' => 'nullable|max:255'
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function orden($campo)
    {
        if ($this->sort === $campo) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $campo;
            $this->direction = 'asc';
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        if ($tab === 'list') {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->editingReunion = null;
        $this->titulo = '';
        $this->descripcion = '';
        $this->fecha_reunion = '';
        $this->ubicacion = '';
        $this->solicitud_id = '';
        $this->institucion_id = '';
        $this->asistentes = [];
        $this->concejal = '';
        $this->nuevo_estado_solicitud = '';
        $this->resetErrorBag();
    }

    public function createReunion()
    {
        $this->resetForm();
        $this->activeTab = 'create';
    }

    public function editReunion($reunionId)
    {
        $reunion = Reunion::with(['asistentes'])->findOrFail($reunionId);
        $this->editingReunion = $reunion;
        
        $this->titulo = $reunion->titulo;
        $this->descripcion = $reunion->descripcion ?? '';
        $this->fecha_reunion = $reunion->fecha_reunion->format('Y-m-d\TH:i');
        $this->ubicacion = $reunion->ubicacion ?? '';
        $this->solicitud_id = $reunion->solicitud_id;
        $this->institucion_id = $reunion->institucion_id;
        $this->asistentes = $reunion->asistentes->pluck('cedula')->toArray();
        $this->concejal = $reunion->concejal()?->cedula ?? '';
        
        $this->activeTab = 'edit';
    }

    public function viewReunion($reunionId)
    {
        $reunion = Reunion::with(['institucion', 'solicitud', 'asistentes'])->findOrFail($reunionId);
        $this->editingReunion = $reunion;
        $this->activeTab = 'view';
    }

    public function submit()
    {
        $this->validate();

        try {
            if ($this->editingReunion) {
                // Update existing reunion
                $this->editingReunion->update([
                    'titulo' => $this->titulo,
                    'descripcion' => $this->descripcion,
                    'fecha_reunion' => $this->fecha_reunion,
                    'ubicacion' => $this->ubicacion,
                    'solicitud_id' => $this->solicitud_id,
                    'institucion_id' => $this->institucion_id,
                ]);

                // Update asistentes with Concejal designation
                $asistentesData = [];
                foreach ($this->asistentes as $cedula) {
                    $asistentesData[$cedula] = ['es_concejal' => ($cedula === $this->concejal)];
                }
                $this->editingReunion->asistentes()->sync($asistentesData);

                // Update parent solicitud status if requested
                if ($this->nuevo_estado_solicitud) {
                    $solicitud = $this->editingReunion->solicitud;
                    $solicitud->estado_detallado = $this->nuevo_estado_solicitud;
                    $solicitud->save();
                }

                session()->flash('success', 'Reunión actualizada correctamente.');
            } else {
                // Create new reunion
                $reunion = Reunion::create([
                    'titulo' => $this->titulo,
                    'descripcion' => $this->descripcion,
                    'fecha_reunion' => $this->fecha_reunion,
                    'ubicacion' => $this->ubicacion,
                    'solicitud_id' => $this->solicitud_id,
                    'institucion_id' => $this->institucion_id,
                ]);

                // Attach asistentes with Concejal designation
                $asistentesData = [];
                foreach ($this->asistentes as $cedula) {
                    $asistentesData[$cedula] = ['es_concejal' => ($cedula === $this->concejal)];
                }
                $reunion->asistentes()->sync($asistentesData);

                // Update parent solicitud status if requested
                if ($this->nuevo_estado_solicitud) {
                    $solicitud = $reunion->solicitud;
                    $solicitud->estado_detallado = $this->nuevo_estado_solicitud;
                    $solicitud->save();
                }

                session()->flash('success', 'Reunión creada correctamente.');
            }

            $this->activeTab = 'list';
            $this->resetForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar la reunión: ' . $e->getMessage());
        }
    }

    public function confirmDelete($reunionId)
    {
        $this->deleteReunion = Reunion::findOrFail($reunionId);
    }

    public function cancelDelete()
    {
        $this->deleteReunion = null;
    }

    public function deleteReunionDefinitive()
    {
        try {
            // Detach all participants first
            $this->deleteReunion->asistentes()->detach();
            
            // Delete the reunion
            $this->deleteReunion->delete();
            
            session()->flash('success', 'Reunión eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la reunión: ' . $e->getMessage());
        }
        
        $this->deleteReunion = null;
    }

    public function render()
    {
        $reuniones = Reunion::with(['institucion', 'solicitud', 'asistentes'])
            ->when($this->search, function ($query) {
                $query->where('titulo', 'like', '%' . $this->search . '%')
                      ->orWhereHas('solicitud', function ($q) {
                          $q->where('titulo', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('institucion', function ($q) {
                          $q->where('titulo', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);

        $solicitudes = Solicitud::pluck('titulo', 'solicitud_id');
        $instituciones = Institucion::pluck('titulo', 'id');
        $personas = Personas::select('cedula', 'nombre', 'apellido')->get();

        return view('livewire.dashboard.super-admin-reuniones', [
            'reuniones' => $reuniones,
            'solicitudes' => $solicitudes,
            'instituciones' => $instituciones,
            'personas' => $personas,
        ]);
    }
}