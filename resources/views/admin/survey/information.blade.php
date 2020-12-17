@extends('layouts.admin.dashboard')

@section('title', 'Survey')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar');
</div>
@foreach($details as $detail)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{ $detail->title}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="survey.html">Survey</a><a class="breadcrumbs__link">{{ $detail->title}}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" method="POST" action="{{ route('survey.delete', $detail->id)}}">
            @csrf
            <ul class="form__group form__group--three">
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">{{ $detail->date_from }}</span><label class="form__label form__label--visible">Start date</label></div>
              </li>
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">{{ $detail->date_to }}</span><label class="form__label form__label--visible">End date</label></div>
              </li>
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">{{ $detail->time }}</span><label class="form__label form__label--visible">Time</label></div>
              </li>
            </ul>
            <div class="form__content"><a class="form__link" href="{{ $detail->link }}">{{ $detail->link }}</a><label class="form__label form__label--visible">Google form link</label></div>
            <div class="form__content">
              <span class="form__text">{{ $detail->message}}</span>
              <label class="form__label form__label--visible">Message</label>
            </div>
            <div class="form__button form__button--start"><a class="button" href="{{ route('survey.edit', $detail->id)}}">Edit survey</a><button class="button button--transparent js-trigger" type="button">Delete survey</button></div>
            <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Delete survey?</h2>
                <p class="modal__text">Surveys that have been sent will not be unsent, but the link will be deactivated. Are you sure you want to delete?</p>
                <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><button class="button button--medium button--medium__delete" type="submit">Delete survey</button></div>
              </div>
            </div>
          </div>
          </form>
        </div>
            </div>
@endforeach
@endsection