@extends('layouts.admin.dashboard')

@section('title', 'Chatbot Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Chatbot Management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('chatbot.index')}}">Chatbot Management</a><a class="breadcrumbs__link">Create Fieldset</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="{{ route('chatbot.update')}}" method="POST">
            @csrf
            <div class="form__container">
              <h2 class="section__heading">Chatbot Input</h2>
              @foreach($fieldset as $fieldsets)
              <input type="hidden" name="fieldset_id" value="{{ $fieldsets->id }}">
              <div class="form__content form__content--full"><input class="form__input" name="field_set_title" value="{{ $fieldsets->field_set_title }}" type="text" /><label class="form__label">Fieldset title*</label></div>
              <div class="form__content form__content--full"><textarea class="form__input form__input--message" name="chatbot_input" rows="8">{{ $fieldsets->chatbot_input }}</textarea><label class="form__label">Chatbot input*</label></div>
              @endforeach
              <h2 class="section__heading">Response options</h2>
              @foreach($response as $responses)
              <div class="form__content form__content--full"><input class="form__input" type="text" value="{{ $responses->response_prompt}}" name="response_prompt[]"/><label class="form__label">Response prompt*</label></div>
              <div class="form__content form__content--full">
                <input type="hidden" name="responded_id[]" value="{{ $responses->id}}">
                <select class="form__input form__input--select" name="response_id[]">
                  <option value="">Select Field set</option>
                  <option value="{{ $fieldsets->id}}" selected>{{ $fieldsets->field_set_title }}</option>
                  @foreach ($details as $detail)
                  <option value="{{$detail->id}}">{{ $detail->field_set_title}}</option>
                  @endforeach
                </select>
                <label class="form__label">Link to fieldset*</label>
              </div>
              <div class="form__button form__button--end">
                <button data-toggle="modal" data-target="#js-delete-response-modal-{{ $responses->id }}" class="button button--medium js-delete-response js-trigger" type="button">Delete response</button>
                <div class="modal js-modal" id="js-delete-response-modal-{{$responses->id}}">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Delete response?</h2>
                  <p class="modal__text">Are you sure you want to delete this response?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close" type="button">Cancel</button><a href="{{ route('chatbot.delete',$responses->id)}}" class="button button--medium button--medium__delete" type="button">Delete response</a></div>
                </div>
              </div>
            </div>
              </div>
              @endforeach
            </div>
            <div id="add-response-option1">
            </div>
            <div id="add-response-option">
              <div class="form__content form__content--full"><input class="form__input" type="text" name="response_prompt[]"/><label class="form__label">Response prompt*</label></div>
              <div class="form__content form__content--full">
              <input type="hidden" name="responded_id[]" value="0">
                <select class="form__input form__input--select" name="response_id[]">
                  <option value="">Select Field set</option>
                  @foreach ($details as $detail)
                  <option value="{{$detail->id}}">{{ $detail->field_set_title}}</option>
                  @endforeach
                </select>
                <label class="form__label">Link to fieldset*</label>
              </div>
              <div class="form__button form__button--end">
                <input class="button button--medium js-delete-response" type="button" data-toggle="modal" data-target="#js-delete-response-modal" value="Delete response"><button class="button button--medium js-add-response1" type="button">Add response</button>
              </div>
            </div>
            <div class="form__button form__button--end">
            <input class="button" type="button" data-toggle="modal" data-target="#js-save-changes-modal" value="Save changes">
            </div></div>
            <div class="form__button form__button--end">
            <a class="button button--transparent" data-toggle="modal" data-target="#js-delete-fieldset-modal">Delete Fieldset</a>
            </div></div>
            <div class="modal js-modal" id="js-delete-fieldset-modal">
              <div class="modal__background js-modal-background" data-dismiss="modal"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Delete Fieldset?</h2>
                  <p class="modal__text">Fieldset and responses will be deleted. This may affect your other chatbot inputs and responses. Are you sure you want to delete?</p>
                  @foreach($fieldset as $fieldsets)
                  <div class="modal__button"><button class="button button--transparent" data-dismiss="modal" type="button">Cancel</button><a href="{{ route('chatbot.deleteFieldSet',$fieldsets->id)}}" class="button button--medium button--medium__delete" type="button">Delete fieldset</a></div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="modal js-modal" id="js-save-changes-modal">
              <div class="modal__background js-modal-background" data-dismiss="modal"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Save changes?</h2>
                  <p class="modal__text">All changes will update the version of the app. Are you sure you want to Save?</p>
                  <div class="modal__button"><button class="button button--transparent" data-dismiss="modal" type="button">Cancel</button><input class="button button--medium" type="submit" value="Save changes"></div>
                </div>
              </div>
            </div>
          </form>
          
        </div>
      </div>

      @endsection
