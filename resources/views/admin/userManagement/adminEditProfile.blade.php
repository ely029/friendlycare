@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">Edit user</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="user-management.php">User management</a><a class="breadcrumbs__link" href="edit-user.php">Edit user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @foreach ($users as $user)
        <form class="form" method="POST" action="{{ route('updateUser') }}">
            @csrf
            <div class="form__content">
              <select class="form__input form__input--select">
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
              </select>
              <label class="form__label">Role</label>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" name="first_name" placeholder="First name" value="{{ $user->first_name }}"/><label class="form__label">First name </label></div>
              <div class="form__content"><input class="form__input" type="text" name="last_name" placeholder="Last name" value="{{ $user->last_name }}"/><label class="form__label">Last name </label></div>
              <input type="hidden"  name="id" value="{{ $user->id }}">
              <input type="hidden"  name="role_id" value="{{ $user->role_id }}">
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" name="professions" placeholder="Profession (optional)" value="{{ $user->profession }}"/><label class="form__label">Profession (optional)</label></div>
              <div class="form__content"><input class="form__input" type="text" name="trainings" placeholder="Training (optional)" value="{{ $user->training }}"/><label class="form__label">Training (optional)</label></div>
            </div>
            @if ($user->role_id == 2)
            @else
            <div class="form__inline">
                <div class="form__content">
                    <select placeholder="Clinic" name="clinic" class="form-control form__input">
                        <option value="">Choose a Clinic</option>
                        @foreach($clinic as $clinics)
                        <option value="{{ $clinics->id}}">{{$clinics->clinic_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="form__inline">
            <div class="form__content"><input class="form__input" type="text" placeholder="Email Address" value="{{ $user->email }}" name="email"/><label class="form__label">Email Address</label></div>
            <div class="form__button form__button--end"><input type="submit" class="button" value="Save Changes"></div>
          </form>
        @endforeach
        </div>
      </div>
</div>
@endsection
