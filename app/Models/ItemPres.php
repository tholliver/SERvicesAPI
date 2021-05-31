<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ItemPres extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'unidadasignacionitems';
    protected $fillable = [
        'unidad_id', 'itemsuperior_id', 'montoasig','periodo',
    ];
}
