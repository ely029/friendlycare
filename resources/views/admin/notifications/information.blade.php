@extends('layouts.admin.dashboard')

@section('title', 'Notifications')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>
@foreach($details as $detail)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{ $detail->title}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{route('notifications.index')}}">Events &amp; Push Notifications</a><a class="breadcrumbs__link" >View</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" id="js-provider-form" method="POST" action="{{route('notifications.delete', $detail->id)}}">
            @csrf
            <h2 class="section__heading">{{ $detail->title}}</h2>
            @if ($detail->type == '2')
            <div class="form__content"><span class="form__text">Announcements</span><label class="form__label form__label--visible">Type</label></div>
            @else
            <div class="form__content"><span class="form__text">Events</span><label class="form__label form__label--visible">Type</label></div>
            @endif
            <div class="form__inline">
              <div class="form__content"><span class="form__text"> {{ $detail->date}}</span><label class="form__label form__label--visible">Date</label></div>
              <div class="form__content"><span class="form__text">{{ $detail->time}}</span><label class="form__label form__label--visible">Time</label></div>
            </div>
            <div class="form__content">
              <span class="form__text">{{$detail->message}}</span>
              <label class="form__label form__label--visible">Message</label>
            </div>
            <div class="form__button form__button--start"><a class="button" href="{{ route('notifications.edit', $detail->id)}}">Edit notification</a><input type="button" class="button button--transparent js-trigger" value="Delete notification"/></div>
            <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Delete notification?</h2>
                <p class="modal__text">Are you sure you want to delete this notification?</p>
                <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button>
                <button class="button button--medium button--medium__delete" type="submit">Delete notification</button></div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
@endforeach


<!-- <div class="container-fluid">
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
            hidden spacer
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
</div> -->
@endsection
