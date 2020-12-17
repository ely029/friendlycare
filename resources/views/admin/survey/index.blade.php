@extends('layouts.admin.dashboard')

@section('title', 'Survey')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar');
</div>

<div class="section">
<div class="section__top">
    <h1 class="section__title">Survey</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link">Survey</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <a class="button button--create" href="{{ route('survey.create')}}">Create survey<i class="fa fa-plus"></i></a>
    <table class="table" id="table">
    <thead>
        <tr>
        <th class="table__head">Date</th>
        <th class="table__head">Title</th>
        <th class="table__head">Link</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $detail)
        <tr class="table__row js-view" data-href="{{ route('survey.information', $detail->id)}}">
        <td class="table__details">{{ \Carbon\Carbon::parse($detail->date_from)->format('Y/m/d') }}-{{ \Carbon\Carbon::parse($detail->date_to)->format('Y/m/d') }}</td>
        <td class="table__details">{{ $detail->title}}</td>
        <td class="table__details">{{ $detail->link}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>
</div>
@endsection
