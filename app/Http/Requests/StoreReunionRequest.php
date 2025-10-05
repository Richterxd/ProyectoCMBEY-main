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
            'solicitud_id' => ['required', 'integer', 'exists:solicitudes,id'],
            'institucion_id' => ['required', 'integer', 'exists:instituciones,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'fecha_reunion' => ['required', 'date'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'asistentes' => ['nullable', 'array'],
            
            'asistentes.*' => ['string', Rule::exists('personas', 'cedula')],
            'concejal' => ['nullable', 'string', Rule::exists('personas', 'cedula')],
            'nuevo_estado_solicitud' => ['nullable', 'string', 'max:255'],
        ];
    }
}