<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemSuperior extends Model
{
    use Notifiable;
    // LogsActivity;

    //protected static $logAttributes = ['nomitemSup', 'descripSup'];
    //protected static $logName = 'item-superiores';
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
