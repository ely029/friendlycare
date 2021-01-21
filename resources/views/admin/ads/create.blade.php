@extends('layouts.admin.dashboard')

@section('title', 'Chatbot Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
  <div class="section__top">
    <h1 class="section__title">Create Ad</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="ads.html">Ad Management</a><a class="breadcrumbs__link">Create Ad</a><a class="breadcrumbs__link"></a></div>
  </div>
  <div class="section__container">
    <form class="form" id="js-provider-form">
      <ul class="form__group">
        <li class="form__group-item">
          <h2 class="section__heading">Content</h2>
          <div class="form__content"><input class="form__input" type="text" placeholder="Company name" /><label class="form__label">Company name</label></div>
          <div class="form__content"><input class="form__input" type="text" placeholder="Title" /><label class="form__label">Title</label></div>
          <div class="form__content"><input class="form__input" type="text" placeholder="Ad link" /><label class="form__label">Ad link</label></div>
          <div class="form__content"><input class="form__input" type="date" placeholder="Start date" /><label class="form__label">Start date</label></div>
          <div class="form__content"><input class="form__input" type="date" placeholder="End date" /><label class="form__label">End date</label></div>
        </li>
        <li class="form__group-item">
          <h2 class="section__heading">Image</h2>
          <div class="form__content">
            <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea"><span>Upload File</span></div>
            <div class="dropzone-previews"></div>
          </div>
        </li>
      </ul>
      <div class="form__button form__button--end"><input class="button js-trigger" type="button" value="Submit" /></div>
    </form>
    <div class="modal js-modal">
      <div class="modal__background js-modal-background"></div>
      <div class="modal__container">
        <div class="modal__box">
          <h2 class="modal__title">Success!</h2>
          <p class="modal__text">Your ad will be displayed on Start date.</p>
          <div class="modal__button modal__button--center"><input class="button button--medium" type="submit" value="Confirm" /></div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
