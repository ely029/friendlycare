@extends('layouts.admin.dashboard')

@section('title', 'Survey')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar');
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Create survey</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="survey.html">Survey</a><a class="breadcrumbs__link">Create survey</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" method="POST" action="{{ route('survey.post')}}">
            @csrf
            <ul class="form__group form__group--editMethod">
              <li class="form__group-item">
                <h2 class="section__heading">Date</h2>
                <div class="form__content"><input class="form__input" name="date_from" type="date" placeholder="Start date*" required /><label class="form__label">Start date*</label></div>
                <div class="form__content"><input class="form__input" name="date_to" type="date" placeholder="End date*" required /><label class="form__label">End date*</label></div>
                <div class="form__content"><input class="form__input" name="time" type="time" placeholder="Time*" required /><label class="form__label">Time*</label></div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Content</h2>
                <div class="form__content"><input class="form__input" type="text" name="title" placeholder="Title*" required /><label class="form__label">Title*</label></div>
                <div class="form__content"><input class="form__input" name="link" type="text" placeholder="Google form link*" required /><label class="form__label">Google form link*</label></div>
                <div class="form__content"><textarea class="form__input form__input--message form__input--message__notification" name="message" placeholder="Message*" required></textarea><label class="form__label">Message*</label></div>
              </li>
            </ul>
            <div class="form__button form__button--end"><button class="button js-trigger" type="submit">Submit</button></div>
          </form>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Success!</h2>
                <p class="modal__text">Your message will be sent on (start-date), (time).</p>
                <div class="modal__button modal__button--center"><button class="button button--medium" type="button">Confirm</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection