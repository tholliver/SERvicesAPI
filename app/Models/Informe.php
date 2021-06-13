<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use Notifiable;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
    'nombre_cotizador','tipo_informe','informe_escrito','empresa_cotizacion_id','solicitud_id'
    ];
}
