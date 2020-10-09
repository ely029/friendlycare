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
                    <option value="{{ route('adminFirstPage') }}">Admin</option>
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
                        <input type="text" class="form-control" name="profession" placeholder="Professional (optional)">
                </div>
                <div class="col-md-4">
                        <input type="text" class="form-control" name="training" placeholder="Training (optional)">
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
                            <button class="btn btn-outline-secondary password_btn" type="button"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
  <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg></button>
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
