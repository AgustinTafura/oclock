<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- BOOTSTRAP -->
      <!-- SIN EL meta viewport NO FUNCIONA  -->
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

      <!-- PARA EVITAR LOS DIFERENTES DEFAULT DE LOS NAVEGADORES - UTIL PARA EL MODELO DE CAJA -  -->
      <link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', "O'Clock") }}</title>

      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}" defer></script> <!-- Script main: O'clock -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> <!-- Script: JQUERY -->
      <script src="{{ asset('js/jquery.steps.js') }}" defer></script> <!-- Script: JQUERY.STEPS -->

      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
          .container-fluid{
            font-family: 'Nunito', sans-serif;
          }

          .col-12 {
            padding: 0;
          }

          nav {
            height: 4vh;
            overflow:hidden;
          }

          nav div a:first-child{
            float: left;
          }

          nav div a:last-child{
            float: right;
          }

          .principal {
            height: 86vh;
            background-color: #383a4f;
          }

          .title {
            height: 10%;
            color: white;
          }

          h1 {
            font-weight: 300;
            padding-top: 5%;
            height: 100%;
            margin: 0;
          }

          .sections {
            height: 90%;
            display: grid;
          }

          .sections a {
            /* col-6 float-left
            align-items-center */

            background-position: center;
            background-size:cover;
            filter: grayscale(100);
            height: 100%;
            font-size: 1.5rem;
            padding-top:5%;
            font-weight: bold;
            padding: 0;
            padding-top: 25%;
            /* padding-top: 8%; */
            text-decoration: overline;
            /* border-right: solid; */

          }

          .applicant {
            background-image: url("storage/img/agenda.jpg");
            border-bottom: solid;
            }

          .professional {
            background-image: url("storage/img/garden.jpg");
            border-top: solid;
          }


          .links a {
            /* color: #eb6649; */
            color: white;
          }

          .sections a {
            color: white;
          }

          .buttonlink:hover {
            text-decoration-line: none;
            transform: scale(1.3);
          }

          .sections a:hover  {
            -webkit-filter: grayscale(0);
            text-decoration: overline;
            color: white;
          }



          /* 320px - Extra Small Devices, Phones Portrait */
          @media only screen and (min-width : 320px) {
          }

          /* 480px - Extra Small Devices, Phones Landscape */
          @media only screen and (min-width : 480px) {

            nav{
            }

            nav div {
              text-align-last: end;
            }

            nav div a:last-child {
              float:none;
            }

            nav div a:first-child {
              float:none;
            }

            nav .links {
              display: inherit;
              place-content: flex-end;
              text-align-last: center;
            }

            .buttonlink:hover {
              text-decoration-line: none;
              transform: scale(1.3);
            }

            .sections {
              display: flex;
              align-items: center;
            }

            .sections a {
              width: 50%;
              padding-top: 30%
            }

            .applicant {
              border-right: solid;
              border-bottom: none;
            }

            .professional {
              border-left: solid;
              border-top: none;
            }
          }

          /* 768px - Small Devices, Tablets */
          @media only screen and (min-width : 768px) {
          }

          /* 992px - Medium Devices, Desktops */
          @media only screen and (min-width : 992px) {

          }

          /* 1200px - Large Devices, Wide Screens */
          @media only screen and (min-width : 1200px) {

          }


        </style>

    </head>
    <body>
        <div id="app" class="container-fluid">
          <nav class="content row">
            @if (Route::has('login'))
                <div class="col links">
                    @auth
                        <a class="col-lg-1 col-md-1 col-sm-2 col-ms-3 col-xs-3 col-3 buttonlink text-center" href="{{ url('/home') }}">{{ Auth::user()->name }}</a>
                    @else
                        <a class="col-lg-1 col-md-1 col-sm-2 col-ms-3 col-xs-3 col-3 buttonlink text-center" href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                          <a class="col-lg-1 col-md-1 col-sm-2 col-ms-3 col-xs-3 col-3  buttonlink text-center" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
          </nav>

            <main class="row principal">
                <div class=" title mx-auto ">
                  <h1 class="text-center">O'Clock</h1>
                </div>

                <div class="sections links col-12">
                    <a class="applicant text-center" href="{{ route('login') }}"><span>Necesito un turno</span></a>
                    <a class="professional text-center" href="{{ route('provider.create') }}"><span>Ofrecer mi Servicio</span></a>
                </div>

            </main>


            @include('layouts/footer/footer')

          </div>
    </body>
</html>
