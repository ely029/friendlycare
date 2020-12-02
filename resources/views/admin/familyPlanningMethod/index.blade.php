@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Family planning methods</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="family-planning-methods.php">Family planning methods</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <a class="button button--create" href="create-method.php">Create new method<i class="fa fa-plus"></i></a>
          <table class="table" id="table">
            <thead>
              <tr>
                <th class="table__head">ID No.</th>
                <th class="table__head">Name</th>
                <th class="table__head">Shortname</th>
                <th class="table__head">Category</th>
              </tr>
            </thead>
            <tbody>
              <tr class="table__row js-view" data-href="view-method.php">
                <td class="table__details">01</td>
                <td class="table__details">John Smith</td>
                <td class="table__details">johnsmith@gmail.com</td>
                <td class="table__details">Staff</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item active">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
            <div class="row">
                <div class="col-12 py-4">
                    <h2>Family Planning Method</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-12 py-4">
                    <a href="{{ route('familyPlanningMethod.firstPage') }}" class="btn btn-success">Create new Method</a>
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
                            <th>Short Name</th>
                            <th>Category</th>
                        </tr>
                            @foreach($details as $detail)
                            <tr>
                            <td>{{ $detail->id }}</td>
                            <td><a href="{{ route('familyPlanningMethod.information',$detail->id)}}">{{ $detail->name }}</a></td>
                            <td>{{ $detail->short_name }}</td>
                            @if ($detail->family_plan_type_id == '1')
                            <td>Modern Method</td>
                            @elseif ($detail->family_plan_type_id == '2')
                            <td>Permanent Method</td>
                            @elseif ($detail->family_plan_type_id == '3')
                            <td>Natural Method</td>
                            @endif
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </main>
    </div>
</div> -->
@endsection
