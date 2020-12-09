@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Create user</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('userManagement')}}">User management</a><a class="breadcrumbs__link">Create user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="">
            <div class="form__inline">
              <div class="form__content">
                <select class="form__input form__input--select" id="role">
                  <option disabled selected>---</option>
                  <option id="js-admin" value="{{ route('adminFirstPage') }}">Admin</option>
                  <option id="js-staff" value="{{ route('staffFirstPage') }}">Staff</option>
                </select>
                <label class="form__label">Role*</label>
              </div>
              <div class="form__content js-provider-clinic">
                <select class="form__input form__input--search">
                  <option value="Shaw Clinic">Shaw Clinic</option>
                  <option value="Cubao Clinic">Cubao Clinic</option>
                </select>
                <label class="form__label">Provider clinic</label>
              </div>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" placeholder="First name*" /><label class="form__label">First name* </label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Last name*" /><label class="form__label">Last name* </label></div>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" placeholder="Profession (optional)" /><label class="form__label">Profession (optional)</label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Training (optional)" /><label class="form__label">Training (optional)</label></div>
            </div>
            <div class="form__content"><input class="form__input" type="text" placeholder="Email Address*" /><label class="form__label">Email Address*</label></div>
            <div class="form__button form__button--end"><a class="button" href="">Create account</a></div>
          </form>
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