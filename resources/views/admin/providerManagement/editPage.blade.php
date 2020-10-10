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
            <form method="POST" action="{{ route('updateProvider') }}">
                @csrf
             @foreach ($provider as $providers)
             <input type="hidden" name="user_id" value="{{ $providers->users_id}}">
             <input type="hidden" name="clinic_id" value="{{ $providers->c_id}}">
             <table class="table table-bordered">
                 <tr>
                     <td>Clinic Name</td>
                     <td><input type="text" name="clinic_name" value="{{ $providers->clinic_name }}"></td>
                 </tr>
                 <tr>

                 <tr>
                     <td>Description</td>
                     <td><input type="text" name="description" value="{{ $providers->description }}"></td>
                 </tr>
                 <tr>
                
                     <td>Email</td>
                     <td><input type="text" name="email" value="{{ $providers->email }}"></td>
                 </tr>
                 <tr>
                     <td>City</td>
                     <td><input type="text" name="city" value="{{ $providers->city }}"></td>
                 </tr>
                 <tr>
                     <td>Province</td>
                     <td><input type="text" name="province" value="{{ $providers->province }}"></td>
                 </tr>
                 <tr>
                     <td>Municipality</td>
                     <td><input type="text" name="municipality" value="{{ $providers->municipality }}"></td>
                 </tr>
                 <tr>
                     <td>Contact-Number</td>
                     <td><input type="text" name="contact_number" value="{{ $providers->contact_number }}"></td>
                 </tr>
                 <tr>
                     <td>Street Address</td>
                     <td><input type="text" name="street_address" value="{{ $providers->street_address }}"></td>
                 </tr>
                 <tr>
                 <tr>
                     <td><input type="submit" value="Edit Profile" class="btn btn-success"></td>
                 </tr>
             </table>
             @endforeach
              
             
        </form>
            
        </main>
    </div>
</div>
@endsection
