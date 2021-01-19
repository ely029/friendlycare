@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
      <div class="section">
      @foreach ($users as $user)
      <div class="section__top">
          <h1 class="section__title">{{$user->name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('userManagement')}}">User management</a><a class="breadcrumbs__link">Create user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <h3 class="section__heading">{{ $user->name }}</h3>
          <form class="form" action="">
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Email</label><span class="form__text">{{$user->email}}</span></div>
            @if ($user->role_id == 2)
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Role </label><span class="form__text">Admin</span></div>
            @elseif ($user->role_id == 4)
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Role </label><span class="form__text">Staff</span></div>
            @endif
            @if ($user->role_id == 4)
              @foreach($staff as $staffs)
              <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Clinic Name</label><span class="form__text">{{ $staffs->clinic_name }}</span></div>
              @endforeach
            @endif
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Profession </label><span class="form__text">{{ $user->professions }}</span></div>
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Training </label><span class="form__text">{{ $user->trainings }}</span></div>
            <div class="form__button form__button--start"><a class="button" href="{{ route('editUserProfile',$user->id)}}">Edit profile</a>
            <a class="button button--transparent js-trigger" href="#">Delete account</a>
          </div>
          </form>

          <div class="modal js-modal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Delete account?</h2>
                  <p class="modal__text">You are about to delete the user. Proceed?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close">Cancel</button><a href="{{ route('deleteUser', $user->id)}}" class="button button--medium button--medium__delete">Delete account</a></div>
                </div>
              </div>
            </div>
          <!-- <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete the user. Proceed?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ route('deleteUser', $user->id)}}" class="btn btn-success">Delete Account</a>
                                </div>
                        </div>
                    </div>
             </div>
        </div> -->
      @endforeach
      </div>
</div>

@endsection
