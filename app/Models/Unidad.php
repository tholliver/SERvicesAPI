<?php

namespace App;

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
        'nombre', 'facultad', 'presupuesto', 'telefono', 'user_id' 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
