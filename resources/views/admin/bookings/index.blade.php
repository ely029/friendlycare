@extends('layouts.admin.dashboard')

@section('title', 'Bookings')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Bookings</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link">Bookings</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <div class="accordion accordion--bookings">
            <ul class="accordion__list">
              <li class="accordion__item">
                <input class="accordion__trigger" id="trigger1" type="checkbox" name="cb" checked />
                <label class="accordion__title" for="trigger1">
                  Filter
                  <div class="accordion__arrow"></div>
                </label>
                <div class="accordion__content">
                  <form class="form form--patient" method="POST" action="{{ route('booking.results') }}">
                  @csrf
                    <div class="form__inline">
                      <div class="form__content"><input name="date-from" id="date-from" class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                      <div class="form__content"><input name="date-to" id="date-to" class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                      <div class="form__content">
                        <select name="clinic_id" id="clinic_id" class="form__input form__input--select form__input--border form__input--border__age">
                          @foreach ($clinics as $clinic)
                          <option value="{{ $clinic->id}}">{{ $clinic->clinic_name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form__content">
                        <select name="service_id" id="service_id" class="form__input form__input--select form__input--border form__input--border__age">
                          <option disabled selected>Availed Services</option>
                          @foreach($services as $service)
                          <option value="{{ $service->id}}">{{ $service->name}} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form__content">
                        <select name="status" id="status" class="form__input form__input--select form__input--border form__input--border__age">
                          <option disabled selected>Status</option>
                          <option value="1">Upcoming/Confirmed</option>
                          <option value="2">Reschedule</option>
                          <option value="3">Cancelled</option>
                          <option value="4">Complete</option>
                          <option value="5">No Show</option>
                        </select>
                      </div>
                    </div>
                    <div class="form__button form__button--end form__button--bookings">
                      <button type="submit" class="button button--filter button--filter__patient">Apply filter</button>            
                      <button class="button button--filter button--filter__patient" id="export_booking">Export CSV</button>
                    </div>
                  </form>
                </div>
              </li>
            </ul>
          </div>
      </div>
      @endsection
