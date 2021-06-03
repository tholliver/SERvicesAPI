<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class EmpresaCot extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empresa_cotizacion';
    protected $fillable = [
        'id_solicitud', 'id_empresa', 'observaciones','plazo_de_entrega','validez_oferta', 'total','cotizacion_pdf',
    ];
}
