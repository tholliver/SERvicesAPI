<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CotizacionItem extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'cantidad', 'precioUnitario', 'total', 'empresa_cotizacion_id'
    ];

    public function empresas_cotizaciones()
    {
        return $this->toBelongsTo(EmpresaCot::class,'id');
    }
}
