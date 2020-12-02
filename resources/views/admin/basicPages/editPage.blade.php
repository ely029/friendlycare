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
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="basic-pages.php">Basic pages</a><a class="breadcrumbs__link" href="about.php">About us</a><a class="breadcrumbs__link" href="edit-about.php">Edit</a></div>
</div>
<div class="section__container">
    <h2 class="section__heading">About us</h2>
    <div class="form">
    <div class="form__input form__input--message js-editor-content"></div>
    <div class="form__button form__button--end"><button class="button" type="button">Save changes</button></div>
    </div>
</div>
</div>


<!-- for consent form -->
<div class="section">
<div class="section__top">
    <h1 class="section__title">Consent form</h1>
    <div class="breadcrumbs">
    <a class="breadcrumbs__link" href="basic-pages.php">Basic pages</a><a class="breadcrumbs__link" href="consent-form.php">Consent form</a><a class="breadcrumbs__link" href="edit-consent-form.php">Edit</a>
    </div>
</div>
<div class="section__container">
    <div class="form">
    <div id="js-consent-form">
        <div class="form__container">
        <div class="form__content form__content--full"><input class="form__input" type="text" /><label class="form__label form__label--visible" for="">Title</label></div>
        <div class="form__content form__content--full"><input class="form__input" type="text" /><label class="form__label form__label--visible" for="">Section title</label></div>
        <div class="form__content form__content--full">
            <div class="form__input form__input--message js-editor-content"></div>
            <label class="form__label form__label--visible" for="">Content</label>
        </div>
        <div class="form__button form__button--end">
            <button class="button button--medium js-delete-section" type="button">Delete section</button><button class="button button--medium js-add-section" type="button">Add section</button>
        </div>
        </div>
    </div>
    <div class="form__button form__button--end"><button class="button js-trigger" type="button">Save changes</button></div>
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
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item ">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Basic Pages</h2>
                    <span>Basic Pages</span>
                </div>
            </div>
           @foreach ($content as $contents)

           @if($contents->id = 3)
           <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('basicPages.storeEdit')}}">
                        @csrf
                        <span>Title</span><br/>
                        <input type="text" name="content_name" value="{{ $contents->content_name}}"/>
                        <input type="hidden" name="id" value="{{ $contents->id }}">
                        <br/>
                        @foreach($contentss as $contentsss)
                        <div class="row">
                            <div class="col-md-12">
                                <small>Title</small>
                            <input type="text" name="title[]" value="{{ $contentsss->title}}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <small>Content</small>
                                <textarea name="content[]" style="width:500px;height:200px;">{{ $contentsss->content }}</textarea>
                            </div>
                        </div>
                        @endforeach
                        <div class="sections">
                        </div>
                        <br/>
                        <input type="submit" value="Save Changes" class="btn btn-success"/>
                        <input type="button"  class="btn btn-primary add-section" value="Add Section"/>
                    </form>
                </div>
           </div>
           @else
           <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('basicPages.storeEdit')}}">
                        @csrf
                        <input type="text" name="content_name" value="{{ $contents->content_name}}"/>
                        <input type="hidden" name="id" value="{{ $contents->id }}">
                        <textarea name="contents" width="250" height="250">{{ $contents->content }}</textarea>
                        <br/>
                        <input type="submit" value="Edit Content" class="btn btn-success"/>
                    </form>
                </div>
           </div>
           @endif
           @endforeach
        </main>
    </div>
</div> -->
@endsection
