@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">

            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>FriendlyCare Cubao</h2>
                    <span>Provider Management</span>&nbsp;&nbsp;&nbsp;<span>FriendlyCare Cubao</span>
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
            <form method="POST" action="#">
             @csrf
             <div class="row">
                 <div class="col-md-6">
                        <img class="rounded-cirle" width="100" height="100" src="{{ asset('assets/app/img/avatar6.png')}}"/>
                                <div class="edit-page-provider-info-image-side">
                                    <span>FriendlyCare Cubao</span><br>
                                    <span>email</span><br>
                                    <span>Contact Number</span>
                                </div>
                 </div>
                 <div class="col-md-2">
                 </div>
                 <div class="col-md-4">
                   <span>Status</span>
                   <input type="checkbox" name="is_enabled" checked/>
                 </div>
             </div>
                    <div class="row clinic-info-title">
                        <div class="col-md-6">
                        <h4><b>Clinic Info</b></h4>
                        </div>
                        <div class="col-md-6">
                            <span>Gallery</span>
                        </div>
                    </div>
                    <div class="row clinic-info-street">
                        <div class="col-md-6">
                        <h6><b>Street Address</b></h6>
                            <span>Project 4 Quezon City</span>
                        </div>
                    </div>
                    <div class="row clinic-info-category">
                        <div class="col-md-6">
                        <h6><b>Category</b></h6>
                            <span>Government</span>
                        </div>
                    </div>
                    <div class="row clinic-info-description">
                        <div class="col-md-6">
                        <h6><b>Description</b></h6>
                            <span>Sample Description</span>
                        </div>
                    </div>
            </form>           
        </main>
    </div>
</div>
@endsection
