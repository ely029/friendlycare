@extends('layouts.admin.dashboard')

@section('title', 'Provider Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
@foreach($clinic_name as $clinic_names)
<div class="section__top">
          <h1 class="section__title">{{ $clinic_names->clinic_name}}</h1>
          <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider management</a>
            <a class="breadcrumbs__link" href="">{{$clinic_names->clinic_name}}</a>
            <a class="breadcrumbs__link">Reviews</a>
          </div>
        </div>
@endforeach
        <div class="section__container">
          <form class="form form--viewProvider" id="js-provider-form" action="">
            <ul class="form__group form__group--viewProvider">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image" src="{{URL::asset('img/placeholder.jpg')}}" alt="Image placeholder" /></div>
              </li>
              @foreach($clinic_name as $clinic_names)
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">{{ $clinic_names->clinic_name}}</label>
                  <span class="form__text form__text--group">
                    <div id="rateYo"></div>
                    <span class="form__text">({{$patientCount}})</span><a class="form__link form__link--gray" href="">View reviews?</a>
                  </span>
                  <span class="form__text">{{$clinic_names->email}}</span><span class="form__text">09857754852</span>
                </div>
              </li>
              @endforeach
            </ul>
          </form>
          <form class="form" action="">
            <h2 class="section__heading">User reviews</h2>
            @foreach($details as $detail)
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">John Smith</label>
              <div id="rateYo-{{$detail->id}}"></div>
              <input type="hidden" id="review-{{$detail->id}}" value="{{$detail->ratings}}">
            <span class="form__text">{{ $detail->review}}</span>
            </div>
            @endforeach
          </form>
        </div>
      </div>
@endsection