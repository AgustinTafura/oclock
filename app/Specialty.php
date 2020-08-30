<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Funcion para vincular con Addres
     */
    public function  categories()
    {
        return $this->belongsTo('App\Category');
    }
}
