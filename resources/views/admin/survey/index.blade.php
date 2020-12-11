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
    <a class="button button--create" href="create-survey.html">Create survey<i class="fa fa-plus"></i></a>
    <table class="table" id="table">
    <thead>
        <tr>
        <th class="table__head">Date</th>
        <th class="table__head">Title</th>
        <th class="table__head">Link</th>
        </tr>
    </thead>
    <tbody>
        <tr class="table__row js-view" data-href="view-survey.html">
        <td class="table__details">01/20/2021-01/25/2021</td>
        <td class="table__details">Survey 10</td>
        <td class="table__details">https://forms.gle/XbvNYLxPJUpgF...</td>
        </tr>
    </tbody>
    </table>
</div>
</div>
@endsection
