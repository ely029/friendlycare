@extends('layouts.admin.dashboard')

@section('title', 'User Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($content as $contents)
@if($contents->id != 3)
<!-- for about us -->
<form class="form--full" method="POST" action="{{ route('basicPages.storeEdit')}}">
    @csrf
    <input type="hidden" name="id" value="{{ $contents->id }}">
    <input type="hidden" name="content_name[]" value="{{ $contents->content_name }}">
<div class="section">
<div class="section__top">
    <h1 class="section__title">{{ $contents->content_name}}</h1>
    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('basicPages')}}">Basic pages</a>
        <a class="breadcrumbs__link" href="{{ route('basicPages.informationPage',$contents->id) }}">{{ $contents->content_name}}</a>
        <a class="breadcrumbs__link">Edit</a></div>
    </div>
<div class="section__container">
    <h2 class="section__heading">{{ $contents->content_name}}</h2>
    <div class="form">
        <div class="form__content form__content--full">
            <textarea name="content" class="form__input form__input--message js-editor-content">{{ $contents->content }}</textarea>
        </div>
    
    <div class="form__button form__button--end"><input type="submit" value="Save changes" class="button "></div>
    </div>
</div>
</div>
</form>
@else
<!-- for consent form -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">Consent form</h1>
    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('basicPages')}}">Basic pages</a>
        <a class="breadcrumbs__link" href="">Consent form</a>
        <a class="breadcrumbs__link">Edit</a>
    </div>
</div>
<form method="POST" action="{{ route('basicPages.storeEdit')}}">
@csrf
<input type="hidden" name="id" value="{{ $contents->id }}">
<div class="section__container">
<div class="form">
<div class="form__content form__content--full"><input class="form__input" type="text" value="Consent Form"  /><label class="form__label form__label--visible" for="">Title</label></div>
@foreach($contentss as $contentsss)
<input type="hidden" value="{{ $contentsss->id }}" name="content_id[]">
    <div id="js-consent-form1">
        <div class="form__container">
        <div class="form__content form__content--full"><input class="form__input" type="text" name="content_name[]" value="{{ $contentsss->title}}"  /><label class="form__label form__label--visible" for="">Section title</label></div>
        <div class="form__content form__content--full">
            <textarea class="form__input form__input--message js-editor-content" name="content[]">{{ $contentsss->content }}</textarea>
            <label class="form__label form__label--visible" for="">Content</label>
        </div>
        <div class="form__button form__button--end">
            <a class="button button--medium js-delete-section js-trigger" href="{{ route('basicPages.deleteBasicSection',$contentsss->id)}}"type="button">Delete section</a>
        </div>
        </div>
    </div>
    @endforeach
    <div id="js-consent-form">
        <div class="form__container">
        <input type="hidden" value="0" name="content_id[]">
        <div class="form__content form__content--full"><input class="form__input" type="text" name="content_name[]" value=""  /><label class="form__label form__label--visible" for="">Section title</label></div>
        <div class="form__content form__content--full">
            <textarea class="form__input form__input--message js-editor-content" name="content[]"></textarea>
            <label class="form__label form__label--visible" for="">Content</label>
        </div>
        <div class="form__button form__button--end">
            <button class="button button--medium js-add-section1" type="button">Add section</button>
        </div>
        </div>
    </div>
    <div id="js-consent-form2">
        <div class="form__container">
        <input type="hidden" value="0" name="content_id[]">
        <div class="form__content form__content--full"><input class="form__input" type="text" name="content_name[]" value=""  /><label class="form__label form__label--visible" for="">Section title</label></div>
        <div class="form__content form__content--full">
            <textarea class="form__input form__input--message js-editor-content" name="content[]"></textarea>
            <label class="form__label form__label--visible" for="">Content</label>
        </div>
        <div class="form__button form__button--end">
        <a class="button button--medium js-delete-section js-trigger" type="button">Delete section</a>
            <button class="button button--medium js-add-section" type="button">Add section</button>
        </div>
        </div>
    </div>
    <div class="form__button form__button--end"><input class="button js-trigger" type="submit" value="Save Changes"></div>
    </div>

    <!-- modal for js-consent-form1 -->
    <div class="modal js-modal">
    <div class="modal__background js-modal-background"></div>
    <div class="modal__container">
        <div class="modal__box">
        <h2 class="modal__title">Delete section?</h2>
        <p class="modal__text">Are you sure you want to delete this section?</p>
        <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium button--medium__delete" type="button">Delete section</button></div>
        </div>
    </div>
    </div>

    <!-- modal for js-consent-form2 -->
    <div class="modal js-modal">
    <div class="modal__background js-modal-background"></div>
    <div class="modal__container">
        <div class="modal__box">
        <h2 class="modal__title">Delete section?</h2>
        <p class="modal__text">Are you sure you want to delete this section?</p>
        <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium button--medium__delete" type="button">Delete section</button></div>
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
</form>
</div>
@endif
@endforeach
@endsection
