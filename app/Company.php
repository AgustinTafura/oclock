<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Address;
use App\Category;

class Company extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'address_id', 'contact_phone', 'email', 'category_id', 'cuit', 'website', 'avatar', 'establishment_id' ];

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
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  public function validator(array $data)
  {
      return Validator::make($data, [
          'establishment_name' => ['required', 'string', 'min:3', 'max:120'],
          // 'cuit' => ['string', 'max:13'],
          'address_id' => ['exists:addresses,id'],
          'company_contact_phone' => ['required', 'numeric'],
          'company_email' => ['required', 'string', 'email', 'max:120'],
          'category_id' => ['exists:categories,id'],
          'establishment_id' => ['exists:establishments,id'],
      ]);
  }


  /**
   * Funcion para vincular con Establishment
   */
  public function category()
  {
      return $this->belongsTo('App\Category');
  }

  /**
   * Funcion para vincular con Address
   */
  public function address()
  {
      return $this->hasOne('App\Address');
  }

  /**
   * Funcion para vincular con Address
   */
  public function provider()
  {
      return $this->hasOne('App\Provider');
  }

}
