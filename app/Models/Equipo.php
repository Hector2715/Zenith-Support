<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    /**
     * Atributos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'modelo',
        'estado',
        'fecha_entrega',
        'costo',
    ];

    /**
     * Casting de atributos.
     * Esto ayuda a que Laravel trate 'fecha_entrega' como un objeto Carbon (fecha) 
     * automáticamente, lo cual es mejor para tus gráficos.
     */
    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];
}