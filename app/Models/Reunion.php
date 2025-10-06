<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reunion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reuniones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'solicitud_id',
        'institucion_id',
        'titulo',
        'descripcion',
        'fecha_reunion',
        'ubicacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_reunion' => 'datetime',
    ];

    /**
     * Get the solicitud that the reunion belongs to.
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id', 'solicitud_id');
    }

    /**
     * Get the institucion that the reunion belongs to.
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * The personas that assist the reunion.
     */
    public function asistentes(): BelongsToMany
    {
        return $this->belongsToMany(Personas::class, 'persona_reunion', 'reunion_id', 'persona_cedula', 'id', 'cedula')
                    ->withPivot('es_concejal')
                    ->withTimestamps();
    }

    /**
     * Get the Concejal for this reunion.
     */
    public function concejal()
    {
        return $this->asistentes()->wherePivot('es_concejal', true)->first();
    }
}
