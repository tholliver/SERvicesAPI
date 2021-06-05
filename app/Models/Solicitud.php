<?php

namespace App\Models;
use App\Models\Empresa;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{

use Notifiable;

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
}
