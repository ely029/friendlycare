@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
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
          <form class="form form--method" id="js-provider-form" method="POST" action="{{ route('familyPlanningMethod.createThree') }}" enctype="multipart/form-data">
          @csrf
            <div class="form__tab">
              <ul class="form__group">
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic gallery</h2>
                  <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea"><span>Upload File</span></div>
                  <div class="dropzone-previews"></div>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Video</h2>
                  <div class="form__content form__content--full"><input name="video_link" class="form__input form__input--search" type="text" placeholder="Youtube link*" required /><label class="form__label">Youtube link*</label></div>
                  <iframe class="form__video form__video--edit" src="https://www.youtube.com/embed/c6DC2FEzVjM" frameborder="0" allowfullscreen></iframe>
                </li>
              </ul>
            </div>
            <div class="form__button form__button--steps">
              <button class="button"  type="button">Back</button>
              <div class="steps">
                <ul class="steps__list">
                  <li class="steps__item active"></li>
                  <li class="steps__item"></li>
                  <li class="steps__item"></li>
                </ul>
              </div>
              <button class="button"  type="submit">Next</button>
            </div>
            </form>
        </div>
      </div>
@endsection
