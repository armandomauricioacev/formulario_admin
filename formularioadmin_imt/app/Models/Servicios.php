<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicios';

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
        'coordinacion_predeterminada_id',
        'fecha_creacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'coordinacion_predeterminada_id' => 'integer',
    ];

    /**
     * Scope para obtener solo servicios activos
     */
    /**
     * Relación con coordinación predeterminada
     */
    public function coordinacionPredeterminada()
    {
        return $this->belongsTo(Coordinaciones::class, 'coordinacion_predeterminada_id');
    }

    /**
     * Relación con solicitudes de servicios
     */
    public function solicitudesServicios()
    {
        return $this->hasMany(SolicitudesServicio::class, 'servicio_id');
    }
}

