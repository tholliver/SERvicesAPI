<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Informe extends Model
{
    use Notifiable, LogsActivity;

    protected static $logAttributes = ['nombre_cotizador','tipo_informe','informe_escrito','id_solicitud'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
    'nombre_cotizador','tipo_informe','informe_escrito','id_solicitud'];
}
