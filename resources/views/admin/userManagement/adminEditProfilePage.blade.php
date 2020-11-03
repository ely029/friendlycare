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
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
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
                    @if ($user->role_id == 2)
                    <span>Admin</span>
                    @elseif ($user->role_id == 4)
                    <span>Staff</span>
                    @endif
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
            @foreach ($clinic as $clinics )
            <div class="row bg-white">
                <div class="col-md-12">
                    <small>Clinic</small><br/>
                    <span>{{ $clinics->clinic_name }}</span>
                </div>   
            </div>
            @endforeach
            <div class="row bg-white">
                <div class="col-md-3">
                  <a role="button" href="{{ route('editUserProfile',$user->id)}}" class="btn btn-success">Edit Profile</a>
                </div>
                <div class="col-md-3">
                    @if (Auth::user()->role_id == 2)
                    @else
                    <a data-toggle="modal" data-target="#confirmProviderCreation" href="#" class="btn btn-secondary">Delete Account</a>
                    @endif
                </div>   
                <div class="col-md-3">
                  
                </div>
                <div class="col-md-3">
                  
                </div>
                <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete this account. Proceed?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{route('deleteUser',$user->id )}}" class="btn btn-success">Delete Account</a>
                                </div>
                        </div>
                    </div>
            </div>
            </div>
        </main>
        @endforeach
    </div>
</div>
@endsection
