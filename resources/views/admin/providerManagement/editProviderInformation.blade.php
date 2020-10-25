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
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        @foreach ($provider as $providers)
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>{{ $providers->clinic_name }}</h2>
                    <span>Provider Management</span>&nbsp;&nbsp;&nbsp;<span>{{ $providers->clinic_name }}</span>
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
                                    <span>{{ $providers->clinic_name }}</span><br>
                                    <span>{{$providers->email }}</span><br>
                                    <span>{{ $providers->contact_number }}</span>
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
                            <span>{{ $providers->city }}{{ $providers->municipality }} {{ $providers->province }}</span>
                        </div>
                    </div>
                    <div class="row clinic-info-category">
                        <div class="col-md-6">
                        <h6><b>Category</b></h6>
                            @if($providers->type == '1')
                            <span>Private</span>
                            @elseif($providers->type == '2')
                            <span>Government</span>
                            @elseif($providers->type == '3')
                            <span>NGO</span>
                            @endif
                        </div>
                    </div>
                    <div class="row clinic-info-description">
                        <div class="col-md-6">
                        <h6><b>Description</b></h6>
                            <span>{{ $providers->description }}</span>
                        </div>
                    </div>
                    <div class="row bg-white">
                    <h4><b>Services</b></h4>
                    </div>
                        <div class="row bg-white">
                            <div class="col-md-4">
                            <h5>Modern Method</h5><br>
                            @foreach ($modernMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                            <div class="col-md-4">
                            <h5>Permanent Method</h5><br>
                            @foreach ($permanentMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                            <div class="col-md-4">
                            <h5>Natural Method</h5><br>
                            @foreach ($naturalMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                        </div>
                    <div class="row bg-white">
                       <div class="col-md-12">
                       <h5><b>Staffs</b></h5>
                       </div>
                    </div>
                    <div class="row bg-white">
                       <div class="col-md-12">
                       @foreach($staffs as $staff)
                       <span>{{ $staff->first_name}} {{ $staff->last_name}}</span><br/>
                       @endforeach
                       </div>
                    </div>
                    <div class="row">
                          <div class="col-md-6">
                              <a href="{{ route('editPage',$providers->id )}}" class="btn btn-success">Edit Profile</a>
                          </div>
                          <div class="col-md-6">
                              @if (Auth::user()->role_id == 2)
                              @else
                              <a data-toggle="modal" data-target="#confirmProviderCreation" href="#" class="btn btn-secondary">Delete Provider</a>
                              @endif
                          </div>
                    </div>

                    <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Provider</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete this provider. Proceed?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('deleteProvider',$providers->id )}}" class="btn btn-success">Delete Provider</a>
                                </div>
                        </div>
                    </div>
            </div>
            </form>           
        </main>
        @endforeach
        
    </div>
</div>
@endsection
