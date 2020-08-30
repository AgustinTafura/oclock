<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname',
        'address_id', 'birthdate', 'dni', 'mobile_phone', 'sex',
        'is_admin', 'avatar', 'active',
          // 'manager_id', 'admin_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

    ];

    /**
     * Funcion para vincular con Addres
     */
    // public function address()
    // {
    //     return $this->belongsTo('App\Address');
    // }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:120'],
            'mobile_phone' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:120'],
            'day' => ['required', 'numeric', 'between:1,31'],
            'month' => ['required', 'numeric', 'between:1,12'],
            'year' => ['required', 'numeric'],
            'password' => [ 'nullable','string', 'min:8', 'confirmed',], // no quiero que valide si no actualiza la PASS
        ]);
    }

    /**
     * Funcion para vincular con Applicant
     */
    public function client()
    {
        return $this->hasOne('App\Client');
    }

    /**
     * Funcion para vincular con Applicant
     */
    public function provider()
    {
        return $this->hasOne('App\Provider');
    }

    /**
     * Funcion para vincular con Address
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function hola(){
      echo 'holaaaaaaaaaaaaaa';
    }

}
