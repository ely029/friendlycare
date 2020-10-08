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
                <a href="#" class="list-group-item">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
        @foreach ($users as $user)
        <form method="POST" action="{{ route('updateUser') }}">
            @csrf
        <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Edit Profile</h2>
                    <span>User Management</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Create User</span>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>First Name</small><br/>
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                    <input type="hidden"  name="id" value="{{ $user->id }}">
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Last Name</small><br/>
                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Email</small><br/>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
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
                    <input type="text" name="profession" value="{{ $user->profession }}" class="form-control" >
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Training</small><br/>
                    <input type="text" name="training" value="{{ $user->training }}" class="form-control">
                </div>   
            </div>
            <div class="row bg-white">
                <div class="col-md-3">
                  <input type="submit" class="btn btn-success" value="Update Profile"/>
                </div>
                <div class="col-md-3">
                  <input type="submit" class="btn btn-primary" value="Delete Account">
                </div>   
                <div class="col-md-3">
                  
                </div>
                <div class="col-md-3">
                  
                </div>
            </div>
       </form>
        @endforeach
        </main>
    </div>
</div>
@endsection
