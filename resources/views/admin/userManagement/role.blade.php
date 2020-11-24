@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">Create User</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="user-management.php">Create User</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        <div class="row bg-white">
                <select class="form-control" id="role">
                    <option value="">Please Select</option>
                    <option value="{{ route('adminFirstPage') }}">Admin</option>
                    <option value="{{ route('staffFirstPage') }}">Staff</option>
                </select>
            </div>
        </div>
      </div>
    </div>
@endsection

<!-- <div class="container-fluid">
        @include('includes.sidebar')
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create User</h2>
                </div>
            </div>
            <div class="row bg-white">
                <select class="form-control" id="role">
                    <option value="">Please Select</option>
                    <option value="{{ route('adminFirstPage') }}">Admin</option>
                    <option value="{{ route('staffFirstPage') }}">Staff</option>
                </select>
            </div>
        </main>
</div> -->