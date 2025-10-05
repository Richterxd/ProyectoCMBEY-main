<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReunionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'solicitud_id' => ['required', 'string', 'exists:solicitudes,solicitud_id'],
            'institucion_id' => ['required', 'integer', 'exists:instituciones,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'fecha_reunion' => ['required', 'date', 'after_or_equal:today'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'asistentes' => ['nullable', 'array'],
            'asistentes.*' => ['string', Rule::exists('personas', 'cedula')],
            'concejal' => ['nullable', 'string', Rule::exists('personas', 'cedula')],
            'nuevo_estado_solicitud' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'solicitud_id.required' => 'Debe seleccionar una solicitud asociada.',
            'solicitud_id.exists' => 'La solicitud seleccionada no existe.',
            'institucion_id.required' => 'Debe seleccionar una institución responsable.',
            'institucion_id.exists' => 'La institución seleccionada no existe.',
            'titulo.required' => 'El título de la reunión es obligatorio.',
            'titulo.max' => 'El título no puede exceder los 255 caracteres.',
            'fecha_reunion.required' => 'La fecha de la reunión es obligatoria.',
            'fecha_reunion.date' => 'La fecha debe ser válida.',
            'fecha_reunion.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'ubicacion.max' => 'La ubicación no puede exceder los 255 caracteres.',
            'asistentes.array' => 'Los asistentes deben ser una lista válida.',
            'asistentes.*.exists' => 'Uno o más asistentes seleccionados no existen.',
            'concejal.exists' => 'El concejal seleccionado no existe.',
            'nuevo_estado_solicitud.max' => 'El estado no puede exceder los 255 caracteres.',
        ];
    }
}