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
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="user-management.php">User management</a><a class="breadcrumbs__link" href="create-user.php">Create user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <h3 class="section__heading">{{ $user->name }}</h3>
          <form class="form" action="">
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Email</label><span class="form__text">{{$user->name}}</span></div>
            @if ($user->role_id == 2)
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Role </label><span class="form__text">Admin</span></div>
            @elseif ($user->role_id == 4)
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Role </label><span class="form__text">Staff</span></div>
            @endif
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Profession </label><span class="form__text">{{ $user->professions }}</span></div>
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Training </label><span class="form__text">{{ $user->trainings }}</span></div>
            <div class="form__button"><a class="button" href="{{ route('editUserProfile',$user->id)}}">Edit profile</a>
            <a data-toggle="modal" data-target="#confirmCreateFPM" class="button button--transparent" href="#">Delete account</a>
          </div>
          </form>
          <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        </div>
      @endforeach
      </div>
</div>

@endsection
