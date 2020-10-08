@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item active">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row">
                <div class="col-12 py-4">
                    <h2>User Management</h2>
                    <span>User Management</span>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-12 py-4">
                  <a href="{{ route('userRole') }}" class="btn btn-success">Create account</a>
                </div>
            </div>
            
            <div class="row bg-white">
                <div class="col-2">
                    <select name="filter" class="form-control">
                        <option>Filter</option>
                        <option>Filter</option>
                        <option>Filter</option>
                    </select>
                </div>
                <div class="col-4">
            
                </div>
                <div class="col-4">
            
                </div>
                <div class="col-2">
                    <input type="text" class="form-control" placeholder="Search"/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Provider Clinic</th>
                        </tr>
                        @foreach ($admin as $admins)
                        <tr>
                            <td>{{ $admins->id }}</td>
                            <td><a href="{{ route('editUserProfile',$admins->id) }}">{{ $admins->first_name }} {{ $admins->last_name }}</a></td>
                            <td>{{ $admins->email }}</td>
                            <td>Admin</td>
                            <td></td>
                        </tr>
                        @endforeach
                        @foreach ($staffs as $staff)
                        <tr>
                            <td>{{ $staff->id }}</td>
                            <td><a href="{{ route('editUserProfile',$staff->id) }}">{{ $staff->first_name }} {{ $staff->last_name }}</a></td>
                            <td>{{ $staff->email }}</td>
                            <td>Staff</td>
                            <td>{{ $staff->clinic_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
