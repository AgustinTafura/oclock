<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">      <!-- CSRF Token -->

  <title>{{ config('app.name', "O'Clock") }}</title>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> <!-- BOOTSTRAP --> <!-- SIN EL meta viewport NO FUNCIONA  -->
  <link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css">       <!-- PARA EVITAR LOS DIFERENTES DEFAULT DE LOS NAVEGADORES - UTIL PARA EL MODELO DE CAJA -  -->

  <!-- Styles -->

  @yield('styles')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">  <!--poner siempre ultimo -->

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script> <!-- Script main: O'clock -->
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script> <!-- Script: JQUERY -->
  @yield('scripts')



</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light {{--bg-white --}} shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', "O'Clock") }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('home') }}" onclick="event.preventDefault();
                                                     document.getElementById('home-form').submit();">
                                    {{ __('home') }}
                                </a>

                                <form id="home-form" action="{{ route('home') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div id="principalContainer" class="container">
            @yield('content')
          </div>
        </main>


        {{-- <footer> --}}
        @include('layouts.footer.footer')
        {{-- </footer> --}}

    </div>


</body>

</html>
