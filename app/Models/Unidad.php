<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Unidad extends Model
{
    use Notifiable, LogsActivity;

    protected static $logAttributes = ['nombre', 'facultad', 'presupuesto', 'telefono'];
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'facultad', 'presupuesto', 'telefono'
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
    public function usuarios()
    {
        return $this->hasMany(User::class,'unidad_id');
    }

    public function assignActual()
    {
        $fullDate = Carbon::now();
        $actualYear = $fullDate->year;
        return $this->assign()->wherePivot('periodo',$actualYear);
    }

}
