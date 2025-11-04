<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudesServicio extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitudes_servicios';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'correo_electronico',
        'entidad_procedencia_id',
        'entidad_otra',
        'servicio_id',
        'servicio_otro',
        'coordinacion_id',
        'motivo_solicitud',
        'estatus',
        'fecha_solicitud',
        'fecha_actualizacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'entidad_procedencia_id' => 'integer',
        'servicio_id' => 'integer',
        'coordinacion_id' => 'integer',
        'fecha_solicitud' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Los valores posibles para el campo estatus
     */
    const ESTATUS_EN_REVISION = 'en_revision';
    const ESTATUS_REVISADO = 'revisado';

    /**
     * Scope para filtrar por estatus
     */
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopeEnRevision($query)
    {
        return $query->where('estatus', self::ESTATUS_EN_REVISION);
    }

    public function scopeRevisados($query)
    {
        return $query->where('estatus', self::ESTATUS_REVISADO);
    }

    /**
     * Relación con entidad de procedencia
     */
    public function entidadProcedencia()
    {
        return $this->belongsTo(EntidadesProcedencia::class, 'entidad_procedencia_id');
    }

    /**
     * Relación con servicio
     */
    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }

    /**
     * Relación con coordinación
     */
    public function coordinacion()
    {
        return $this->belongsTo(Coordinaciones::class, 'coordinacion_id');
    }

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    /**
     * Accessor para obtener la entidad (propia o "otra")
     */
    public function getEntidadNombreAttribute()
    {
        return $this->entidadProcedencia ? $this->entidadProcedencia->nombre : $this->entidad_otra;
    }

    /**
     * Accessor para obtener el servicio (propio o "otro")
     */
    public function getServicioNombreAttribute()
    {
        return $this->servicio ? $this->servicio->nombre : $this->servicio_otro;
    }
}