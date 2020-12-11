@extends('layouts.admin.dashboard')

@section('title', 'Survey')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar');
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Survey 10</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="survey.html">Survey</a><a class="breadcrumbs__link">Survey 10</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form">
            <ul class="form__group form__group--three">
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">10/24/1999</span><label class="form__label form__label--visible">Start date</label></div>
              </li>
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">10/24/1999</span><label class="form__label form__label--visible">End date</label></div>
              </li>
              <li class="form__group-item">
                <div class="form__content"><span class="form__text">12:00PM</span><label class="form__label form__label--visible">Time</label></div>
              </li>
            </ul>
            <div class="form__content"><a class="form__link" href="">http://www.sample.com/</a><label class="form__label form__label--visible">Google form link</label></div>
            <div class="form__content">
              <span class="form__text">Cras eget nulla nec erat euismod faucibus ac finibus ante. Etiam enim neque, blandit at gravida quis, tempus at est. In venenatis orci ipsum, id</span>
              <label class="form__label form__label--visible">Message</label>
            </div>
            <div class="form__button form__button--start"><a class="button" href="edit-survey.html">Edit survey</a><button class="button button--transparent js-trigger" type="button">Delete survey</button></div>
          </form>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Delete survey?</h2>
                <p class="modal__text">Surveys that have been sent will not be unsent, but the link will be deactivated. Are you sure you want to delete?</p>
                <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><button class="button button--medium button--medium__delete" type="button">Delete survey</button></div>
              </div>
            </div>
          </div>
        </div>
            </div>
@endsection