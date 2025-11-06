<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     */
    protected $table = 'correos';

    /**
     * Clave primaria.
     */
    protected $primaryKey = 'id';

    /**
     * Campos asignables en masa.
     */
    protected $fillable = [
        'tipo',
        'titulo',
        'cuerpo',
        'despedida',
    ];
}