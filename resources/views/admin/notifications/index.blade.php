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
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Events & Push Notifications</h2>
                    <span>Events & Notifications</span>
                </div>
            </div>
            <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <a class="button button--create" href="{{ route('notifications.create') }}">Create Notifications<i class="fa fa-plus"></i></a>
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-upcoming-events" role="tab" aria-controls="nav-home" aria-selected="true">Upcoming Events</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-past-events" role="tab" aria-controls="nav-profile" aria-selected="false">Past Events</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-upcoming-announcements" role="tab" aria-controls="nav-contact" aria-selected="false">Upcoming Announcements</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-past-announcements" role="tab" aria-controls="nav-contact" aria-selected="false">Past Announcements</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-upcoming-events" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingEvent as $events)
                                        <tr>
                                            <td>{{ $events->date}}</td>
                                            <td><a href="{{ route('notifications.information',$events->id)}}">{{ $events->title}}</a></td>
                                            <td>Event</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-past-events" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pastEvent as $events)
                                        <tr>
                                            <td>{{$events->date}}</td>
                                            <td>{{$events->title}}</td>
                                            <td>Event</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>                            </div>
                            <div class="tab-pane fade" id="nav-upcoming-announcements" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <table class="table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingAnnouncement as $events)
                                        <tr>
                                            <td>{{ $events->date}}</td>
                                            <td><a href="{{ route('notifications.information',$events->id)}}">{{ $events->title}}</a></td>
                                            <td>Announcement</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-past-announcements" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <table class="table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pastAnnouncement as $events)
                                        <tr>
                                            <td>{{ $events->date}}</td>
                                            <td>{{ $events->title }}</td>
                                            <td>Announcement</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </main>
    </div>
</div>
@endsection
