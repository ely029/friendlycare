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
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Events & Push Notifications</h2>
                    <span>Events & Notifications</span>
                </div>
            </div>
            <form method="POST" action="{{ route('notifications.postEdit')}}">
                @csrf
                @foreach($details as $detail)
                <input type="hidden" value="{{ $detail->id }}" name="id"/>
                <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>Details</span><br/>
                        <select name="schedule" class="form-control schedule">
                            @if($detail->schedule = 2)
                            <option value="1">Post Now</option>
                            <option value="2" selected>Scheduled</option>
                            @else
                            <option value="1" selected>Post Now</option>
                            <option value="2">Scheduled</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="title" value="{{$detail->title }}" class="form-control">
                    </div>
                </div>
                @if($detail->schedule = 2)
                <div>
                <div class="row">
                        <div class="col-md-6">
                            <input value="" type="date" name="date" class="form-control">
                        </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="time" name="time" class="form-control">
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                <div class="col-md-6">
                    <select name="type" class="form-control">
                        @if($detail->type = 1)
                        <option value="1" selected>Event</option>
                        <option value="2">Announcements</option>
                        @else
                        <option value="1">Event</option>
                        <option value="2" selected>Announcements</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <textarea name="message" style="width:500px;height:200px;">{{ $detail->message }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <input type="submit" class="btn btn-success" value="Submit"/>
                </div>
            </div>
            </div>
                @endforeach
            </form>
        </main>
    </div>
</div>
@endsection
