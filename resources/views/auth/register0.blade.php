@extends('layouts.app')

@php
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
@endphp



@section('content')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">{{ __('Register') }}</div>

              <div class="card-body">
                  <form method="POST" action="{{ route('register') }}">
                      @csrf

                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                              <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                              @error('email')
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
      											<option value="" selected> day </option>
                            @for ($i=1; $i <= 31; $i++)
                                <option value="{{$i}}"> {{$i}} </option>
                            @endfor
      										</select>
      										<select name="month" id="month" class="form-control col-md-4 @error('month') is-invalid @enderror" name="month" value="{{ old('month') }}" required autocomplete="month">
      											<option value="" selected>Month</option>
                            @for ($i=0; $i < 12; $i++)
                              <option value="{{$i}}">{{$months[$i]}}</option>
                            @endfor
      										</select>
      										<select name="year" id="year" class="form-control col-md-4 @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" required autocomplete="year">
      											<option value="" selected>Year</option>
                            @for ($i=date("Y"); $i > date("Y")-110; $i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
      										</select>
      									</div>
      								</div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Register') }}
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
@endsection
