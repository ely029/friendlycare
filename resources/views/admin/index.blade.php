@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
      @if (Auth::user()->role_id == '1')
      <div class="list-group w-100">
                <span>Management</span>
                <a href='{{ route("userManagement") }}' class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Contents</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
            </div>
      @elseif (Auth::user()->role_id == '2')
      <div class="list-group w-100">
                <span>Management</span>
                <a href='{{ route("userManagement") }}' class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
      </div>
      @endif
      

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                </div>
            </div>
            <div class="row bg-white">
                
            </div>
        </main>
    </div>
</div>
@endsection
