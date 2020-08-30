<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Address extends Model
{
  // protected $street;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'street', 'number', 'postal_code', 'floor', 'apartment',  'neighborhood', 'city', 'state', 'country', 'lat', 'lng',
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

//   /**
//    * Funcion para vincular con User
//    */
//   public function users()
//     {
//         return $this->hasMany('App\User');
//     }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  public function validator (array $data)
  {
      return Validator::make($data, [
          'street_name' => ['required', 'string', 'max:120'],
          'street_number' => ['required','numeric'],
          'floor' => ['nullable', 'string', 'max:120'],
          'apartment' => ['nullable', 'string', 'max:30'],
          'zip' => ['required', 'string', 'max:30'],
          'city' => ['required', 'string', 'max:120'],
          'state' => ['required', 'string', 'max:120'],
          // 'country' => ['required', 'string', 'max:120'],
      ]);
  }

  /**
   * Funcion para vincular con Company
   */
  public function company()
  {
      return $this->hasOne('App\Company');
  }

  /**
   * Funcion para vincular con Company
   */
  public function provider()
  {
      return $this->hasOne('App\Provider');
  }

  /**
   * Funcion para vincular con User
   */
  public function users()
  {
      return $this->hasMany('App\User');
  }



  //
  // public function getStreet(){
  //   return $this->street;
  // }
  //
  // public function getNumber(){
  //   return $this->number;
  // }
  //
  // public function getFloor(){
  //   return $this->floor;
  // }
  //
  // public function getApartment(){
  //   return $this->apartment;
  // }
  //
  // public function getPostalCode(){
  //   return $this->postal_code;
  // }
  //
  // public function getNeighborhood(){
  //   return $this->neighborhood;
  // }
  //
  // public function getCity(){
  //   return $this->city;
  // }
  //
  // public function getState(){
  //   return $this->state;
  // }
  // public function getCountry(){
  //   return $this->country;
  // }


}
