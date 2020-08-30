@extends('layouts.app')

@php
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
@endphp



@section('content')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">
                @auth
                  {{ __('Editar mi Cuenta') }}
                @endauth
                @guest
                  {{ __('Register') }}
                @endguest
              </div>

              <div class="card-body">
                @auth
                  <form method="POST" action=" {{ route('user.update', ['id' => $user->id]) }}" id="form_user_update">
                  @method('PUT')
                @endauth
                @guest
                  <form method="POST" action=" {{ route('register') }}" id="form_user_register">
                @endguest
                      @csrf
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@auth{{$user->name}}@endauth @guest{{ old('name')}}@endguest" required autocomplete="name" autofocus>

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surame') }}</label>

                          <div class="col-md-6">
                              <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="@auth{{$user->surname}}@endauth @guest{{ old('surname')}}@endguest" required autocomplete="name" autofocus>

                              @error('surname')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@auth {{$user->email}} @endauth @guest{{ old('email')}}@endguest" required autocomplete="email">

                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="mobile_phone" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Phone') }}</label>

                          <div class="col-md-6">
                              <input id="mobile_phone" type="tel" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone" value="@auth {{$user->mobile_phone}} @endauth @guest{{ old('mobile_phone')}}@endguest" required autocomplete="mobile_phone">

                              @error('mobile_phone')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
      										<label for="day" class="col-md-4 col-form-label text-md-right">Date of Birth:</label>
                          <div class="col-md-6" style="display:flex">

      										<select name="day" id="day" class="form-control col-md-4 @error('day') is-invalid @enderror" name="day" value="{{ old('day') }}" required autocomplete="day">
      											<option value="" > day </option>
                            @for ($i=1; $i <= 31; $i++)
                                <option value="{{$i}}" @auth @if ($i == date('d', strtotime($user->birthdate))) selected @endif  @endauth > {{$i}} </option>
                            @endfor
      										</select>
      										<select name="month" id="month" class="form-control col-md-4 @error('month') is-invalid @enderror" name="month" value="{{ old('month') }}" required autocomplete="month">
      											<option value="" selected>Month</option>
                            @for ($i=0; $i < 12; $i++)
                              <option value="{{$i+1}}" @auth @if ($i+1 == date('m', strtotime($user->birthdate))) selected @endif  @endauth  >{{$months[$i]}}</option>
                            @endfor
      										</select>
      										<select name="year" id="year" class="form-control col-md-4 @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" required autocomplete="year">
      											<option value="" selected>Year</option>
                            @for ($i=date("Y"); $i > date("Y")-110; $i--)
                              <option value="{{$i}}" @auth @if ($i == date('Y', strtotime($user->birthdate))) selected @endif  @endauth  >{{$i}}</option>
                            @endfor
      										</select>
      									</div>
      								</div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="password" type="password" data-msg="Please fill this field" class="form-control @error('password')  is-invalid @enderror" name="password" @guest required @endguest @auth placeholder="xxxxxxxx"@endauth  autocomplete="new-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row" id="password_confirmed" @auth hidden @endauth >
                          <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                          <div class="col-md-6">
                              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" @guest required @endguest autocomplete="new-password">
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary @auth disabled @endauth">
                                  @auth {{__('Actualizar')}} @endauth
                                  @guest {{ __('Register') }} @endguest
                              </button>
                              @auth
                                <a href="/home">
                                  <button type="button" class="btn btn-light">
                                    {{__('Cancelar')}}
                                  </button>
                                </a>
                              @endauth
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
@endsection
