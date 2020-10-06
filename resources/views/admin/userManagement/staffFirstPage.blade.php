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
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create User</h2>
                    <span>User Management</span><span>Create User</span>
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
        </main>
    </div>
</div>
@endsection
