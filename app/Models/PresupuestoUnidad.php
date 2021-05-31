<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoUnidad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_unidad', 'presupuesto', 'gestion'
    ];
}
