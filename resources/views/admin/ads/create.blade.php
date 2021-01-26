@extends('layouts.admin.dashboard')

@section('title', 'Ad Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
  <div class="section__top">
    <h1 class="section__title">Create Ad</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('ads.index')}}">Ad Management</a><a class="breadcrumbs__link">Create Ad</a><a class="breadcrumbs__link"></a></div>
  </div>
  <div class="section__container">
    <form class="form" id="js-provider-form" method="POST" action="{{ route('ads.post') }}">
    @csrf  
    <ul class="form__group">
        <li class="form__group-item">
          <h2 class="section__heading">Content</h2>
          <div class="form__content"><input name="company_name" class="form__input" type="text" placeholder="Company name" /><label class="form__label">Company name</label></div>
          <div class="form__content"><input name="title" class="form__input" type="text" placeholder="Title" /><label class="form__label">Title</label></div>
          <div class="form__content"><input name="ad_link" class="form__input" type="text" placeholder="Ad link" /><label class="form__label">Ad link</label></div>
          <div class="form__content"><input name="start_date" class="form__input" type="date" placeholder="Start date" /><label class="form__label">Start date</label></div>
          <div class="form__content"><input name="end_date" class="form__input" type="date" placeholder="End date" /><label class="form__label">End date</label></div>
        </li>
        <li class="form__group-item">
          <h2 class="section__heading">Image</h2>
          <div class="form__content">
            <input type="hidden" name="ads-image-location" id="ads-image-location">
            <div class="dz-default dz-message dropzoneDragArea gallery" id="dropzoneDragArea">
                <div class="gallery__icon"><img class="gallery__image gallery__image--upload" src="{{URL::asset('img/icon-upload.png')}}" alt="Upload icon" /></div>
                <span class="gallery__text gallery__text--gray">Upload image maximum 2 mb,<br>320x50px</span><span class="gallery__text">Select file</span>
            </div>
            <ul class="gallery__list dropzone-previews">
            <li class="gallery__item dz-preview"><img data-dz-thumbnail class="gallery__image">
                <a href="" class="button button--close" aria-hidden="true">&times;</a>
                </li>
            </ul>
          </div>
        </li>
      </ul>
      <div class="form__button form__button--end"><input class="button js-trigger" type="button" value="Submit" /></div>
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
    </form>
  </div>
</div>

@endsection
