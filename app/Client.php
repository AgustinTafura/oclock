<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'membership_number', 'plan_id', 
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
   * Funcion para vincular con User
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }

}
