@extends('layouts.admin.dashboard')

@section('title', 'Account')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">John Smith</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link">My Account</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <h3 class="section__heading">John Smith</h3>
          <form class="form" action="">
            <div class="form__content"><span class="form__text">johnsmith@gmail.com</span><label class="form__label form__label--visible">Email</label></div>
            <div class="form__content"><span class="form__text">Admin</span><label class="form__label form__label--visible">Role </label></div>
            <div class="form__button form__button--start"><a class="button" href="edit-account.html">Edit profile</a><button class="button button--transparent">Logout</button></div>
          </form>
        </div>
      </div>
</div>
@endsection
