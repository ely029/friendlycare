@extends('layouts.admin.dashboard')

@section('title', 'Ad Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach($data as $datas)
<div class="section">
  <div class="section__top">
    <h1 class="section__title">{{ $datas->title }}</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('ads.index')}}">Ad Management</a><a class="breadcrumbs__link">{{ $datas->title}}</a><a class="breadcrumbs__link"></a></div>
  </div>
  
  <div class="section__container">
    <form class="form form--ads">
      <div class="form__inline">
        <div class="form__content"><span class="form__text">{{ $datas->start_date}}</span><label class="form__label">Start date</label></div>
        <div class="form__content"><span class="form__text">{{ $datas->end_date }}</span><label class="form__label">End date</label></div>
      </div>
      <div class="form__content"><a class="form__link" href="">{{ $datas->ad_link }}</a><label class="form__label">Ad link</label></div>
      <div class="form__content">
        <div class="form__wrapper form__wrapper--ads"><img class="form__image form__image--ads" src="{{ $datas->image_url}}" alt="" /></div>
      </div>
      <div class="form__inline">
        <div class="form__content"><span class="form__text">{{ $count_views }}</span><label class="form__label">Views</label></div>
        <div class="form__content"><span class="form__text">{{ $count_clicks }}</span><label class="form__label">Clicks</label></div>
      </div>
      <div class="form__button form__button--start"><input class="button button--transparent button--noMargin js-trigger" type="button" value="Delete ad" /></div>
      <div class="modal js-modal">
      <div class="modal__background js-modal-background"></div>
      <div class="modal__container">
        <div class="modal__box">
          <h2 class="modal__title">Delete ad?</h2>
          <p class="modal__text">Are you sure you want to delete?</p>
          <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><a class="button button--medium button--medium__delete" href="{{ route('ads.delete', $datas->id)}}">Delete ad</a></div>
        </div>
      </div>
    </div>
    </form>
  </div>
  @endforeach
</div>

@endsection
