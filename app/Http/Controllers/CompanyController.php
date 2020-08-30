<?php

namespace App\Http\Controllers;

use App\Company;
use App\Address;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
      $company = new Company;
      $company->validator($request->all())->validate(); // me valida segun el validator() que tiene la clase Address
      $company->name = $request['establishment_name'];
      $company->cuit = $request['cuit'];
      $company->address_id = $request['address_id'];     //\DB::table('addresses')->latest('id')->first()->id;
      $company->contact_phone = $request['company_contact_phone'];
      $company->email = $request['company_email'];
      $company->category_id = $request['category_id'];
      $company->establishment_id = $request['establishment_id'];
      // $company->website = $request['company_website'];
      // $company->avatar = $request['company_avatar'];
      $company->save();
      $newCompanyId = \DB::table('companies')->latest('id')->first()->id;
      // $newCompanyId = $request->cookie('AId');
      $cookieCId = cookie('CId', $newCompanyId, 60);

      return response($newCompanyId)->withCookie($cookieCId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show( $companyId)
    {
      $company = Address::where('id', '=', $companyId)
      ->get();
      return ($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    /**
     * Check if exist the Id, and return it.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkId($companyId)
    {
      $company = Address::find($companyId);
      $id = $company->id;
      return ($id);
    }

  /**
   * Validate Company params before Store a newly.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function validation(Request $request)
  {
    $errors = 0;
    $company = new Company;
    $company->validator($request->input())->validate(); // me valida segun el validator() que tiene la clase

    if($errors){
      return $errors;
    } else{
      return $company;
    }
  }

  /**
   * Display the specified resource.
   *

   */
  public function getCompanyById($company_id)
  {
    $company = Company::find($company_id);
    return $company;
  }

}
