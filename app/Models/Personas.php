<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Personas extends Model
{
    // Indicar a Laravel que la clave primaria es 'cedula'
    protected $primaryKey = 'cedula';
    
    // Indicar a Laravel que la clave primaria NO es auto-incremental
    public $incrementing = false;

    // Indicar a Laravel que el tipo de la clave primaria es string (si 'cedula' es string)
    // Si 'cedula' es un número grande, déjalo comentado, si no, es mejor especificarlo.
    // protected $keyType = 'string'; 

    protected $fillable = [
        'nombre',
        'apellido',
        'segundo_nombre',
        'segundo_apellido',
        'nacionalidad',
        'genero',
        'cedula',
        'nacimiento',
        'direccion',
        'telefono',
        'email'
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'nacimiento' => 'date',
        ];
    }

    /**
     * Relación con el usuario. 
     * Se especifica que use 'cedula' como clave local y clave foránea.
     */
    public function usuario(): HasOne
    {
        // hasOne(Modelo_Relacionado, Clave_Foranea_en_User, Clave_Local_en_Personas)
        return $this->hasOne(User::class, 'cedula', 'cedula');
    }

    /**
     * The reuniones that the persona assists.
     */
    public function reunionesAsistidas(): BelongsToMany
    {
        return $this->belongsToMany(Reunion::class, 'asisten', 'persona_id', 'reunion_id');
    }
}