<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Address;
use App\Company;
use App\AddressProviderService;



class ProviderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $categories = \App\Category::all();
    $weekDays = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    $establishment = \App\Establishment::all();

    $provider = Auth::user()->provider;

    if ($provider) {
      return redirect('/home');
    }
    return view('form', compact('weekDays', 'establishment'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $provider = new Provider;
    $provider->validator($request->all())->validate(); // me valida segun el validator() que tiene la clase
    (!$request['license_number'])?:$provider->license_number = $request['license_number'];
    (!$request['provider_cuit'])?:$provider->cuit = $request['cuit'];
    (!$request['provider_contact_phone'])?:$provider->contact_phone = $request['provider_contact_phone'];
    $provider->user_id = \Auth::user()->id;
    // $provider->address_id =  \DB::table('addresses')->latest('id')->first()->id;
    // $provider->company_id =  \DB::table('companies')->latest('id')->first()->id;
    if ($request->cookie('CId')) {
      $provider->company_id = $request->cookie('CId');
    } else {
      $provider->company_id = $request['company_id'];;
    }
    $provider->specialty_id = $request['specialty_id'];
    $provider->save();
    $newProviderId = \DB::table('providers')->latest('id')->first()->id;
    return $newProviderId;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Provider  $provider
   * @return \Illuminate\Http\Response
   */
  public function show(Provider $provider)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Provider  $provider
   * @return \Illuminate\Http\Response
   */
  public function edit(Provider $provider)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Provider  $provider
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Provider $provider)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Provider  $provider
   * @return \Illuminate\Http\Response
   */
  public function destroy(Provider $provider)
  {
      //
  }

  /**
   * Validate Provider params before Store a newly.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function validation(Request $request)
  {
    $errors = 0;
    $provider = new Provider;
    $provider->validator($request->input())->validate(); // me valida segun el validator() que tiene la clase

    if($errors){
      return $errors;
    } else{
      return $provider;
    }
  }


}
