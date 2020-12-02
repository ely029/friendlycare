@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>
<div class="login">
      <div class="login__container login__container--password">
        <div class="login__top">
          <div class="login__wrapper"><img class="login__image" src="img/logo.png" alt="Logo of e-Plano" /></div>
          <div class="login__title">
            <h2 class="login__text">e-Plano</h2>
            <span class="login__span">
              Family Planning Informational <br />
              &amp; Booking App
            </span>
          </div>
        </div>
        <div class="login__content">
          <div class="login__card">
            <h2 class="section__heading">Welcome!</h2>
            <p class="login__details">e-Plano has created an account for you. Please create a password to complete the process (Minimum of 8 characters).</p>
            <form class="form form--login" action="">
              <div class="form__content"><input class="form__input" id="js-password" type="password" placeholder="Enter password" /><label class="form__label">Enter password</label><i class="fa fa-eye-slash" id="js-eye"></i></div>
              <div class="form__content"><input class="form__input" id="js-password" type="password" placeholder="Confirm password" /><label class="form__label">Confirm password</label><i class="fa fa-eye-slash" id="js-eye"></i></div>
              <div class="form__button"><a class="button" href="">Create account</a></div>
            </form>
          </div>
          <div class="login__card">
            <h2 class="section__heading">Account details</h2>
            <form class="form form--login" action="">
              <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Email</label><span class="form__text">johnsmith@gmail.com</span></div>
              <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Provider clinic</label><span class="form__text">Shaw Clinic</span></div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

<!-- <div class="container-fluid">
        @include('includes.sidebar')
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create User</h2>
                </div>
            </div>
            <div class="row bg-white">
                <select class="form-control" id="role">
                    <option value="">Please Select</option>
                    <option value="{{ route('adminFirstPage') }}">Admin</option>
                    <option value="{{ route('staffFirstPage') }}">Staff</option>
                </select>
            </div>
        </main>
</div> -->