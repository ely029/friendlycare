@extends('layouts.admin.dashboard')

@section('title', 'Notifications')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
  @include('includes.sidebar')
</div>

<div class="section">
<div class="section__top">
    <h1 class="section__title">Events &amp; Push Notifications</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link">Events &amp; Push Notifications</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <a class="button button--create" href="{{ route('notifications.create') }}">Create new notification<i class="fa fa-plus"></i></a>
    <ul class="tabs__list tabs__list--notifications">
        <li class="tabs__item tabs__item--notifications tabs__item--current">Upcoming Events</li>
        <li class="tabs__item tabs__item--notifications">Past events</li>
        <li class="tabs__item tabs__item--notifications">Upcoming Announcements</li>
        <li class="tabs__item tabs__item--notifications">Past Announcements</li>
    </ul>

    <div class="tabs__details tabs__details--active">
        <table class="table notificationsTable">
            <thead>
                <tr>
                <th class="table__head">Date</th>
                <th class="table__head">Title</th>
                <th class="table__head">Type</th>
                </tr>
            </thead>
            <tbody>
            @foreach($upcomingEvent as $events)
            <tr class="table__row js-view" data-href="{{ route('notifications.information',$events->id)}}">
                <td class="table__details">{{ $events->date}}</td>
                <td class="table__details">{{ $events->title}}</td>
                <td class="table__details"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="tabs__details">
        <table class="table notificationsTable">
            <thead>
                <tr>
                <th class="table__head">Date</th>
                <th class="table__head">Title</th>
                <th class="table__head">Type</th>
                </tr>
            </thead>
            <tbody>
            @foreach($upcomingEvent as $events)
            <tr class="table__row js-view" data-href="{{ route('notifications.information',$events->id)}}">
                <td class="table__details">{{ $events->date}}</td>
                <td class="table__details">{{ $events->title}}</td>
                <td class="table__details">Upcoming Event</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="tabs__details">
        <table class="table notificationsTable">
            <thead>
                <tr>
                <th class="table__head">Date</th>
                <th class="table__head">Title</th>
                <th class="table__head">Type</th>
                </tr>
            </thead>
            <tbody>
            @foreach($upcomingAnnouncement as $events)
            <tr class="table__row js-view" data-href="{{ route('notifications.information',$events->id)}}">
                <td class="table__details">{{ $events->date}}</td>
                <td class="table__details">{{ $events->title}}</td>
                <td class="table__details">Upcoming Announcement</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="tabs__details">
        <table class="table notificationsTable">
            <thead>
                <tr>
                <th class="table__head">Date</th>
                <th class="table__head">Title</th>
                <th class="table__head">Type</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pastAnnouncement as $events)
            <tr class="table__row js-view" data-href="{{ route('notifications.information',$events->id)}}">
                <td class="table__details">{{ $events->date}}</td>
                <td class="table__details">{{ $events->title}}</td>
                <td class="table__details">Past Announcement</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<!-- <div class="container-fluid">
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
                                            <td><a href="{{ route('notifications.information',$events->id)}}">{{ $events->title}}</a></td>
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
                                            <td><a href="{{ route('notifications.information',$events->id)}}">{{ $events->title}}</a></td>
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
</div> -->
@endsection
