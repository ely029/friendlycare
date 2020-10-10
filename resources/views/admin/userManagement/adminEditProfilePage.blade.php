@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">

            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item active">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
    
        @foreach ($users as $user)
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>{{ $user->first_name }}  {{ $user->last_name }}</h2>
                    <span>User Management</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Create User</span>
                </div>
            </div>
            <div class="row bg-white">
               <div class="col-md-12">
                   {{ $user->first_name }}  {{ $user->last_name }}
               </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Email</small><br/>
                    <span>{{ $user->email }}</span>
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Role</small><br/>
                    <span>Admin</span>
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Profession</small><br/>
                    <span>{{ $user->professions }}</span>
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Training</small><br/>
                    <span>{{ $user->trainings }}</span>
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-3">
                  <a role="button" href="{{ route('editUserProfile',$user->id)}}" class="btn btn-success">Edit Profile</a>
                </div>
                <div class="col-md-3">
                  <a href="{{route('deleteUser',$user->id )}}" class="btn btn-primary" value="">Delete Account</a>
                </div>   
                <div class="col-md-3">
                  
                </div>
                <div class="col-md-3">
                  
                </div>
            </div>
        </main>
        @endforeach
    </div>
</div>
@endsection
