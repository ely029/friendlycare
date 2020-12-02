@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<!-- for about us -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">About us</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="basic-pages.php">Basic pages</a><a class="breadcrumbs__link" href="about.php">About us</a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <h2 class="section__heading">About us</h2>
    <div class="form">
    <span class="form__text">
        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
        kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
        voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
        eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
    </span>
    <div class="form__button form__button--start"><a class="button" href="edit-about.php">Edit content </a></div>
    </div>
</div>
</div>

<!-- for consent form -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">Consent form</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="basic-pages.php">Basic pages</a><a class="breadcrumbs__link" href="consent-form.php">Consent form</a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    <h2 class="section__heading">Consent form</h2>
    <div class="form">
    <div class="accordion">
        <ul class="accordion__list">
        <li class="accordion__item">
            <input class="accordion__trigger" id="trigger1" type="radio" name="rd" />
            <label class="accordion__title" for="trigger1">
            Section 1
            <div class="accordion__arrow"></div>
            </label>
            <p class="accordion__content">
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
            clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed
            diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. <br />
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
            clita kasd
            </p>
        </li>
        <li class="accordion__item">
            <input class="accordion__trigger" id="trigger2" type="radio" name="rd" />
            <label class="accordion__title" for="trigger2">
            Section 2
            <div class="accordion__arrow"></div>
            </label>
            <p class="accordion__content">
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
            clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed
            diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. <br />
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
            clita kasd
            </p>
        </li>
        </ul>
    </div>
    <div class="form__button form__button--start"><a class="button" href="edit-consent-form.php">Edit content </a></div>
    </div>
</div>
</div>

<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item active">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
        @foreach ($content as $contentss)
        @if($contentss->id = '3')
        <div class="row">
            <div class="col-md-12">
                {{$contentss->content_name}}
            </div>
        </div>
                @foreach($contents as $content)
                <small>Title</small>
                <div class="row">
                      <div class="col-md-12">
                          {{ $content->section_title}}
                      </div>
                </div>
                <small>Content</small>
                <div class="row">
                      <div class="col-md-12">
                          {{ $content->content}}
                      </div>
                </div>
                @endforeach
        @else
        <div class="row">
                <div class="col-12 py-4">
                    <h2>{{ $contents->content_name }}</h2>
                    <span>{{ $contents->content_name }}</span>
                </div>
            </div>
           <div class="row">
                <div class="col-md-12">
                <h4> {{ $contents->content_name }}</h4>
                </div>
           </div>
           <div class="row">
                <div class="col-md-12">
                {{ $contents->content }}
                </div>
           </div>
        @endif
        
           <div class="row">
                <div class="col-md-12">
                    @if ($contentss->id == 4)
                    @else
                    <a href="{{ route('basicPages.editPage',$contentss->id)}}" class="btn btn-success">Edit content</a>
                    @endif
                </div>
           </div>
        </main>
    </div>
    @endforeach
</div> -->
@endsection
