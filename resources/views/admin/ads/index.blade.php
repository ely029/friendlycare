@extends('layouts.admin.dashboard')

@section('title', 'Bookings')
@section('description', 'Dashboard')
`
@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
  <div class="section__top">
    <h1 class="section__title">Ad Management</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link">Ad Management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
  </div>
  <div class="section__container">
    <a class="button button--create" href="{{ route('ads.create') }}">Create Ads<i class="fa fa-plus"></i></a>
    <div class="accordion accordion--ads">
      <ul class="accordion__list">
        <li class="accordion__item">
          <input class="accordion__trigger" id="trigger1" type="checkbox" name="cb" checked />
          <label class="accordion__title" for="trigger1">
            Filter
            <div class="accordion__arrow"></div>
          </label>
          <div class="accordion__content">
            <form class="form form--patient" action="{{ route('ads.filter') }}" method="POST">
              @csrf
              <div class="form__inline">
                <div class="form__content"><input id="start_date" name="start_date" class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                <div class="form__content"><input id="end_date" name="end_date" class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                <button class="button button--filter button--filter__patient">Apply filter</button><a class="button button--filter button--filter__patient export">Export csv</a>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </div>
    <table class="table" id="noSearch">
      <thead>
        <tr>
          <th class="table__head">Date</th>
          <th class="table__head">Company name</th>
          <th class="table__head">Title</th>
          <th class="table__head">Views</th>
          <th class="table__head">Clicks</th>
          <th class="table__head">Link</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $datas)
        <tr class="table__row" data-href="{{ route('ads.information', $datas->id)}}">
          <td class="table__details"><a href="{{ route('ads.viewInformation', $datas->id) }}">{{ $datas->start_date }}</a></td>
          <td class="table__details">{{ $datas->company_name }}</td>
          <td class="table__details">{{ $datas->title }}</td>
          <td class="table__details">{{ $datas->count_views}}</td>
          <td class="table__details">{{ $datas->count_clicks}}</td>
          <td class="table__details"><a class="table__link" href="{{ $datas->ad_link}}">{{ $datas->ad_link }}</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
