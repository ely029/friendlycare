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
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item active">Basic Pages</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create provider</h2>
                    <span>Provider Management</span><span>Create Provider</span>
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
            <form method="POST" action="{{ route('storeFirstPage') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                     <div class="col-md-12">
                         <span>Profile Icon</span>
                         <input type="file" name="pic"/>
                     </div>
                </div>
            <div class="row">
                 <div class="col-md-4">
                    <input type="text" value="{{ old('clinic_name') }}" name="clinic_name" class="form-control" placeholder="Provider name">
                </div>
                <div class="col-md-4">
                    <input type="text" name="province" value="{{ old('clinic_name')}}" id="province" class="form-control" placeholder="Province">
                                    </div>
                <div class="col-md-4">        
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <select name="type" class="form-control">
                            <option value="1">Private</option>
                            <option value="2">Government</option>
                            <option value="3">NGO</option>
                        </select>
                </div>
                <div class="col-md-4">
                        <input type="text" class="form-control" value="{{ old('city') }}" id="city" name="city" placeholder="City">
                </div>   
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" maxlength="14" placeholder="Contact Number">
                </div>
                <div class="col-md-4">
                <input type="text" class="form-control" valu="{{ old('municipality') }}" name="municipality" placeholder="Municipality">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="email" name="email" value=" {{ old('email') }}"class="form-control" placeholder="Email Address">
                </div>
                <div class="col-md-4">
                       <input type="text" name="description" value="{{ old('description') }}"class="form-control" placeholder="Description">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <input type="text" class="form-control" name="address" value="{{ old('address') }}"placeholder="Street Address"><br/>
                <span>Is this philhealth accredited?</span><br/>
                <input type="radio" name="philhealth_accredited_1" value="1" checked>Yes</br>
                <input type="radio" name="philhealth_accredited_1" value="0">No
                </div>
                <div class="col-md-4">
                    <input type="submit" value="Next" class="btn btn-info">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
             <div class="col-md-12">
             @if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif
             </div>
            </div>
        </form>
            
        </main>
    </div>

</div>
@endsection
