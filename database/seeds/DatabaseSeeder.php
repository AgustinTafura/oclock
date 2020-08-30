<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    $categories = [
      'Médico' => [
        'specialties' =>['Alergia e Inmunologia', 'Audiologia - Audiometria', 'Cardiologia', 'Cirugia Cardiovascular', 'Medico Clínico'],
        'establishments' => ['Consultorio Particular','Centro Médico'],
        // 'services' =>['Consulta en Consultorio'],
      ],
      'Odontologico' => [
        'specialties' =>['Odontologia en General', 'Ortodoncia', 'Endodoncia', 'Periodoncia', 'Odontología estética o cosmética'],
        'establishments' => ['Consultorio Particular','Centro Odontológico'],
        // 'services' =>['Consulta en Consultorio'],
      ],
      'Estético' => [
        'specialties' => ['Masajista', 'SPA', 'Peluqueria', 'Depilación'],
        'establishments' => ['Local Particular','Centro de Estética'],
        // 'services' =>['Turno'],
      ],
      'Deportivo' =>  [
        'specialties' => ['Alquiler canchas de Futbol', 'Alquiler canchas de Tenis', 'Alquiler canchas de Voley', 'Alquiler canchas de Ping Pong'],
        'establishments' => ['Centro Deportivo', 'Club'],
      // 'services' =>['Alquiler de cancha'],
      ]
    ];

    foreach ($categories as $category => $array) {
      // store CATEGORIES
      DB::table('categories')->insert([
        'name' => $category,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      // store SPECIALTIES
      foreach ($array['specialties'] as $specialty => $value) {
        DB::table('specialties')->insert([
          'name' => $value,
          'category_id' => \DB::table('categories')->latest('id')->first()->id,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
      // store ESTABLISHMENTS
      foreach ($array['establishments'] as $establishment => $value) {
        DB::table('establishments')->insert([
          'name' => $value,
          'category_id' => \DB::table('categories')->latest('id')->first()->id,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }

    }


    // $addresses = factory(App\Address::class, 10)->create();

    // store MEDICALINSURANCES - PLANS
    $medicalInsurances = [
      'Swiss Medical Group' => [
        'Swiss Medical', '20234355321', 'sm@mail.com', '01123232231', 'prepaga',
      ],
      'IOMA' => [
        'IOMA', '20412331234', 'ioma@mail.com','01152346345', 'obra social',
      ],
      'OSDE' => [
        'OSDE', '20756765329', 'osde@mail.com','01164564564', 'obra social',
      ],
    ];
    foreach ($medicalInsurances as $medicalInsurance => $value) {
      DB::table('medical_insurances')->insert([
        'name' => $medicalInsurance,
        'business_name' => $value[0],
        'cuit' => $value[1],
        'email' => $value[2],
        'contact_phone' => $value[3],
        'type' => $value[4],
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }


    $plans = factory(App\Plan::class, 10)->create();

    // store STATUSES
    $statuses = ['Disponible','Reservado', 'No disponible', 'Cancelado','Con demora', 'Ausente con aviso', 'Ausente sin aviso', ];
    foreach ($statuses as $key => $status) {
      DB::table('statuses')->insert([
        'name' => $status,
        // 'description' => ;
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }


    $jsonCities= Storage::get('geonames.json');
    $arrayCities = json_decode($jsonCities, true);
    foreach ($arrayCities as $key => $city) {
      DB::table('cities')->insert([
        'name' => $city['name'],
        'postal_code' => $city['postal_code'],
        'state_id' => $city['state_id'],
        'lat' => $city['lan'],
        'lng' => $city['lng'],
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }



    // $users = factory(App\User::class, 10)->create();

    // $clients = factory(App\Client::class, 10)->create();

    // $providers = factory(App\Provider::class, 10)->create();

    // $services = factory(App\Service::class, 10)->create();

    // $companies = factory(App\Company::class, 10)->create();

  }
}
