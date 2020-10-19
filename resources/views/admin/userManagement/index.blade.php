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
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
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
            
            <form method="POST" action="{{ route('userManagement.filter') }}">
            <div class="row bg-white">
                @csrf
                <div class="col-md-4">
                    <select name="filter" class="form-control">
                        <option value="by_admin">By Admin</option>
                        <option value="by_staff">By Staff</option>
                        <option value="by_all">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                <input type="submit" class="btn btn-success" value="Filter">
                </div>            
               </form>
               <div class="col-md-2">
                   <form method="POST" action="{{ route('userManagement.search')}}">
                       @csrf
                   <select name="search_by" class="form-control">
                       <option value="id">ID</option>
                       <option value="name">Name</option>
                       <option value="role">Role</option>
                       <option value="clinic">Provider Clinic</option>
                   </select>
               </div>
               <div class="col-md-2">
                   <input type="text" name="search" class="form-control"/>
               </div>
               <div class="col-md-2">
                   <input type="submit" class="btn btn-success" value="Search">
</form>
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
                            @elseif($admins->role_id == '4')
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
