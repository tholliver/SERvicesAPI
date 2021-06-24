<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use Notifiable; 
    //LogsActivity;
    //protected static $logAttributes = ['nomitem', 'descrip', 'item_general_id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomitem', 'descrip', 'item_general_id'
    ];


}
