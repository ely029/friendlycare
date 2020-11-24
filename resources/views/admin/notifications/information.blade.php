@extends('layouts.admin.dashboard')

@section('title', 'Notifications')
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
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
                <a href="{{ route('notifications.index')}}" class="list-group-item active">Events and Push Notifications</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
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
                @foreach($details as $detail)
                <div class="row">
                <div class="col-12 py-4">
                    <h2>{{$detail->title}}</h2>
                    <span>Events & Notifications</span><span>View</span>
                </div>
               </div>
               <div class="row">
                   <div class="col-md-12">
                       <span>{{ $detail->title}}</span>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                       <span>Date</span><br>
                       {{ $detail->date}}
                   </div>
                   <div class="col-md-6">
                       <span>Time</span><br>
                       {{ $detail->time}}
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                       <span>Message</span><br><br>
                       {{ $detail->message}}
                       <br/><br/>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                       <a href="{{ route('notifications.edit', $detail->id)}}" class="btn btn-success">Edit Notification</a>
                   </div>
                   <div class="col-md-6">
                       <a href="{{route('notifications.delete', $detail->id)}}" class="btn btn-primary">Delete Notification</a>
                   </div>
               </div>
              @endforeach
            </div>
        </main>
    </div>
</div>
@endsection
