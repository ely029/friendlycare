@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Methods')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($details as $detail)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{ $detail->name }} / {{ $detail->short_name }}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{  route('familyPlanningMethod.index')}}">Family planning methods</a><a class="breadcrumbs__link">{{ $detail->name }} / {{ $detail->short_name }}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="">
            <ul class="form__group form__group--uploadViewMethod">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image form__image--method" src="{{ $detail->icon_url}}" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse"><label class="form__label form__label--blue">{{$detail->name}}</label></div>
              </li>
            </ul>
            <div class="form__content form__content--reverse form__content--gallery">
              <h2 class="section__heading">Gallery</h2>
              <ul class="form__gallery form__gallery--method">
                @foreach ($serviceGalleries as $serviceGallery)
                <li class="form__gallery-item"><img class="form__gallery-image" src="{{ $serviceGallery->file_url }}" alt="Gallery image" /></li>
                @endforeach
              </ul>
              <iframe class="form__video" src="{{ $detail->video_link}}" frameborder="0" allowfullscreen></iframe>
            </div>
            <ul class="form__group form__group--viewMethod">
              <li class="form__group-item">
                <h2 class="section__heading">Effectiveness</h2>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Sa tamang paggamit</label><span class="form__text">{{ $detail->percent_effective }}</span></div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Tipikal na bisa</label><span class="form__text">{{ $detail->typical_validity }}</span></div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Description</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (English)</label>
                  <span class="form__text">{{ $detail->description_english }}</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (Filipino)</label>
                  <span class="form__text">{{ $detail->description_filipino }}</span>
                </div>
                <h2 class="section__heading">How it works</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (English)</label>
                  <span class="form__text">{{ $detail->how_it_works_english }}</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (Filipino)</label>
                  <span class="form__text">{{ $detail->how_it_works_filipino }}</span>
                </div>
                <h2 class="section__heading">Possible side effects</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (English)</label>
                  <span class="form__text">{{ $detail->side_effect_english }} </span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (Filipino)</label>
                  <span class="form__text">{{ $detail->side_effect_filipino }}</span>
                </div>
                <h2 class="section__heading">Additional notes</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (English)</label>
                  <span class="form__text">
                  {{ $detail->additional_note_english }}
                  </span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (Filipino)</label>
                  <span class="form__text">
                  {{ $detail->additional_note_filipino }}
                  </span>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--start">
            <a class="button" href="{{ route('familyPlanningMethod.edit',$detail->id)}}">Edit method</a>
            <button class="button button--transparent js-trigger" type="button">Delete method</button></div>
            
            <div class="modal js-modal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Delete method?</h2>
                  <p class="modal__text">You are about to delete this method. Proceed?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><a href="{{ route('familyPlanningMethod.delete', $detail->id)}}" class="button button--medium button--medium__delete" role="button">Delete Method</a></div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
@endforeach
@endsection
