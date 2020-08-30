<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressProviderService extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','address_id', 'provider_id', 'service_id', 'status_id', 'date', 'start_time', 'finish_time', 'active',
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
}
