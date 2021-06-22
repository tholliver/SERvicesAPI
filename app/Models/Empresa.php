<?php
namespace App\Models;

use App\Models\Solicitud;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Empresa extends Model
{
    use Notifiable, LogsActivity;
    protected static $logAttributes = ['nombreemp', 'repnombre', 'telefono','diremp','rubro', 'nit','correo',];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empresas';
    protected $fillable = [
        'nombreemp', 'repnombre', 'telefono','diremp','rubro', 'nit','correo',
    ];

    public function cots()
    {
        //,'item_solicitud','solicitud_id','item_id'
        return $this->hasMany(EmpresaCotizacion::class,'id_empresa');
    }


}
