@extends('layouts.admin.dashboard')

@section('title', 'Patient Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Patient management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" >Patient management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @if ($errors->any())

@foreach ($errors->all() as $error)
<div class="alert alert-danger">{{ $error }}</div>
@endforeach
@endif
          <div class="patient">
            <div class="accordion accordion--patient">
              <ul class="accordion__list">
                <li class="accordion__item">
                  <input class="accordion__trigger" id="trigger1" type="checkbox" name="cb" />
                  <label class="accordion__title" for="trigger1">
                    Filter
                    <div class="accordion__arrow"></div>
                  </label>
                  <div class="accordion__content">
                    <form class="form form--patient" method="POST" action="{{ route('patientManagement.filter') }}">
                      @csrf
                      <div class="form__inline">
                        <div class="form__content"><input id="start_date" name="date-from" class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                        <div class="form__content"><input id="end_date" name="date-to" class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                        <div class="form__content">
                          <select name="age-range" id="age" class="form__input form__input--select form__input--border form__input--border__age">
                            <option disabled selected>Select age range</option>
                            <option value="1">19 years old and below</option>
                            <option value="2">20 years old and above</option>
                          </select>
                        </div>
                        <input type="submit" class="button button--filter button--filter__patient" value="Apply filter"/><button class="button button--filter button--filter__patient">Reset</button>
                      </div>
                    </form>
                  </div>
                </li>
              </ul>
            </div>
            <a class="button export button--filter button--filter__patient export_patient_list">Export patient list</a>
          </div>
          <table class="table" id="noSearch">
            <thead>
              <tr>
                <th class="table__head">ID No.</th>
                <th class="table__head">Name</th>
                <th class="table__head">Email</th>
                <th class="table__head">Age</th>
                <th class="table__head">Province</th>
                <th class="table__head">Date Registered</th>
              </tr>
            </thead>
            <tbody>
              @foreach($details as $detail)
              <tr class="table__row js-view" data-href="{{ route('patientManagement.information', $detail->id )}}">
                <td class="table__details">{{ $detail->id }}</td>
                <td class="table__details">{{ $detail->name }}</td>
                <td class="table__details">{{ $detail->email}}</td>
                <td class="table__details">{{ $detail->age }}</td>
                <td class="table__details">{{ $detail->province }}</td>
                <td class="table__details">{{ $detail->registered_at }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
</div>
@endsection
