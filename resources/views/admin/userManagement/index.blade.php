@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
        @if (Auth::user()->role_id == 1)
        <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item active">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
            </div>
            @else
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item active">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
            </div>
        @endif

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <form method="POST" action="{{ route('userManagement.filter') }}">
                @csrf
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
                        <option value="">Select Filter</option>
                        <option value="by_admin">By Admin</option>
                        <option value="by_staff">By Staff</option>
                    </select>
                </div>
                <div class="col-4">
                 <input type="submit" class="btn btn-success" value="Filter">            
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
                            <td><a href="{{ route('editUserProfilePage',$admins->id) }}">{{ $admins->name }}</a></td>
                            <td>{{ $admins->email }}</td>
                            @if($admins->role_id == '2')
                            <td>Admin</td>
                            @else
                            <td>Staff</td>
                            @endif
                            <td>{{ $admins->clinic_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            </form>
            
        </main>
    </div>
</div>
@endsection
