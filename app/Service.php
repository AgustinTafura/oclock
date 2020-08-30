<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  //
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'recommendation', 'requirement', 'specialty_id',
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
