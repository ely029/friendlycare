@extends('layouts.admin.dashboard')

@section('title', 'Notifications')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Edit notification</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{route('notifications.index')}}">Events &amp; Push Notifications</a><a class="breadcrumbs__link" href="edit-notification.php">Edit</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @foreach($details as $detail)
                <form class="form" id="js-provider-form" method="POST" action="{{ route('notifications.postEdit')}}">
                  @csrf
                  <input type="hidden" value="{{ $detail->id }}" name="id"/> 
                <ul class="form__group">
              <li class="form__group-item">
                <h2 class="section__heading">Details</h2>
                <div class="form__content">
                  <select class="form__input form__input--select" name="schedule" id="js-schedule-1" required>
                    <option disabled selected>---</option>
                    @if($detail->scheduled == 'Scheduled')
                    <option value="Post Now">Post Now</option>
                    <option value="Scheduled" selected>Scheduled</option>
                    @else
                    <option value="Post Now" selected>Post Now</option>
                    <option value="Scheduled">Scheduled</option>
                    @endif
                  </select>
                  <label class="form__label">Schedule* </label>
                </div>
                <div class="form__content js-scheduled-content-1"><input class="form__input" type="time" name="time" value="{{$detail->time}}"placeholder="Time"/><label class="form__label">Time*</label></div>
                <div class="form__content js-scheduled-content-1"><input class="form__input" type="date" name="date" value="{{$detail->date}}"placeholder="Date"/><label class="form__label">Date*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" name="type" required>
                    <option disabled selected>---</option>
                    @if($detail->type == '2')
                    <option value="1">Event</option>
                    <option value="2" selected >Announcement</option>
                    @else
                    <option value="1" selected>Event</option>
                    <option value="2">Announcement</option>
                    @endif
                  </select>
                  <label class="form__label">Type*</label>
                </div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Content</h2>
                <div class="form__content"><input class="form__input" type="text" placeholder="Title" value="{{$detail->title}}" name="title" required /><label class="form__label">Title*</label></div>
                <div class="form__content">
                  <textarea class="form__input form__input--message" name="message" contenteditable placeholder="Description (English)*" required>{{ $detail->message }}</textarea>
                  <label class="form__label">Message*</label>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--end"><button class="button js-trigger" type="submit">Save changes</button></div>
          </form>
        @endforeach
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Success!</h2>
                <p class="modal__text">Your message has been saved.</p>
                <div class="modal__button modal__button--center"><button class="button button--medium" type="button">Confirm</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
</div> -->
@endsection
