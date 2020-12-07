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
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('userManagement')}}">User management</a><a class="breadcrumbs__link" href="edit-user.php">Edit user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @if ($errors->any())

  @foreach ($errors->all() as $error)
  <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
    @endif
        
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
              <div class="form__content"><input class="form__input" type="text" name="professions" placeholder="Profession (optional)" value="{{ $user->professions }}"/><label class="form__label">Profession (optional)</label></div>
              <div class="form__content"><input class="form__input" type="text" name="trainings" placeholder="Training (optional)" value="{{ $user->trainings }}"/><label class="form__label">Training (optional)</label></div>
            </div>
            @if ($user->role_id == 2)
            @else
            <div class="form__inline">
                <div class="form__content">
                    <select placeholder="Clinic" name="clinic" class="form__input--select form__input">
                        <option value="">Choose a Clinic</option>
                        @foreach($clinic as $clinics)
                        <option value="{{ $clinics->id}}">{{$clinics->clinic_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__content">
                  <input class="form__input" type="text" placeholder="Email Address" value="{{ $user->email }}" name="email"/>
                  <label class="form__label">Email Address</label>
                </div>

            </div>
            @endif
            
            <div class="form__button form__button--end">
              <input type="button" class="button js-trigger" value="Save Changes">
            </div>
            <div class="modal js-modal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Save changes?</h2>
                  <p class="modal__text">You are about to save the changes. Proceed?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><input type="submit" class="button button--medium" type="button" value="Save changes"></div>
                </div>
              </div>
            </div>

            <!-- <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Save Changes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">You are about to save the changes. Proceed?</div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Save Changes"/>
                </div>
              </div>
            </div> -->
          </form>
        @endforeach
        </div>
      </div>
</div>
@endsection
