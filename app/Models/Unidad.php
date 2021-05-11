<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'facultad', 'presupuesto', 'telefono', 'user_id' , 'secret_id'
    ];

    /*
     public function users()
    {
       return $this->hasMany(User::class,'unidad_id', 'id');
    }
    */

    public function assign()
    {
        return $this->belongsToMany(ItemSuperior::class,'unidadasignacionitems','unidad_id','itemsuperior_id')
        ->withPivot(['montoasig','periodo']);
    }
}
