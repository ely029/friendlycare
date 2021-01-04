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
        @if ($errors->any())

  @foreach ($errors->all() as $error)
  <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
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
            <div class="form__button form__button--end"><input type="button" class="button js-trigger" value="Create Account"></div>
            <div class="modal js-modal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Account created</h2>
                  <p class="modal__text">You are about to create an admin. Proceed?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close">Cancel</button><input type="submit" class="button button--medium button--medium"  value="Create account"></div>
                </div>
              </div>
            </div>
            
            <!-- <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to create an Admin. Proceed?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-success" value="Create Account"/>
                                </div>
                        </div>
                    </div>
            </div> -->
          </form>
        </div>
      </div>
</div>
@endsection
