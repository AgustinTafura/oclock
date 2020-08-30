<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $address = new Address;
      $errors = 0;
      $address->validator($request->all())->validate(); // me valida segun el validator() que tiene la clase
      $address->street = $request['street_name'];
      (!$request['street_number'])?:$address->number = $request['street_number'];
      (!$request['floor'])?:$address->floor = $request['floor'];
      (!$request['apartment'])?:$address->apartment = $request['apartment'];
      (!$request['zip'])?:$address->postal_code = $request['zip'];
      $address->city = $request['city'];
      $address->state = $request['state'];
      // $address->country = $request['country'];
      $address->country = 'Argentina';
      $AddressComplete = $address->street.' '.$address->number.', '.$address->city.', '.$address->country;
      $AddressComplete = urlencode($AddressComplete);
      $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".$AddressComplete."&sensor=true&key=".config('app.api_key');
      $xml = simplexml_load_file($request_url) or die("url not loading");
      $status = $xml->status;
      if ($status=="OK") {
          $Lat = $xml->result->geometry->location->lat;
          $Lng = $xml->result->geometry->location->lng;
      } else {
        $errors['address'] = 'Check the address given';
      }
      $address->lat = $Lat;
      $address->lng = $Lng;

      if(!$errors){
        $address->save();
        $newAddressId = \DB::table('addresses')->latest('id')->first()->id;
        $cookieAId = cookie('AId', $newAddressId, 60);
        return response($newAddressId)->withCookie($cookieAId);
      } else{
        return $errors;
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }

    /**
     * Get cities from Addresses.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function getCities(Address $address)
    {
      $cities = Address::select('city as name')
      ->groupBy('name')
      ->orderBy('name', 'asc')
      ->get();

      return ($cities);
    }

    /**
     * Check if exist the Id, and return it.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkId($addressId)
    {
      $address = Address::find($addressId);
      $id = $address->id;
      return ($id);
    }

    /**
     * Validate Address params before Store a newly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validation(Request $request)
    {
      $errors = 0;
      $address = new Address;
      $address->validator($request->input())->validate(); // me valida segun el validator() que tiene la clase

      if($errors){
        return $errors;
      } else{
        return $address;
      }
    }

    /**
     * Display the specified resource.
     *

     */
    public function getAddressById($address_id)
    {
      $address = Address::find($address_id);
      return $address;
    }


}
