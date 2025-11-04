<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinaciones extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coordinaciones';

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
        'nombre',
        'coordinador',
        'correo_coordinador',
        'asistente',
        'correo_asistente',
        'representante',
        'correo_representante',
        'fecha_creacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    /**
     * Scope para obtener solo coordinaciones activas
     */
    /**
     * Relación con servicios
     */
    public function servicios()
    {
        return $this->hasMany(Servicios::class, 'coordinacion_predeterminada_id');
    }

    /**
     * Relación con solicitudes de servicios
     */
    public function solicitudesServicios()
    {
        return $this->hasMany(SolicitudesServicio::class, 'coordinacion_id');
    }
}

