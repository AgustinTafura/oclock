<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Specialty;
use App\Company;
use App\User;

class Provider extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'cuit', 'license_number', 'contact_phone',
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
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  public function validator(array $data)
  {
      return Validator::make($data, [
          'cuit' => ['string', 'digits:11'],
          'license_number' => ['string', 'digits_between:3,50'],
          // 'contact_phone' => ['numeric', 'max:120'],
          'user_id' => ['exists:users,id'],
          'company_id' => ['exists:companies,id'],
          'specialty_id' => ['required','exists:specialties,id'],
      ]);
  }

  /**
   * Funcion para vincular con Applicant
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }

  /**
   * Funcion para vincular con Applicant
   */
  public function address()
  {
      return $this->belongsTo('App\Address');
  }


    /**
     * Funcion para vincular con Applicant
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

}
