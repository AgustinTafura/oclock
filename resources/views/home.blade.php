@extends('layouts.app')

@section('scripts')
  <script type="text/javascript">
    $(function() {
      $('#principalContainer').removeClass('container')
      $('#principalContainer').addClass('container-fluid')
    })
  </script>

@endsection
@section('content')

    @if(!empty($successMsg))
      <div class="alert alert-success"> {{ $successMsg }}</div>
    @endif

    @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
    @endif

  <div id="home">
    <a href="{{ route('user.editMe')}}">
    {{-- <a href="{{ route('user.edit.my') }}"> --}}
      <div class="">
        <span>MIS DATOS</span>
      </div>
    </a>
    <a href="#">
      <div class="">
        <span>TURNOS</span>
      </div>
    </a>
    <a href="{{ route('search')}}">
      <div class="">
        <span>NUEVO TURNO</span>
      </div>
    </a>
    <div id='calendar'></div>
    <BR>
    @if ($user->provider)
      <a href="{{ route('user.editMe')}}">
      {{-- <a href="{{ route('user.edit.my') }}"> --}}
        <div class="">
          <span>DATOS PROFESIONALES</span>
        </div>
      </a>
      <a href="#">
        <div class="">
          <span>AGENDA</span>
        </div>
      </a>
    @endif
  </div>


@endsection
