@extends('layouts.admin.dashboard')

@section('title', 'Provider Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Provider Management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider Management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <a class="button button--create" href="{{ route('providerCreateFirstPage') }}">Create Provider<i class="fa fa-plus"></i></a>
          <table class="table" id="table">
            <thead>
              <tr>
                <th class="table__head">Name</th>
                <th class="table__head">Category</th>
                <th class="table__head">Rating</th>
                <th class="table__head">Assigned Staff</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clinics as $clinic)
              <tr class="table__row js-view" data-href="{{ route('editProviderProfile',$clinic->id)}}">
                <td class="table__details">{{$clinic->clinic_name}}</td>
                @if ($clinic->type == '1')
                            <td class="table__details">Private</td>
                            @elseif($clinic->type == '2')
                            <td class="table__details">Government</td>
                            @elseif($clinic->type == '3')
                            <td class="table__details">NGO</td>
                            @endif
                <td class="table__details"><span class="rateYo"></span></td>
                <input type="hidden" class="provider_rate" value="{{$ratings}}">
                <td class="table__details">{{ $countStaff }}</td>
              </tr>
            @endforeach
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
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
            <div class="row">
                <div class="col-12 py-4">
                    <h2>Provider Management</h2>
                    <span>User Management</span>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-12 py-4">
                    <a href="{{ route('providerCreateFirstPage') }}" class="btn btn-success">Create account</a>
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
                            <th>Name</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th>Assigned Staff</th>
                        </tr>
                        @foreach ($clinics as $clinic)
                        <tr>
                            <td><a href="{{ route('editProviderProfile',$clinic->id)}}">{{ $clinic->clinic_name}}</a></td>
                            @if ($clinic->type == '1')
                            <td>Private</td>
                            @elseif($clinic->type == '2')
                            <td>Government</td>
                            @elseif($clinic->type == '3')
                            <td>NGO</td>
                            @endif
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </main>
    </div>
</div> -->
@endsection
