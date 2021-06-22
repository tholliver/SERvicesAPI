<?php

namespace App\Models;
use App\Models\Unidad;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable, LogsActivity;
    protected static $logAttributes = ['name', 'lastname', 'email', 'cellphone', 'rol','unidaddegasto','unidad_id'];
     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'cellphone', 'rol','unidaddegasto','unidad_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

      // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function unidad() {
        return $this->belongsTo(Unidad::class);
    }
}
