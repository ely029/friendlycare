@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
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
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
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
            <div class="row">
                <div class="col-12 py-4">
                    <h2>Create Service</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Content</h3>
                </div>
            </div>
            <form method="POST" action="{{ route('familyPlanningMethod.createThree') }}" enctype="multipart/form-data">
             @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4>Clinic Gallery</h4>
                    <br/>
                    <input type="file" name="pics[]" multiple>
                </div>
                <div class="col-md-6">
                    <h4>Video</h4><br/>
                    <input class="form-control" placeholder="Video Link" type="text" name="video_link"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <input data-toggle="modal" data-target="#confirmCreateFPM" type="button" value="Finish" class="btn btn-success"/>
                </div>
            </div>
            <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Family Planning Method</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to create a Family Planning Method. Proceed?
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('familyPlanningMethod.delete',Session::get('id'))}}" class="btn btn-secondary">Cancel</a>
                                    <input type="submit" class="btn btn-success" value="Create service"/>
                                </div>
                        </div>
                    </div>
            </div>
            </form>            
        </main>
    </div>
</div>
@endsection
