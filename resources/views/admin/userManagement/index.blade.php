@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">User Management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('userManagement')}}">User Management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <a class="button button--create" href="{{ route('userRole') }}">Create Account<i class="fa fa-plus"></i></a>
          <table class="table" id="table">
            <thead>
              <tr>
                <th class="table__head">ID No.</th>
                <th class="table__head">Name</th>
                <th class="table__head">Email</th>
                <th class="table__head">Role</th>
                <th class="table__head">Provider Clinic</th>
              </tr>
            </thead>
            <tbody>
            @foreach($admin as $admins)
            <tr class="table__row js-view" data-href="{{ route('editUserProfilePage',$admins->id) }}">
                <td class="table__details">{{ $admins->id }}</td>
                <td class="table__details">{{ $admins->name }}</a></td>
                <td class="table__details">{{ $admins->email }}</td>
                @if($admins->role_id == '2')
                            <td>Admin</td>
                            @elseif($admins->role_id == '4')
                            <td>Staff</td>
                            @endif
                <td class="table__details">{{ $admins->clinic_name }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
