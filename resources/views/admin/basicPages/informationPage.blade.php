@extends('layouts.admin.dashboard')

@section('title', 'Basic Pages')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($content as $contentss)

@if($contentss->id != 3)
<!-- for about us -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">{{ $contentss->content_name }}</h1>
    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('basicPages')}}">Basic pages</a>
        <a class="breadcrumbs__link">{{ $contentss->content_name }}</a>
        <a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <h2 class="section__heading">{{ $contentss->content_name }}</h2>
    <div class="form">
    <span class="form__text">
    {{ $contentss->content }}
    </span>
    @if ($contentss->id != 1)
    <div class="form__button form__button--start"><a class="button" href="{{ route('basicPages.editPage',$contentss->id)}}">Edit content </a></div>
    @else
    @endif
    </div>
</div>
</div>
@else
<!-- for consent form -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">{{ $contentss->content_name }}</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('basicPages')}}">Basic Pages</a><a class="breadcrumbs__link">{{ $contentss->content_name }}</a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <h2 class="section__heading">{{ $contentss->content_name }}</h2>
    <div class="form">
    <div class="accordion">
        <ul class="accordion__list">
        @foreach($contents as $content)
        <li class="accordion__item">
            <input class="accordion__trigger" id="trigger{{$content->id}}" type="radio" name="rd{{$content->id}}" />
            <label class="accordion__title" for="trigger1">
            {{ $content->section_title}}
            <div class="accordion__arrow"></div>
            </label>
            <p class="accordion__content">
            {{ $content->content}}
            </p>
        </li>
        @endforeach
        </ul>
    </div>
    <div class="form__button form__button--start"><a class="button" href="{{ route('basicPages.editPage',$contentss->id)}}">Edit content </a></div>
    </div>
</div>
</div>
@endif
@endforeach
@endsection
