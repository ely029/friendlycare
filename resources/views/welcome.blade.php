@extends('layouts.admin.dashboard')

@section('content')
<div class="login">
      <div class="login__container">
        <div class="login__top">
          <div class="login__wrapper"><img class="login__image" src="{{URL::asset('img/logo.png')}}" alt="Logo of e-Plano" /></div>
          <div class="login__title">
            <h2 class="login__text">e-Plano</h2>
            <span class="login__span">
              Family Planning Informational <br />
              &amp; Booking App
            </span>
          </div>
        </div>
        <div>
        <div class="col-md-12">
                @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
@endif
        </div>
        </div>
        <div class="login__card">
          <h2 class="section__heading">Login</h2>
          <form class="form form--login" method="POST" action="{{route('authenticate')}}">
          @csrf  
          <div class="form__content"><input class="form__input" type="text" placeholder="Email" name="email" /><label class="form__label">Email</label></div>
            <div class="form__content"><input class="form__input" id="js-password" type="password" name="password" placeholder="Password" /><label class="form__label">Password</label><i class="fa fa-eye-slash" id="js-eye-password"></i></div>
            <div class="form__button"><input type="submit" class="button" value="Login"></div>
          </form>
        </div>
      </div>
    </div>
    @endsection
