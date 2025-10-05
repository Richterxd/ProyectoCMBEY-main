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
            'asistentes.*' => ['integer', Rule::exists('personas', 'cedula')],
            'concejal' => ['nullable', 'integer', Rule::exists('personas', 'cedula')],
            'nuevo_estado_solicitud' => ['nullable', 'string', 'max:255'],
        ];
    }
}