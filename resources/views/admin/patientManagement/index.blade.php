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
                    <form class="form form--patient" action="">
                      <div class="form__inline">
                        <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                        <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                        <div class="form__content">
                          <select class="form__input form__input--select form__input--border form__input--border__age">
                            <option disabled selected>Select age range</option>
                            <option value="19 years old and below">19 years old and below</option>
                            <option value="20 years old and above">20 years old and above</option>
                          </select>
                        </div>
                        <button class="button button--filter button--filter__patient">Apply filter</button><button class="button button--filter button--filter__patient">Reset</button>
                      </div>
                    </form>
                  </div>
                </li>
              </ul>
            </div>
            <button class="button button--filter button--filter__patient">Export patient list</button>
          </div>
          <table class="table" id="noSearch">
            <thead>
              <tr>
                <th class="table__head">ID No.</th>
                <th class="table__head">Name</th>
                <th class="table__head">Email</th>
                <th class="table__head">Age</th>
                <th class="table__head">Province</th>
              </tr>
            </thead>
            <tbody>
              <tr class="table__row js-view" data-href="view-patient.html">
                <td class="table__details">1</td>
                <td class="table__details">John Smith</td>
                <td class="table__details">johnsmith@gmail.com</td>
                <td class="table__details">24</td>
                <td class="table__details">Laguna</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
</div>
@endsection
