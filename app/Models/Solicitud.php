<?php

namespace App\Models;

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
}
