<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//7 vistas de User  GET-/photos–index() , GET-/photos/create-create(), POST-/photos/createstore(), GET-/photos/{photo}-show(), GET-/photos/{photo}/edit-edit(), PUT/PATCH-/photos/{photo}-update(), DELETE-/photos/{photo}-destroy().
Route::get('user/edit', 'UserController@editMe')->name('user.editMe');
Route::resource('user', 'UserController');

Route::get('address/validation', 'AddressController@validation');
Route::get('company/validation', 'CompanyController@validation');
Route::get('provider/validation', 'ProviderController@validation');
Route::post('booking/validation', 'BookingController@validationAjax');

Route::resource('address', 'AddressController')->middleware('auth');
Route::get('address/check/{id}', 'AddressController@checkId');
Route::get('address/get/{id}', 'AddressController@getAddressById');
Route::get('company/check/{id}', 'CompanyController@checkId');
Route::resource('company', 'CompanyController')->middleware('auth');
Route::get('company/get/{id}', 'CompanyController@getCompanyById');
// Route::resource('provider', 'ProviderController', ['names' => ['create' => 'formulario']]);
Route::resource('provider', 'ProviderController')->middleware('auth');
Route::resource('booking', 'BookingController')->middleware('auth');
Route::resource('specialty', 'SpecialtyController');//->middleware('auth');;
Route::resource('category', 'CategoryController');//->middleware('auth');

Route::post('datalist', 'BookingController@datalist')->name('datalist');//->middleware('auth');
Route::post('search', 'BookingController@searchAvailableBookings')->name('searchAvailableBookings');//->middleware('auth');
Route::get('getCities', 'AddressController@getCities')->name('getCities');
Route::get('search', function(){
  return view('search');
})->name('search')->middleware('auth');


Route::get('getspecialties/{specialty_id}', 'SpecialtyController@getspecialties');//->middleware('auth');
Route::get('getEstablishments/{establishment_id}', 'EstablishmentController@getEstablishments');//->middleware('auth');
Route::get('getservices/{services_id}', 'ServiceController@getservices');//->middleware('auth');





Route::get('pruebaCalendario', function(){
  return view('prueba');
});



// use Illuminate\Http\Request;
// Route::post('prueba2', function(Request $request){
//
//
// });

// Route::get('json', function(){
//
//   $file= Storage::get('geonames.json');
//   // $csv= file_get_contents($file);
//   // $array = array_map("str_getcsv", explode("\n", $file));
//   // $json = json_decode($file, 'true');
//   $array = json_decode($file, true);
//   foreach ($array as $key => $city) {
//
//   }
//   return $array[0];
// });
