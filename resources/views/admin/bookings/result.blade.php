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
                  <form class="form form--patient" method="POST" action="{{ route('booking.results')}}">
                    @csrf
                    <div class="form__inline">
                      <div class="form__content"><input id="date-from" name="date-from" value= "{{ $inputs['date-from']}}" class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                      <div class="form__content"><input id="date-to" name="date-to" value= "{{ $inputs['date-to']}}" class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                      <div class="form__content">
                        <select name="clinic_id" id="clinic_id" class="form__input form__input--select form__input--border form__input--border__age">
                          @foreach($selected_clinic as $clinic)
                          <option selected value="{{ $clinic->id}}">{{ $clinic->clinic_name}}</option>
                          @endforeach
                          @foreach ($providers as $provider)
                          <option value="{{ $provider->id}}">{{ $provider->clinic_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form__content">
                        <select name="service_id" id="service" class="form__input form__input--select form__input--border form__input--border__age">
                          @foreach($selected_service as $eee)
                          <option selected value="{{ $eee->id }}">{{ $eee->name }}</option>
                          @endforeach
                          @foreach($service as $services)
                          <option value="{{ $services->id}}">{{ $services->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form__content">
                        <select name="status" id="status" class="form__input form__input--select form__input--border form__input--border__age">
                          @foreach ($selected_status as $status)
                          <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                          @endforeach
                          <option value="1">Upcoming/Confirmed</option>
                          <option value="2">Reschedule</option>
                          <option value="3">Cancelled</option>
                          <option value="4">Complete</option>
                          <option value="5">No Show</option>
                        </select>
                      </div>
                    </div>
                    <div class="form__button form__button--end form__button--bookings">
                      <button type="submit" id="export_booking" class="button button--filter button--filter__patient">Apply filter</button>
                      <a  href="#" type="button" class="button button--filter button--filter__patient export_booking">Export CSV</a>
                    </div>
                  </form>
                </div>
              </li>
            </ul>
          </div>
          <div class="reports">
            <div class="reports__container">
              <div class="reports__content"><label class="reports__label">No. of patients</label><span class="reports__text reports__text--blue reports__text--blue__big">{{ $count_patient }}</span></div>
              <div class="reports__content">
                <label class="reports__label">Availed services</label>
                <ul class="reports__list">
                  @foreach ($availed_service as $service)
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $service->services_count }}</span><span class="reports__text">{{ $service->service }}</span></li>
                  @endforeach
                </ul>
              </div>
              <div class="reports__content">
                <label class="reports__label">Status</label>
                <ul class="reports__list reports__list--status">
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $complete }}</span><span class="reports__text">Completed</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $cancelled }}</span><span class="reports__text">Cancelled</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $noshow }}</span><span class="reports__text">No-show</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $confirmed }}</span><span class="reports__text">Confirmed</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">{{ $reschedule }}</span><span class="reports__text">Reschedule</span></li>
                </ul>
              </div>
            </div>
          </div>
          <table class="table" id="noSearch">
            <thead>
              <tr>
                <th class="table__head">Date</th>
                <th class="table__head">Name</th>
                <th class="table__head">Availed service</th>
                <th class="table__head">Clinic</th>
                <th class="table__head">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($details as $detail)
              <tr class="table__row">
                <td class="table__details">{{ $detail->booked_date}}</td>
                <td class="table__details">{{ $detail->name}}</td>
                <td class="table__details">{{ $detail->service_name }}</td>
                <td class="table__details">{{ $detail->clinic_name }}</td>
                <td class="table__details">{{ $detail->status }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endsection