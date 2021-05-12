<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ItemSuperior extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *aqui se esta guardando
     * @var array
     */
    protected $fillable = [
        'nomitemSup', 'descripSup',
    ];

    public function items()
    {
        return $this->hasMany(Item::class,'item_general_id');
    }

}
