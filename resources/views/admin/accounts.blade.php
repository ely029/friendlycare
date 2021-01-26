@extends('layouts.admin.dashboard')

@section('title', 'Account')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">{{Auth::user()->name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link">My Account</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <h3 class="section__heading">{{Auth::user()->name}}</h3>
          <form class="form" action="">
            <div class="form__content"><span class="form__text">{{Auth::user()->email}}</span><label class="form__label form__label--visible">Email</label></div>
            @if (Auth::user()->role_id = 1)
            <div class="form__content"><span class="form__text">Super Administrator</span><label class="form__label form__label--visible">Role </label></div>
            @elseif (Auth::user()->role_id = 2)
            <div class="form__content"><span class="form__text">Administrator</span><label class="form__label form__label--visible">Role </label></div>
            @endif

            <div class="form__password">
              <h3 class="section__heading">Update Password?</h3>
              <div class="form__content"><input class="form__input" id="js-password" type="password" placeholder="Old password" /><label class="form__label">Old password</label><i class="fa fa-eye-slash" id="js-eye-password"></i></div>
              <div class="form__content">
                <input class="form__input" id="js-confirm-password" type="password" placeholder="New password" /><label class="form__label">New password</label><i class="fa fa-eye-slash" id="js-eye-confirm-password"></i>
              </div>
            </div>
            <div class="form__button form__button--start"><a class="button" href="#">Update password</a><a class="button button--transparent" href="{{ route('admin.logout')}}">Logout</a></div>
          </form>
        </div>
      </div>
</div>
@endsection
