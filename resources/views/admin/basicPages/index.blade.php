@extends('layouts.admin.dashboard')

@section('title', 'Basic Pages')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
<div class="section__top">
    <h1 class="section__title">Basic Pages</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="basic-pages.php">Basic Pages</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <table class="table" id="basic">
    <thead>
        <tr>
        <th class="table__head">Title</th>
        <th class="table__head">Content</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($content as $contents)
    <tr class="table__row js-view" data-href="{{ route('basicPages.informationPage',$contents->id) }}">
        <td class="table__details table__details--basic">{{ $contents->content_name }}</td>
        <td class="table__details">{{ $contents->content }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
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
                <a href="{{ route('basicPages')}}" class="list-group-item active">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Basic Pages</h2>
                    <span>Basic Pages</span>
                </div>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Content</th>
                </tr>
                @foreach ($content as $contents)
                <tr>
                    <td><a href="{{ route('basicPages.informationPage',$contents->id) }}">{{ $contents->content_name }}</a></td>
                    <td>{{ $contents->content }}</td>
                </tr>
                @endforeach 
            </table>
        </main>
    </div>
</div> -->
@endsection
