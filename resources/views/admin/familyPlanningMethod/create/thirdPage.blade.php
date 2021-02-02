@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Methods')
@section('description', 'Dashboard')

@section('content')

<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Create method</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{  route('familyPlanningMethod.index')}}">Family planning methods</a><a class="breadcrumbs__link" >Create method</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--method" method="POST" action="{{ route('familyPlanningMethod.createThree') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" id="id" value="{{ session()->get('id') }}"/>
            <div class="form__tab">
              <ul class="form__group">
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic gallery</h2>
                  <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea">
                    <div class="gallery">
                      <div class="gallery__icon"><img class="gallery__image gallery__image--upload" src="{{URL::asset('img/icon-upload.png')}}" alt="Upload icon" /></div>
                      <span class="gallery__text gallery__text--gray">Upload image maximum 2 mb,<br>maximum 5 images</span><span class="gallery__text">Select file</span>
                    </div>
                  </div>
                  <ul class="gallery__list" id="gallery-preview">
                    <li class="gallery__item dz-preview dz-file-preview" id="gallery-container"><img class="gallery__image" data-dz-thumbnail>
                      <button class="button button--close" aria-hidden="true" data-dz-remove>&times;</button>
                  </li>
                  </ul>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Video</h2>
                  <div class="form__content form__content--full"><input name="video_link" class="form__input form__input--search" type="text" placeholder="Youtube link*" required /><label class="form__label">Youtube link*</label></div>
                  <!-- <iframe class="form__video form__video--edit" src="https://www.youtube.com/embed/c6DC2FEzVjM" frameborder="0" allowfullscreen></iframe> -->
                </li>
              </ul>
            </div>
            <div class="form__button form__button--steps">
              <button class="button button--back" id="back-fpm-page"  type="button">Back</button>
              <div class="steps">
                <ul class="steps__list">
                  <li class="steps__item "></li>
                  <li class="steps__item"></li>
                  <li class="steps__item active"></li>
                </ul>
              </div>
              <button class="button button--next"  type="submit">Next</button>
            </div>
            </form>
        </div>
      </div>
@endsection
