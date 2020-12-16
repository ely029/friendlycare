@extends('layouts.admin.dashboard')

@section('title', 'Basic Pages')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Chatbot Management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="provider-management.html">Chatbot Management</a><a class="breadcrumbs__link">Create Fieldset</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="">
            <div class="form__container">
              <h2 class="section__heading">Chatbot Input</h2>
              <div class="form__content"><input class="form__input" type="text" required /><label class="form__label">Fieldset title*</label></div>
              <div class="form__content"><textarea class="form__input form__input--message" rows="8" required></textarea><label class="form__label">Chatbot input*</label></div>
              <h2 class="section__heading">Response options</h2>
              <div class="form__content"><input class="form__input" type="text" required /><label class="form__label">Response prompt*</label></div>
              <div class="form__content">
                <select class="form__input form__input--select" required>
                  <option value="">Select Field set</option>
                  @foreach ($details as $detail)
                  <option value="{{$detail->id}}">{{ $detail->field_set_title}}</option>
                  @endforeach
                </select>
                <label class="form__label">Link to fieldset*</label>
              </div>
              <div class="form__button form__button--end">
                <button class="button button--medium js-delete-response js-trigger" type="button">Delete response</button><button class="button button--medium js-add-response" type="button">Add response</button>
              </div>
            </div>
            <div class="form__button form__button--end"><button class="button js-trigger" type="button">Save changes</button></div>
          </form>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Delete response?</h2>
                <p class="modal__text">Are you sure you want to delete this response?</p>
                <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium button--medium__delete" type="button">Delete response</button></div>
              </div>
            </div>
          </div>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Save changes?</h2>
                <p class="modal__text">All changes will update the version of the app. Are you sure you want to Save?</p>
                <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium" type="button">Save changes</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @endsection
