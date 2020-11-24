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
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="user-management.php">User management</a><a class="breadcrumbs__link" href="create-user.php">Create user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        <div class="row">
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

          <form class="form" method="POST" action="{{ route('createAdmin' )}}">
            @csrf
            <div class="form__inline">
              <div class="form__content">
                <select class="form__input form__input--select" id="role">
                  <option disabled selected>---</option>
                  <option value="{{ route('adminFirstPage') }}" selected>Admin</option>
                  <option value="{{ route('staffFirstPage') }}">Staff</option>
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
              <div class="form__content"><input class="form__input" type="text" placeholder="First name*" name="first_name" value="{{ old('first_name')}}" /><label class="form__label">First name* </label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Last name*" name="last_name" value="{{ old('last_name')}}"/><label class="form__label">Last name* </label></div>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" placeholder="Profession (optional)" name="professions" value="{{ old('professions')}}"/><label class="form__label">Profession (optional)</label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Training (optional)" name="trainings" value="{{ old('trainings')}}"/><label class="form__label">Training (optional)</label></div>
            </div>
            <div class="form__content"><input class="form__input" type="text" placeholder="Email Address*" value="{{ old('email')}}"name="email" /><label class="form__label">Email Address*</label></div>
            <div class="form__button form__button--end"><input type="submit" class="button" value="Create Account"></div>
          </form>
        </div>
      </div>
</div>
@endsection
