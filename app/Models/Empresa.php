<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empresas';
    protected $fillable = [
        'nombreemp', 'repnombre', 'telefono','diremp','rubro', 'nit',
    ];
}
