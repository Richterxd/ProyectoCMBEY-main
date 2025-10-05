<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'solicitud_id',
        'titulo',
        'descripcion',
        'estado_detallado',
        'observaciones_admin',
        'fecha_actualizacion_usuario',
        'fecha_actualizacion_super_admin',
        'fecha_creacion',
        'persona_cedula',
        'ambito_id',
        'derecho_palabra',
        'categoria',
        'subcategoria',
        'tipo_solicitud',
        'nombre_rif_institucion',
        'pais',
        'estado_region',
        'municipio',
        'parroquia',
        'comunidad',
        'direccion_detallada',
    ];

    protected $casts = [
        'derecho_palabra' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion_usuario' => 'datetime',
        'fecha_actualizacion_super_admin' => 'datetime',
    ];

    // Categories and subcategories constants
    const CATEGORIAS = [
        'servicios' => [
            'agua',
            'electricidad',
            'telecomunicaciones',
            'gas_comunal',
            'gas_directo_tuberia'
        ],
        'social' => [
            'educacion_inicial',
            'educacion_basica',
            'educacion_secundaria',
            'educacion_universitaria'
        ],
        'sucesos_naturales' => [
            'huracanes',
            'tormentas_tropicales',
            'terremotos'
        ]
    ];

    const TIPO_SOLICITUD = [
        'individual',
        'colectivo_institucional'
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Personas::class, 'persona_cedula', 'cedula');
    }

    public function ambito(): BelongsTo
    {
        return $this->belongsTo(Ambito::class, 'ambito_id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sectores::class, 'comunidad');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'persona_cedula', 'persona_cedula');
    }

    public function visitadorAsignado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visitador_asignado', 'persona_cedula');
    }

    public function personasAsociadas(): HasMany
    {
        return $this->hasMany(SolicitudPersonaAsignada::class, 'solicitud_id');
    }

    /**
     * Generate unique solicitud ID
     */
    public static function generateSolicitudId($userCedula)
    {
        $datePrefix = date('Ymd');
        $hash = substr(md5($userCedula . time() . uniqid()), 0, 6);
        return $datePrefix . strtoupper($hash);
    }

    /**
     * Get formatted categoria name
     */
    public function getParroquiaFormattedAttribute()
    {
        return match($this->parroquia) {
            'chivacoa' => 'CHIVACOA',
            'campo_elias' => 'CAMPO ELÍAS',
            default => $this->parroquia
        };
    }

    /**
     * Get formatted categoria name
     */
    public function getTipoSolicitudFormattedAttribute()
    {
        return match($this->tipo_solicitud) {
            'individual' => 'Individual',
            'colectivo_institucional' => 'Colectivo/Institucional',
            default => $this->tipo_solicitud
        };
    }

    /**
     * Get formatted categoria name
     */
    public function getCategoriaFormattedAttribute()
    {
        return match($this->categoria) {
            'servicios' => 'Servicios',
            'social' => 'Social',
            'sucesos_naturales' => 'Sucesos Naturales',
            default => $this->categoria
        };
    }

    /**
     * Get formatted subcategoria name
     */
    public function getSubcategoriaFormattedAttribute()
    {
        return match($this->subcategoria) {
            'agua' => 'Agua',
            'electricidad' => 'Electricidad',
            'telecomunicaciones' => 'Telecomunicaciones',
            'gas_comunal' => 'Gas Comunal',
            'gas_directo_tuberia' => 'Gas Directo por Tubería',
            'educacion_inicial' => 'Educación Inicial',
            'educacion_basica' => 'Educación Básica',
            'educacion_secundaria' => 'Educación Secundaria',
            'educacion_universitaria' => 'Educación Universitaria',
            'huracanes' => 'Huracanes',
            'tormentas_tropicales' => 'Tormentas Tropicales',
            'terremotos' => 'Terremotos',
            default => $this->subcategoria
        };
    }

    /**
     * Get estado color for UI
     */
    public function getEstadoColorAttribute()
    {
        return match($this->estado_detallado) {
            'Pendiente' => 'yellow',
            'Aprobada' => 'green',
            'Rechazada' => 'red',
            'Asignada' => 'blue',
            default => 'gray'
        };
    }
    
    public function reuniones(): HasMany
    {
        return $this->hasMany(Reunion::class, 'solicitud_id', 'id');
    }

    // Automatically set update timestamps
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($modelo) {
            if (Auth::check()) {
                if (Auth::user()->isSuperAdministrador()) {
                    $modelo->fecha_actualizacion_super_admin = now();
                } else {
                    $modelo->fecha_actualizacion_usuario = now();
                }
            } else {
                $modelo->fecha_actualizacion_usuario = now();
            }
        });
    }
}