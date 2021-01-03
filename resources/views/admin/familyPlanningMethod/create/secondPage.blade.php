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
          <form class="form form--method" id="js-provider-form" method="POST" action=" {{ route('familyPlanningMethod.createTwo')}}">
          @csrf
          <div class="row">
                <div class="col-md-12">
                @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
  @endif
<div class="form__tab">
              <h2 class="section__heading">Content</h2>
              <ul class="tabs__list tabs__list--method">
                <li class="tabs__subitem">
                  <input class="tabs__trigger" id="description" type="radio" name="rd" checked />
                  <div class="tabs__title"><label class="tabs__label" for="description">Description</label></div>
                  <div class="tabs__subdetails">
                    <h2 class="section__heading">Description</h2>
                    <div class="form__inline">
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Description (English)*" required name="description_english">{{ old('description_english') }}</textarea>
                        <label class="form__label">Description (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Description (Filipino)*" required name="description_tagalog">{{ old('description_tagalog') }}</textarea>
                        <label class="form__label">Description (Filipino)</label>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="tabs__subitem">
                  <input class="tabs__trigger" id="how" type="radio" name="rd" />
                  <div class="tabs__title"><label class="tabs__label" for="how">How it works</label></div>
                  <div class="tabs__subdetails">
                    <h2 class="section__heading">How it works</h2>
                    <div class="form__inline">
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="How it works (English)*" required name="how_it_works_english"> {{ old('how_it_works_english') }}</textarea>
                        <label class="form__label">How it works (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="How it works (Filipino)*" required name="how_it_works_tagalog">{{ old('how_it_works_tagalog') }}</textarea>
                        <label class="form__label">How it works (Filipino)</label>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="tabs__subitem">
                  <input class="tabs__trigger" id="side-effects" type="radio" name="rd" />
                  <div class="tabs__title"><label class="tabs__label" for="side-effects">Possible side effects</label></div>
                  <div class="tabs__subdetails">
                    <h2 class="section__heading">Possible side effects</h2>
                    <div class="form__inline">
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Possible side effects (English)*" required name="side_effect_english">{{old('side_effect_english')}}</textarea>
                        <label class="form__label">Possible side effects (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Possible side effects (Filipino)*" required name="side_effect_tagalog">{{ old('side_effect_tagalog')}}</textarea>
                        <label class="form__label">Possible side effects (Filipino)</label>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="tabs__subitem">
                  <input class="tabs__trigger" id="additional-notes" type="radio" name="rd" />
                  <div class="tabs__title"><label class="tabs__label" for="additional-notes">Additional notes</label></div>
                  <div class="tabs__subdetails">
                    <h2 class="section__heading">Additional notes</h2>
                    <div class="form__inline">
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Additional notes (English)*" required name="additional_note_english">{{ old('additional_note_english') }}</textarea>
                        <label class="form__label">Additional notes (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Additional notes (Filipino)*" required name="additional_note_tagalog">{{ old('additional_note_tagalog') }}</textarea>
                        <label class="form__label">Additional notes (Filipino)</label>
                      </div>
                    </div>
                  </div>
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
<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item active">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
            <div class="row">
                <div class="col-12 py-4">
                    <h2>Create Service</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Content</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Description</h4>
                </div>
            </div>
            <form method="POST" action=" {{ route('familyPlanningMethod.createTwo')}}">
             @csrf
            <div class="row">
                <div class="col-md-6">
                    <span>Description (English)</span>
                    <textarea name="description_english">{{ old('description_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Description (Tagalog)</span>
                    <textarea name="description_tagalog">{{ old('description_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>How It Works</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>How It works (English)</span>
                    <textarea name="how_it_works_english">{{ old('how_it_works_english')}}</textarea>
                </div>
                <div class="col-md-6">
                    <span>How It works (Tagalog)</span>
                    <textarea name="how_it_works_tagalog">{{ old('how_it_works_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Possible Side Effect</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>Possible Side Effect (English)</span>
                    <textarea name="side_effect_english">{{ old('side_effect_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Possible Side Effect (Tagalog)</span>
                    <textarea name="side_effect_tagalog">{{ old('side_effect_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Additional Effect</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>Additional Note (English)</span>
                    <textarea name="additional_note_english">{{ old('additional_note_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Additional Note (Tagalog)</span>
                    <textarea name="additional_note_tagalog">{{ old('additional_note_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
@endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <input type="submit" value="Next" class="btn btn-success"/>
                </div>
            </div>
            </form>            
        </main>
    </div>
</div> -->
@endsection
