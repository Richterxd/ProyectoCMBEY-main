<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReunionRequest;
use App\Http\Requests\UpdateReunionRequest;
use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas; // Using the pluralized model name
use Illuminate\Http\Request;

class ReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reuniones = Reunion::with(['institucion', 'solicitud'])->latest()->paginate(10);
        return view('reuniones.index', compact('reuniones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // CORRECCIÓN 1: Solicitudes usa 'solicitud_id' (Confirmado)
        $solicitudes = Solicitud::pluck('titulo', 'solicitud_id'); 
        
        // CORRECCIÓN 2: Instituciones usa 'id' (Confirmado)
        $instituciones = Institucion::pluck('titulo', 'id');
        
        // Get personas using cedula as key
        $personas = Personas::select('cedula', 'nombre', 'apellido')->get();
        
        return view('reuniones.create', compact('solicitudes', 'instituciones', 'personas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReunionRequest $request)
    {
        $validated = $request->validated();
        
        // Create the reunion
        $reunion = Reunion::create($validated);

        // Attach asistentes with Concejal designation
        if ($request->has('asistentes')) {
            $asistentesData = [];
            $concejal = $request->input('concejal');
            
            foreach ($request->input('asistentes') as $cedula) {
                $asistentesData[$cedula] = ['es_concejal' => ($cedula === $concejal)];
            }
            
            $reunion->asistentes()->sync($asistentesData);
        }

        // Update parent solicitud status if requested
        if ($request->filled('nuevo_estado_solicitud')) {
            $solicitud = $reunion->solicitud;
            $solicitud->estado_detallado = $request->input('nuevo_estado_solicitud');
            $solicitud->save();
        }

        return redirect()->route('dashboard.reuniones.index')
                         ->with('success', 'Reunión creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reunion $reunion)
    {
        $reunion->load(['institucion', 'solicitud', 'asistentes']);
        return view('reuniones.show', compact('reunion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reunion $reunion)
    {
        // CORRECCIÓN 1: Solicitudes usa 'solicitud_id' (Confirmado)
        $solicitudes = Solicitud::pluck('titulo', 'solicitud_id'); 
        
        // CORRECCIÓN 2: Instituciones usa 'id' (Confirmado)
        $instituciones = Institucion::pluck('titulo', 'id');
        
        // Get personas using cedula as key
        $personas = Personas::select('cedula', 'nombre', 'apellido')->get();
        
        $reunion->load('asistentes'); // Load current asistentes
        return view('reuniones.edit', compact('reunion', 'solicitudes', 'instituciones', 'personas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReunionRequest $request, Reunion $reunion)
    {
        $validated = $request->validated();
        
        // Update reunion data
        $reunion->update($validated);

        // Update asistentes with Concejal designation
        if ($request->has('asistentes')) {
            $asistentesData = [];
            $concejal = $request->input('concejal');
            
            foreach ($request->input('asistentes', []) as $cedula) {
                $asistentesData[$cedula] = ['es_concejal' => ($cedula === $concejal)];
            }
            
            $reunion->asistentes()->sync($asistentesData);
        } else {
            $reunion->asistentes()->sync([]);
        }

        // Update parent solicitud status if requested  
        if ($request->filled('nuevo_estado_solicitud')) {
            $solicitud = $reunion->solicitud;
            $solicitud->estado_detallado = $request->input('nuevo_estado_solicitud');
            $solicitud->save();
        }

        return redirect()->route('dashboard.reuniones.index')
                         ->with('success', 'Reunión actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();

        return redirect()->route('dashboard.reuniones.index')
                         ->with('success', 'Reunión eliminada exitosamente.');
    }
}
