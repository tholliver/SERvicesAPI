<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{

use Notifiable;

    protected $fillable=[
    'responsable','montoestimado','estado'
    ];
    public function items()
    {
        return $this->belongsToMany(Item::class,'item_solicitud','solicitud_id','item_id');
    }
}
