@extends('layouts.admin.dashboard')

@section('title', 'Bookings')
@section('description', 'Dashboard')

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
    <a class="button button--create" href="create-ads.html">Create Ads<i class="fa fa-plus"></i></a>
    <div class="accordion accordion--ads">
      <ul class="accordion__list">
        <li class="accordion__item">
          <input class="accordion__trigger" id="trigger1" type="checkbox" name="cb" checked />
          <label class="accordion__title" for="trigger1">
            Filter
            <div class="accordion__arrow"></div>
          </label>
          <div class="accordion__content">
            <form class="form form--patient" action="">
              <div class="form__inline">
                <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                <button class="button button--filter button--filter__patient">Apply filter</button><button class="button button--filter button--filter__patient">Export csv</button>
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
        <tr class="table__row">
          <td class="table__details">10/12/2020</td>
          <td class="table__details">John Smith</td>
          <td class="table__details">LAM</td>
          <td class="table__details">12</td>
          <td class="table__details">12</td>
          <td class="table__details"><a class="table__link" href="https://forms.gle/XbvNYLxPJUpgF">https://forms.gle/XbvNYLxPJUpgF</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection
