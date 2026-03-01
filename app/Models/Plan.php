<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * Define qué columnas se pueden llenar mediante código.
     * Estas deben coincidir con las que creamos en tu migración.
     */
    protected $fillable = [
        'name',
        'slug',
        'stripe_id',
        'price',
        'description',
    ];

    /**
     * Esto permite que en las rutas se use el 'slug' (ej: /plans/plan-pro)
     * en lugar del ID numérico.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}