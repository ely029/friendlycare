@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Methods')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($details as $user)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Edit method</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{  route('familyPlanningMethod.index')}}">Family planning methods</a><a class="breadcrumbs__link">Edit method</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--method" id="js-provider-form" method="POST" action="{{ route('familyPlanningMethod.update')}}" enctype="multipart/form-data">
          @csrf  
          <input type="hidden" name="id" id="id" value="{{ $user->id }}"/>
          <div class="tabs">
              <ul class="tabs__list">
                <li class="tabs__item tabs__item--method tabs__item--current">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 1" /></div>
                  <span class="tabs__text">Details</span>
                </li>
                <li class="tabs__item tabs__item--method">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 2" /></div>
                  <span class="tabs__text">Content</span>
                </li>
                <li class="tabs__item tabs__item--method">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 3" /></div>
                  <span class="tabs__text">Gallery</span>
                </li>
              </ul>
            </div>
            <div class="tabs__details tabs__details--active">
              <ul class="form__group form__group--editMethod">
                <li class="form__group-item">
                  <h2 class="section__heading">Details</h2>
                  <ul class="form__group form__group--upload form__group--uploadEditMethod">
                    <li class="form__group-item">
                      <div class="form__wrapper"><img class="form__image form__image--method" src="{{ $user->icon_url}}" alt="Image placeholder" /></div>
                    </li>
                    <li class="form__group-item">
                      <div class="form__content">
                        <input class="button button--upload button--upload__method" id="js-upload" type="file" accept="image/*" name="icon" /><label class="form__label form__label--upload" for="js-upload">Upload a service icon </label>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Effectiveness (in percent)</h2>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Sa tamang paggamit*" required name="percent_effective" value="{{$user->percent_effective}}" /><label class="form__label">Sa tamang paggamit* </label></div>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Tipikal na bisa*" required name="typical_validity" value="{{$user->typical_validity}}"/><label class="form__label">Tipikal na bisa* </label></div>
                </li>
              </ul>
              <ul class="form__group">
                <li class="form__group-item">
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Method name*" required name="name" value="{{$user->name}}" /><label class="form__label">Method name* </label></div>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Short name*" name="short_name" value="{{$user->short_name}}" /><label class="form__label">Short name* </label></div>
                  <div class="form__content form__content--full">
                    <select name="family_plan_type_id" class="form__input form__input--select">
                      @if ($user->family_plan_type_id == 1)
                      <option value="1" selected>Modern Method</option>
                      <option value="2">Permanent Method</option>
                      <option value="3">Natural Method</option>
                      @endif
                      @if ($user->family_plan_type_id == 2)
                      <option value="2" selected>Permanent Method</option>
                      <option value="1">Modern Method</option>
                      <option value="3">Natural Method</option>
                      @endif
                      @if ($user->family_plan_type_id == 3)
                      <option value="3" selected>Natural Method</option>
                      <option value="1">Modern Method</option>
                      <option value="2">Permanent Method</option>
                      @endif
                    </select>
                    <label class="form__label">Category* </label>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <h2 class="section__heading">Content</h2>
              <ul class="tabs__list tabs__list--method">
                <li class="tabs__subitem">
                  <input class="tabs__trigger" id="description" type="radio" name="rd" checked />
                  <div class="tabs__title"><label class="tabs__label" for="description">Description</label></div>
                  <div class="tabs__subdetails">
                    <h2 class="section__heading">Description</h2>
                    <div class="form__inline">
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Description (English)*" name="description_english" required>{{ $user->description_english }}</textarea>
                        <label class="form__label">Description (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Description (Filipino)*" required name="description_tagalog">{{ $user->description_filipino}}</textarea>
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
                        <textarea class="form__input form__input--message" contenteditable placeholder="How it works (English)*" required name="how_it_works_english">{{ $user->how_it_works_english }}</textarea>
                        <label class="form__label">How it works (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="How it works (Filipino)*" name="how_it_works_tagalog" required>{{ $user->how_it_works_filipino }}</textarea>
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
                        <textarea class="form__input form__input--message" contenteditable placeholder="Possible side effects (English)*" required name="side_effect_english">{{ $user->side_effect_english }}</textarea>
                        <label class="form__label">Possible side effects (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Possible side effects (Filipino)*" required name="side_effect_tagalog">{{$user->side_effect_filipino }}</textarea>
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
                        <textarea class="form__input form__input--message" contenteditable placeholder="Additional notes (English)*" required name="additional_note_english">{{ $user->additional_note_english }}</textarea>
                        <label class="form__label">Additional notes (English)</label>
                      </div>
                      <div class="form__content form__content--half">
                        <textarea class="form__input form__input--message" contenteditable placeholder="Additional notes (Filipino)*" required name="additional_note_tagalog">{{ $user->additional_note_filipino }}</textarea>
                        <label class="form__label">Additional notes (Filipino)</label>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <ul class="form__group">
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic gallery</h2>
                  <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea">
                    <div class="gallery">
                      <div class="gallery__icon"><img class="gallery__image gallery__image--upload" src="{{URL::asset('img/icon-upload.png')}}" alt="Upload icon" /></div>
                      <span class="gallery__text gallery__text--gray"></span><span class="gallery__text">Select file</span>
                    </div>  

                  </div>
                  <ul class="gallery__list">
                  @foreach($serviceGallery as $serviceGalleries)
                  <li class="gallery__item"><img class="gallery__image" src="{{ $serviceGalleries->file_url}}">
                     <a href="{{ route('familyPlanningMethod.deleteGallery', ['id' => $serviceGalleries->id, 'serviceId' => $serviceGalleries->service_id])}}" class="button button--close" aria-hidden="true">&times;</a>
                 </li>
                  @endforeach
                </ul>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Video</h2>
                  <div class="form__content form__content--full"><input class="form__input form__input--search" name="video_link" value="{{$user->video_link}}" type="text" placeholder="Youtube link*" required /><label class="form__label">Youtube link*</label></div>
                  <iframe class="form__video form__video--edit" src="{{ $user->video_link }}" frameborder="0" allowfullscreen></iframe>
                </li>
              </ul>
            </div>
            <div class="form__button form__button--end"><button class="button js-trigger" type="button">Save changes</button></div>
            <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Save changes!</h2>
                <p class="modal__text">All changes will update the version of the app. Are you sure you want to Save?</p>
                <div class="modal__button modal__button--center"><button class="button button--medium" type="submit">Confirm</button></div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
@endforeach
@endsection
