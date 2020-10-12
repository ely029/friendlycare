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
                <a href="{{ route('providerManagement') }}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create User</h2>
                    <span>User Management</span><span>Create User</span>
                </div>
            </div>
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
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-4">
                <select class="form-control" id="role">
                    <option value="">Please Select</option>
                    <option value="{{ route('adminFirstPage') }}" selected>Admin</option>
                    <option value="{{ route('staffFirstPage') }}">Staff</option>
                </select>
                </div>
            </div>
            <form method="POST" action="{{ route('createAdmin') }}">
                @csrf
            <div class="row">
                 <div class="col-md-4">
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="col-md-4">
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                </div>
                <div class="col-md-4">        
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="text" class="form-control" name="professions" placeholder="Professional (optional)">
                </div>
                <div class="col-md-4">
                        <input type="text" class="form-control" name="trainings" placeholder="Training (optional)">
                </div>   
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
            <div class="col-md-4">
            <div class="input-group">
  <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="button-addon2">
                             <div class="input-group-append">

                      </div>
            </div>
                
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <div class="input-group">
  <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
</div>
                </div>
                <div class="col-md-4">
                    <input data-toggle="modal" data-target="#confirmProviderCreation" type="button" id="admin-create" value="Create Account" class="btn btn-info">
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Admin Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to create an Admin account. Proceed?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <input type="submit" class="btn btn-success" value="Create Account"/>
                                </div>
                        </div>
                    </div>
            </div>
        </form>
            
        </main>
    </div>
</div>
@endsection
