<?php

namespace App\Models;
use App\Models\Empresa;
use App\Models\Informe;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Solicitud extends Model
{    
    //addd
    use Notifiable, LogsActivity;
    protected static $logAttributes = ['tipo','responsable','unidad_nombre','estado'];
    
    protected $fillable=[
    'unidad_id','unidad_nombre','tipo','responsable','montoestimado','estado','supera'
    ];
    public function items()
    {
        return $this->belongsToMany(Item::class,'item_solicitud','solicitud_id','item_id')->withPivot('nombre','descrip','cantidad','precio');
        
    }

    public function cotizacionesEmpresa()
    {
        //,'item_solicitud','solicitud_id','item_id'
        return $this->belongsToMany(Empresa::class,'empresa_cotizacion','id_solicitud','id_empresa')->withPivot('id','observaciones','plazo_de_entrega','validez_oferta','total','cotizacion_pdf','eleccion');
    }

    public function informe()
    {
        //,'item_solicitud','solicitud_id','item_id'
        return $this->hasOne(Informe::class,'id_solicitud');
    }
}
