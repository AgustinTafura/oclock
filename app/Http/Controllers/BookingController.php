<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Address;
use App\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
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



    $days = $request['days'];
    $appointmentDuration = $request['appointment_duration'];
    // $services = $request['service_id_'];
    $dateStart = strtotime($request['date_start']);
    $dateEnd = $dateStart+(30*86400);  // 10 dias

    // Setea en cada dia de la semana los rangos de horarios de atencion.
    foreach ($days as $key => $value) {
      if($days[$key]['open']){
        if ($days[$key]['open'] == '24hours') {
          for ($i=strtotime('00:00:00'); $i < strtotime('23:59:59'); $i= $i+60*$appointmentDuration) {
            $timeAppointments[$key][] = date("H:i:s", $i);
          }
        }
        else {
          $count = count($days[$key]['open_hour']);
          for ($i=0; $i < $count ; $i++) {
            for ($j=strtotime($days[$key]['open_hour'][$i]); $j < strtotime($days[$key]['close_hour'][$i]); $j= $j+60*$appointmentDuration) {
              $timeAppointments[$key][] = date("H:i:s", $j);
            }
          }
        }
      } else {
        $timeAppointments[$key] = 0;
      }
    }
    // Vincula los dias seteados con los rangos de horarios de atencion previamente seteados.
    for ($i=$dateStart; $i < $dateEnd; $i=$i+86400) {
      $weekDay = getDate($i)['wday'];
      if($timeAppointments[$weekDay]){
        foreach ($timeAppointments[$weekDay] as $key => $value) {
          // $appointments[] = $value;
          $appointments[]=date("Y-m-d", $i) .  ' ' . $value;
        }
      }
    }
    var_dump(Auth::user()->provider);
    foreach ($appointments as $key => $value) {
      $booking = new BOOKING;
      $booking['start_time'] = $value;
      $booking['finish_time'] = date("Y-m-d H:i:s",(strtotime($value)+60*$appointmentDuration));
      $booking['active'] = 1;
      $booking['status_id'] = 1;
      $booking['specialty_id'] = $request['specialty_id'];
      // $booking['service_id'] = ; // Se completa al solicitar un turno por el cliente.
      // $booking['provider_id'] = \DB::table('providers')->latest('id')->first()->id;
      // $booking['address_id'] = \DB::table('addresses')->latest('id')->first()->id;
      $booking['provider_id'] = Auth::user()->provider->id;
      $booking['address_id'] =  Auth::user()->provider->company->address_id;

      // $booking['client_id'] = Se completa al solicitar un turno por el cliente.
      $booking->save(); // Guarda cada booking en la DB
    }

    return redirect()->action('HomeController@index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Booking  $booking
   * @return \Illuminate\Http\Response
   */
  public function show($provider_id)
  {
    $bookings = \DB::table('bookings')->leftJoin('statuses', 'bookings.status_id', '=', 'statuses.id')->where([['provider_id', $provider_id ]])->select('bookings.id', 'start_time as start', 'finish_time as end', 'active',)->get();
    return response()->json($bookings);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Booking  $booking
   * @return \Illuminate\Http\Response
   */
  public function edit(Booking $booking)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Booking  $booking
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Booking $booking)
  {
    if($booking->user_id){
      $booking->user_id = $request->user_id;
    } else {
      $booking->user_id = Auth::user()->id;
    }
    $booking->status_id = 2;
    return response(200);
    // $request->session()->flash('status', 'Turno Confirmado!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Booking  $booking
   * @return \Illuminate\Http\Response
   */
  public function destroy(Booking $booking)
  {
      //
  }

  /**
   * Search names of Professionals,Companies or Neighborhood.
   *
   * @param \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function datalist(Request $data)
  {
    $name = $data['name'];
    $category_id = $data['category_id'];
    $specialty_id = $data['specialty_id'];

    if (isset($data['category_id_min']) || isset($data['category_id_max'])){
      $limMin = ($specialty_id > 0)? $specialty_id:$data['category_id_min'];
      $limMax = ($specialty_id > 0)? $specialty_id:$data['category_id_max'];
    } else {
      $limMin = 1;
      $limMax = 1000;
    }


    $providers = \DB::table('users')
      ->rightJoin('providers' , 'users.id', '=', 'providers.user_id')
      ->join('specialties', 'specialties.id', '=', 'providers.specialty_id')
      ->whereBetween('providers.specialty_id', [$limMin, $limMax])
      ->where('users.surname', 'like', "$name%")
      ->select(['users.name as name', 'users.surname as surname', '.specialties.name as specialty', 'providers.id as id'])
      ->get();

    $companies = \DB::table('companies')
      ->join('addresses', 'addresses.id', '=', 'companies.address_id')
      ->where('companies.name', 'like', "%$name%")
      ->select(['companies.name as name', 'companies.id as id', 'addresses.street as street', 'addresses.number as number', 'companies.address_id as addressId', ])
      ->groupBy('name', 'id', 'street', 'number')
      ->get();

    $neighborhood = \DB::table('addresses')
      ->where('addresses.neighborhood', 'like', "$name%")
      ->select(['addresses.neighborhood as name', 'addresses.city as city'])
      ->groupBy('city', 'name')
      ->get();

      $response['providers'] = json_decode($providers, true);
      $response['companies'] = json_decode($companies, true);
      $response['neighborhood'] = json_decode($neighborhood, true);

    return $response;
  }

  /**
   * Search available bookings.
   *
   * @param \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function searchAvailableBookings(Request $data)
  {
    // var_dump($data['input_datalist']);
    $specialty_id = ($data['specialty_id'])?($data['specialty_id']):0;
    // $category = ($data['category']);
    $timeStart = ($data['timeStart']);
    $timeEnd = ($data['timeEnd']);
    $dateStart = ($data['dateStart']);
    $dateEnd = date("Y-m-d",(strtotime($data['dateStart'])+(30*86400)));     // 3 meses(90 dias)
    $provider_id = (isset($data['input_datalist']["'providers'"]))?$data['id']:0;
    $companies_id = (isset($data['input_datalist']["'companies'"]))?$data['id']:0;
    $nameNeighborhood = (isset($data['input_datalist']["'addresses'"]))?$data['input_datalist']["'addresses'"]:0;

    if ($data['input_datalist']) {
      $bookings = \DB::table('bookings')
      ->leftJoin('providers' , 'bookings.provider_id', '=', 'providers.id')
      ->leftJoin('companies', 'companies.id', '=', 'providers.company_id')
      ->leftJoin('specialties', 'specialties.id', '=', 'bookings.specialty_id')
      ->leftJoin('addresses', 'addresses.id', '=', 'bookings.address_id')
      ->leftJoin('users', 'users.id', '=', 'providers.user_id')
      ->where([['providers.id', '=', "$provider_id"], ['bookings.active', '=', '1'], ['bookings.status_id', '=', '1']])
      ->orWhere([['providers.company_id', '=', "$companies_id"], ['bookings.active', '=', '1'], ['bookings.status_id', '=', '1']])
      ->orWhere([['addresses.neighborhood', 'like', "$nameNeighborhood"],['bookings.specialty_id', 'like', "$specialty_id"], ['bookings.active', '=', '1'], ['bookings.status_id', '=', '1']])
      ->whereDate('bookings.start_time', '>=', "$dateStart")
      ->whereDate('bookings.start_time', '<=', "$dateEnd")
      ->whereTime('bookings.start_time', '>=', "$timeStart")
      ->whereTime('bookings.start_time', '<=', "$timeEnd")
      ->select('providers.id as groupId', 'bookings.id as id', 'bookings.start_time as start', 'bookings.finish_time as end', 'companies.name as companyName', 'specialties.name as specialties', \DB::raw("CONCAT(users.surname, ', ' , users.name) as title"), "users.name as name", "users.surname as surname",  \DB::raw("CONCAT(addresses.street, ' ' ,addresses.number, ' ' ,addresses.city) as completeAddress"), "addresses.lat", "addresses.lng" )
      ->orderBy('bookings.start_time')
      ->get();
    } else {
      $bookings = \DB::table('bookings')
      ->leftJoin('providers' , 'bookings.provider_id', '=', 'providers.id')
      ->leftJoin('companies', 'companies.id', '=', 'providers.company_id')
      ->leftJoin('specialties', 'specialties.id', '=', 'bookings.specialty_id')
      ->leftJoin('addresses', 'addresses.id', '=', 'bookings.address_id')
      ->leftJoin('users', 'users.id', '=', 'providers.user_id')
      ->where([['bookings.specialty_id', 'like', "$specialty_id"], ['bookings.active', '=', '1'], ['bookings.status_id', '=', '1']])
      ->whereDate('bookings.start_time', '>=', "$dateStart")
      ->whereDate('bookings.start_time', '<=', "$dateEnd")
      ->whereTime('bookings.start_time', '>=', "$timeStart")
      ->whereTime('bookings.start_time', '<=', "$timeEnd")
      ->select('providers.id as groupId', 'bookings.id as id', 'bookings.start_time as start', 'bookings.finish_time as end', 'companies.name as companyName', 'specialties.name as specialties', \DB::raw("CONCAT(users.surname, ', ' , users.name) as title"), "users.name as name", "users.surname as surname",  \DB::raw("CONCAT(addresses.street, ' ' ,addresses.number, ' ' ,addresses.city) as completeAddress"), "addresses.lat", "addresses.lng" )
      ->orderBy('bookings.start_time')
      ->get();
    }

    // echo "<pre>";
    // var_dump($data['specialty']);
    // var_dump($data['input_datalist']["'providers'"]);
    // var_dump($data['input_datalist']["'companies'"]);
    // var_dump($data['input_datalist']["'addresses'"]);
    // var_dump($data['id']);
    // echo "<br>";
    // $providersLoad = $bookings->select('providers.id as groupId')->get();

    $dateSelected = $data['dateStart'];

    if($bookings->isEmpty()){
       $errors = ['empty'];
      // return response("NO HEMOS ENCONTRADO RESULTADOS PARA TU BUSQUEDA" );
      return back()->withErrors(['emptySearch' => 'No hay Turnos Disponibles para tu búsqueda'])->withInput();
    }
    return response(view('bookings', compact('bookings', 'dateSelected')));
    // return $bookingsJson;
  }


  /**
   * Search names of Professionals,Companies or Neighborhood.
   *
   * @param \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function validationAjax(Request $request)
  {
    $errors = [];

    ($request['appointment_duration'])?:$errors['errors']['appointment_duration'] = 'Debes seleccionar la duracion de tus turnos';
    ($request['date_start'])?:$errors['errors']['date_start'] = 'Debes seleccionar una fecha';

    foreach($request['data'] as $key => $value) {

      if($value['open_hour'] != 'closed' && $value['open_hour'] != '24hours'){
        foreach($value['open_hour'] as $index => $openHour) {
          if(strtotime($openHour) >= strtotime($value['close_hour'][$index])){
            $errors['errors']["days$key"."close_hour$index"] = 'La hora de cierre del turno debe ser posterior la hora de apertura del mismo';
          }
          if ($index >= 1) {
            if(strtotime($openHour) < strtotime($value['close_hour'][$index-1])){
              $errors['errors']["days$key"."open_hour$index"] = 'La hora de apertura del turno debe ser posterior la hora de cierre del turno anterior';
            }
          }
        }
      }
      // return $errors;
    }

    if($errors){
      return response($errors, 422);
    }
    return response(200);

  }
}
