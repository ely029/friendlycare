@extends('layouts.admin.dashboard')

@section('title', 'Patient Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Patient Smith</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="patient-management.html">Patient Management</a><a class="breadcrumbs__link" >Patient Smith</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--viewPatient" action="">
            <h2 class="section__heading">Patient Smith</h2>
            <div class="form__inline">
              <div class="form__content"><span class="form__text">19</span><label class="form__label form__label--visible">Age</label></div>
              <div class="form__content"><span class="form__text">12/14/2020</span><label class="form__label form__label--visible">Date of birth</label></div>
              <div class="form__content"><span class="form__text">Female</span><label class="form__label form__label--visible">Gender</label></div>
            </div>
            <div class="form__content"><span class="form__text">patient@gmail.com</span><label class="form__label form__label--visible">Email</label></div>
            <div class="form__content"><span class="form__text">COC pills, condom</span><label class="form__label form__label--visible">Family planning type</label></div>
            <div class="accordion">
              <ul class="accordion__list">
                <li class="accordion__item">
                  <input class="accordion__trigger" id="trigger1" type="radio" name="rd" />
                  <label class="accordion__title" for="trigger1">
                    Medical history
                    <div class="accordion__arrow"></div>
                  </label>
                  <div class="accordion__content">
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Nanganak ka ba sa nakaraang 6 weeks?</label><span class="form__text form__text--answer">Yes</span></div>
                    <div class="form__inline">
                      <label class="form__label form__label--visible form__label--question">Kasalukuyang ka bang may pinapasuso (breastfreeding)?</label><span class="form__text form__text--answer">COC pills / condom</span>
                    </div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Gumagamit ka ba ng sigarilyo?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Mayroon ka bang altapresyo (high blood pressure)?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Ikaw ba ay may diabetes?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline">
                      <label class="form__label form__label--visible form__label--question">
                        May miyembro ba ng iyong pamilya na nagkaron ng sumusunod na kapansanan:
                        <ul class="list">
                          <li class="list__item">deep vein thrombosis (DVT)</li>
                          <li class="list__item">pulmonary edema (PE)</li>
                          <li class="list__item">blood clotting disorder</li>
                        </ul>
                      </label>
                      <span class="form__text form__text--answer">n/a</span>
                    </div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Sumailalim o sasailalim ka ba sa isang major surgery?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">May allergy ka ba sa kahit anong uri ng gamot?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">May allergy ka ba sa kahit anong uri ng gamot?</label><span class="form__text form__text--answer">n/a</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">May allergy ka ba sa kahit anong uri ng gamot?</label><span class="form__text form__text--answer">n/a</span></div>
                  </div>
                </li>
                <li class="accordion__item">
                  <input class="accordion__trigger" id="trigger2" type="radio" name="rd" />
                  <label class="accordion__title" for="trigger2">
                    Personal history
                    <div class="accordion__arrow"></div>
                  </label>
                  <div class="accordion__content">
                    <ul class="form__group">
                      <li class="form__group-item">
                        <h2 class="section__heading">Personal History</h2>
                        <div class="form__content"><span class="form__text">Single</span><label class="form__label form__label--visible">Civil status</label></div>
                        <div class="form__content"><span class="form__text">Roman Catholic</span><label class="form__label form__label--visible">Religion</label></div>
                        <div class="form__content"><span class="form__text">n/a</span><label class="form__label form__label--visible">Occupation</label></div>
                        <div class="form__content"><span class="form__text">n/a</span><label class="form__label form__label--visible">Monthly income</label></div>
                        <h2 class="section__heading">Spouse details</h2>
                        <div class="form__content"><span class="form__text">n/a</span><label class="form__label form__label--visible">Name</label></div>
                        <div class="form__content"><span class="form__text">n/a</span><label class="form__label form__label--visible">Date of birth</label></div>
                        <div class="form__content"><span class="form__text">n/a</span><label class="form__label form__label--visible">Occupation</label></div>
                      </li>
                      <li class="form__group-item">
                        <h2 class="section__heading">Address</h2>
                        <div class="form__content"><span class="form__text">38 Lilac St.</span><label class="form__label form__label--visible">Street address</label></div>
                        <div class="form__content"><span class="form__text">BF Homes</span><label class="form__label form__label--visible">Barangay</label></div>
                        <div class="form__content"><span class="form__text">Caloocan City</span><label class="form__label form__label--visible">City</label></div>
                        <div class="form__content"><span class="form__text">Metro Manila</span><label class="form__label form__label--visible">Province</label></div>
                        <h2 class="section__heading">Children</h2>
                        <div class="form__content"><span class="form__text">3</span><label class="form__label form__label--visible">No. of living children</label></div>
                        <div class="form__content"><span class="form__text">Yes</span><label class="form__label form__label--visible">Do you plan to have more children?</label></div>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="accordion__item">
                  <input class="accordion__trigger" id="trigger3" type="radio" name="rd" />
                  <label class="accordion__title" for="trigger3">
                    Family planning type
                    <div class="accordion__arrow"></div>
                  </label>
                  <div class="accordion__content">
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Gumagamit ng FP?</label><span class="form__text form__text--answer">Yes</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Kasalukuyang ginagamit na FP</label><span class="form__text form__text--answer">COC pills / condom</span></div>
                    <div class="form__inline"><label class="form__label form__label--visible form__label--question">Dahilan ng interes o paggamit ng FP</label><span class="form__text form__text--answer">Child spacing, limiting</span></div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="form__button form__button--start"><button class="button button--transparent button--noMargin">Delete account</button></div>
          </form>
        </div>
      </div>

</div>
@endsection
