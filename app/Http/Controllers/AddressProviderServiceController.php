<?php

namespace App\Http\Controllers;

use App\AddressProviderService;
use Illuminate\Http\Request;

class AddressProviderServiceController extends Controller
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
      foreach ($request['service_id_'] as $key => $value) {
        $aps = new AddressProviderService;
        // $aps->validator($request->all())->validate(); // me valida segun el validator() que tiene la clase
        $aps['address_id'] = \DB::table('addresses')->latest('id')->first()->id;
        $aps['provider_id'] = \DB::table('providers')->latest('id')->first()->id;
        $aps['service_id'] = \DB::table('services')->latest('id')->first()->id;
      $aps->save();
      }
      $newAPSId = \DB::table('address_provider_services')->latest('id')->first()->id;
      return $newAPSId;
      Id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AddressProviderService  $addressProviderService
     * @return \Illuminate\Http\Response
     */
    public function show(AddressProviderService $addressProviderService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AddressProviderService  $addressProviderService
     * @return \Illuminate\Http\Response
     */
    public function edit(AddressProviderService $addressProviderService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddressProviderService  $addressProviderService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddressProviderService $addressProviderService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddressProviderService  $addressProviderService
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddressProviderService $addressProviderService)
    {
        //
    }
}
