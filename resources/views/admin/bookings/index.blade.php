@extends('layouts.admin.dashboard')

@section('title', 'Patient Management')
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
                  <form class="form form--patient" action="">
                    <div class="form__inline">
                      <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date from" /></div>
                      <div class="form__content"><input class="form__input form__input--border" type="date" placeholder="Date to" /></div>
                      <div class="form__content">
                        <select class="form__input form__input--select form__input--border form__input--border__age">
                          <option disabled selected>Provider</option>
                          <option value=""> </option>
                        </select>
                      </div>
                      <div class="form__content">
                        <select class="form__input form__input--select form__input--border form__input--border__age">
                          <option disabled selected>Availed Services</option>
                          <option value=""> </option>
                        </select>
                      </div>
                      <div class="form__content">
                        <select class="form__input form__input--select form__input--border form__input--border__age">
                          <option disabled selected>Status</option>
                          <option value=""> </option>
                        </select>
                      </div>
                    </div>
                    <div class="form__button form__button--end form__button--bookings">
                      <button class="button button--filter button--filter__patient">Apply filter</button><button class="button button--filter button--filter__patient">Export csv</button>
                    </div>
                  </form>
                </div>
              </li>
            </ul>
          </div>
          <div class="reports__background">
            <div class="reports__background-wrapper"><img class="reports__background-image" src="/src/img/icon-calendar.png" alt="No results" /></div>
            <span class="reports__background-title">No results</span><span class="reports__background-text">Please specify your filters</span>
          </div>
          <div class="reports">
            <div class="reports__container">
              <div class="reports__content"><label class="reports__label">No. of patients</label><span class="reports__text reports__text--blue reports__text--blue__big">1,235</span></div>
              <div class="reports__content">
                <label class="reports__label">Availed services</label>
                <ul class="reports__list">
                  <li class="reports__item"><span class="reports__text reports__text--blue">245</span><span class="reports__text">COC / pills</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">125</span><span class="reports__text">Pop / minipills</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">42</span><span class="reports__text">Injectables</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">18</span><span class="reports__text">PSI Implants</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">27</span><span class="reports__text">IUD</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">304</span><span class="reports__text">Condom</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">74</span><span class="reports__text">Bilateral tubal ligation</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">15</span><span class="reports__text">No scalpel vasectomy</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">63</span><span class="reports__text">Lactational Amenorrhea</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">42</span><span class="reports__text">Billings Ovulation Method</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">53</span><span class="reports__text">Basal body temperature</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">102</span><span class="reports__text">Sympto-thermal method</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">125</span><span class="reports__text">Standard days method</span></li>
                </ul>
              </div>
              <div class="reports__content">
                <label class="reports__label">Status</label>
                <ul class="reports__list reports__list--status">
                  <li class="reports__item"><span class="reports__text reports__text--blue">15</span><span class="reports__text">Completed</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">15</span><span class="reports__text">Cancelled</span></li>
                  <li class="reports__item"><span class="reports__text reports__text--blue">15</span><span class="reports__text">No-show</span></li>
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
              <tr class="table__row">
                <td class="table__details">10/12/2020</td>
                <td class="table__details">John Smith</td>
                <td class="table__details">LAM</td>
                <td class="table__details">Clinic</td>
                <td class="table__details">Completed</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      @endsection
