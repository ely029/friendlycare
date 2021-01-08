@extends('layouts.admin.dashboard')

@section('title', 'Patient Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
@foreach($details as $detail)
<div class="section__top">
          <h1 class="section__title">{{ $detail->name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="patient-management.html">Patient Management</a><a class="breadcrumbs__link" >Patient Smith</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--viewPatient" action="">
            <h2 class="section__heading">{{ $detail->name }}</h2>
            <div class="form__inline">
              <div class="form__content"><span class="form__text">{{ $detail->age}}</span><label class="form__label form__label--visible">Age</label></div>
              <div class="form__content"><span class="form__text">{{ $detail->birth_date }}</span><label class="form__label form__label--visible">Date of birth</label></div>
              <div class="form__content"><span class="form__text">{{ $detail->gender }}</span><label class="form__label form__label--visible">Gender</label></div>
            </div>
            <div class="form__content"><span class="form__text">{{ $detail->email }}</span><label class="form__label form__label--visible">Email</label></div>
            <div class="form__content">
            @foreach($fpm as $fpms)
            <span class="form__text">{{ $fpms->name }}</span>
            @endforeach
            <label class="form__label form__label--visible">Family planning type</label>
          </div>
            <div class="accordion">
              <ul class="accordion__list">
                <li class="accordion__item">
                  <input class="accordion__trigger" id="trigger1" type="radio" name="rd" />
                  <label class="accordion__title" for="trigger1">
                    Medical history
                    <div class="accordion__arrow"></div>
                  </label>
                  <div class="accordion__content">
                    @foreach ($medical_history as $medical_histories)
                    @if ($medical_histories->yes == 1)
                      @if (isset($question[$medical_histories->question_no]))
                      <div class="form__inline"><label class="form__label form__label--visible form__label--question">{{ $question[$medical_histories->question_no]['question']}}</label><span class="form__text form__text--answer">Yes</span></div>
                      @endif
                    @else
                    @if (isset($question[$medical_histories->question_no]))
                      <div class="form__inline"><label class="form__label form__label--visible form__label--question">{{ $question[$medical_histories->question_no]['question']}}</label><span class="form__text form__text--answer">No</span></div>
                      @endif
                    @endif
                    @endforeach
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
                        @foreach($personal_history as $personal_histories)
                        <div class="form__content"><span class="form__text">{{ $personal_histories->civil_status }}</span><label class="form__label form__label--visible">Civil status</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->religion }}</span><label class="form__label form__label--visible">Religion</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->occupation }}</span><label class="form__label form__label--visible">Occupation</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->monthly_income_1 }}</span><label class="form__label form__label--visible">Monthly income</label></div>
                        @endforeach
                        @foreach ($spouse as $spouses)
                        <h2 class="section__heading">Spouse details</h2>
                        <div class="form__content"><span class="form__text">{{ $spouses->spouse_first_name}} {{ $spouses->spouse_last_name}}</span><label class="form__label form__label--visible">Name</label></div>
                        <div class="form__content"><span class="form__text">{{ $spouses->spouse_birth_date ?? 'n/a' }}</span><label class="form__label form__label--visible">Date of birth</label></div>
                        <div class="form__content"><span class="form__text">{{ $spouses->occupation ?? 'n/a' }}</span><label class="form__label form__label--visible">Occupation</label></div>
                        @endforeach
                      </li>
                      <li class="form__group-item">
                        <h2 class="section__heading">Address</h2>
                        @foreach($personal_history as $personal_histories)
                        <div class="form__content"><span class="form__text">{{ $personal_histories->street_address}}</span><label class="form__label form__label--visible">Street address</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->barangay}}</span><label class="form__label form__label--visible">Barangay</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->city}}</span><label class="form__label form__label--visible">City</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->province }}</span><label class="form__label form__label--visible">Province</label></div>
                        <h2 class="section__heading">Children</h2>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->no_of_living_children }}</span><label class="form__label form__label--visible">No. of living children</label></div>
                        <div class="form__content"><span class="form__text">{{ $personal_histories->do_you_have_plan_children }}</span><label class="form__label form__label--visible">Do you plan to have more children?</label></div>
                        @endforeach
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
              @if(Auth::user()->role_id = 1)
              @foreach($details as $detail)
            <div class="form__button form__button--start"><a href="{{ route('patientManagement.delete', $detail->id)}}"class="button button--transparent button--noMargin">Delete account</a></div>
              @endforeach
            @endif
          </form>
        </div>
@endforeach
      </div>
</div>
@endsection
