@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
        @if (Auth::user()->role_id == 2)
        <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
            </div>
            @else
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item active">Family Planning Method</a>
            </div>
        @endif

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
        <form method="POST" action="{{ route('familyPlanningMethod.createOne')}}" enctype="multipart/form-data">
            @csrf
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Family Planning Method</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                     <span>Details</span><br/>
                     <input type="file" name="icon"><br/><br/>
                     <input type="text" class="form-control" placeholder="Method Name">
                     <br/></br>
                     <input type="text" name="short_name" class="form-control" placeholder="Short Name"><br/><br/>
                     <select name="family_plan_type_id" class="form-control">
                         <option value="">Select Method...</option>
                         <option value="1">Modern Method</option>
                         <option value="2">Permanent Method</option>
                         <option value="3">Natural Method</option>
                     </select>
                 </div>
                 <div class="col-md-6">
                 <span>Effectiveness</span><br/>
                 <br/><br/>
                     <input type="text" name="percent_effective" class="form-control" placeholder="Sa tamang paggamit"/><br/>
                     <input type="text" name="typical_validity" class="form-control" placeholder="Typikal na bisa">
                 </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-success" value="Next"/>
                </div>
            </div>
        </form>
        </main>
    </div>
</div>
@endsection