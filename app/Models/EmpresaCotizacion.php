<?php
namespace App\Models;
use App\Models\CotizacionItem;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmpresaCotizacion extends Model
{
    use Notifiable, LogsActivity;

    protected static $logAttributes = ['observaciones','plazo_de_entrega','validez_oferta', 'total','eleccion'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empresa_cotizacion';

    protected $fillable = [
        'observaciones','plazo_de_entrega','validez_oferta', 'total','cotizacion_pdf','eleccion','id_empresa','id_solicitud'
    ];
    public function itemscot()
    {
        //,'item_solicitud','solicitud_id','item_id'
        return $this->hasMany(CotizacionItem::class,'empresa_cotizacion_id');
        
    }
    public function empresas()
    {
        //,'item_solicitud','solicitud_id','item_id'
        return $this->BelongsToMany(Empresa::class,'empresas','id');
       
    }
}
