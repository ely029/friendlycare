@extends('layouts.admin.dashboard')

@section('title', 'Provider Management')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($provider as $providers)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{$providers->clinic_name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider management</a><a class="breadcrumbs__link">{{$providers->clinic_name}}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @if ($errors->any())

        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
          @endif
          <form method="POST" class="form" id="js-provider-form" action="{{ route('updateProvider') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="clinic_id" name="clinic_id" value="{{ $providers->id}}">
          <div class="tabs">
              <ul class="tabs__list">
                <li class="tabs__item tabs__item--current">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 1" /></div>
                  <span class="tabs__text">Company info</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 2" /></div>
                  <span class="tabs__text">Gallery / schedule</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 3" /></div>
                  <span class="tabs__text">Clinic services</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.svg')}}" alt="Step 4" /></div>
                  <span class="tabs__text">Paid services</span>
                </li>
              </ul>
            </div>
            <div class="tabs__details tabs__details--active">
              <ul class="form__group form__group--upload">
                <li class="form__group-item">
                  <div class="form__wrapper"><img class="form__image" src="{{ $providers->photo_url}}" alt="Image placeholder" /></div>
                </li>
                <li class="form__group-item">
                  <div class="form__content">
                    <input class="button button--upload profile-pic-upload" id="js-upload" name="pic" type="file" accept="image/*" /><label class="form__label form__label--upload" for="js-upload">Upload a logo or a clinic photo</label>
                    <input type="hidden" name="pic_url" id="pic_url"/>
                  </div>
                </li>
              </ul>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="text" placeholder="Provider name*" name="clinic_name" value="{{$providers->clinic_name}}" required /><label class="form__label">Provider name* </label></div>
                <div class="form__content">
                  <input type="hidden" id="region_string" value="{{ $providers->region_id_string }}">
                  <input type="hidden" id="province_string" value="{{ $providers->province_id_string }}">
                  <input type="hidden" id="city_string" value="{{ $providers->city_id_string }}">
                  <select name="region" class="form__input form__input--select" id="region">
                    <option value="{{ $providers->region_id_string }}" selected>{{ $providers->region }}</option>
                  @foreach($data as $datas)
                  <option value="{{ $datas->region_code }}">{{ $datas->region_description }}</option>
                  @endforeach
                  </select>
                  <label class="form__label">Region*</label>
                </div>
              </div>
              <div class="form__inline">
              @if ($providers->type == '1')
                <div class="form__content"> 
                 <select name="type" class="form__input form__input--select">
                 <option value="1" selected>Private</option>
                 <option value="2">Government</option>
                 <option value="3">NGO</option>
                 </select>
                 <label class="form__label">Category*</label>
                 </div>
                 @elseif ($providers->type == '2')
                  <div class="form__content"> 
                 <select name="type" class="form__input form__input--select">
                 <option value="1">Private</option>
                 <option value="2" selected>Government</option>
                 <option value="3">NGO</option>
                 </select>
                 <label class="form__label">Category*</label>
                 </div>
                 @elseif ($providers->type == '3')
                  <div class="form__content"> 
                 <select name="type" class="form__input form__input--select">
                 <option value="1">Private</option>
                 <option value="2">Government</option>
                 <option value="3" selected>NGO</option>
                 </select>
                 <label class="form__label">Category*</label>
                 </div>
                 @else
                 <div class="form__content"> 
                 <select name="type" class="form__input form__input--select">
                 <option value="1">Private</option>
                 <option value="2">Government</option>
                 <option value="3">NGO</option>
                 </select>
                 <label class="form__label">Category*</label>
                 </div>
                 @endif
                <div class="form__content">
                  <select class="form__input form__input--select" name="province" id="province">
                    <option value="" selected>{{ $providers->province }}</option>
                  </select>
                  <label class="form__label">Province*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="number" placeholder="Contact number*" name="contact_number" value="{{ $providers->contact_number}}"/><label class="form__label">Contact number*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="city" name="city">
                    <option value="" selected>{{ $providers->city }}</option>
                  </select>
                  <label class="form__label">City*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input name="email" class="form__input" type="email" value="{{$providers->email}}" placeholder="Email Address*" required /><label class="form__label">Email Address*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="barangay" name="barangay">
                    <option value="{{$providers->barangay_id_string }}" selected>{{ $providers->barangay }}</option>
                  </select>
                  <label class="form__label">Barangay*</label>
                </div>
              </div>
              <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Street address*" name="street_address" value="{{$providers->street_address}}"/><label class="form__label">Street address*</label></div>
              <div class="form__content form__content--full"><textarea class="form__input form__input--message" placeholder="Clinic description (optional)" name="description">{{ $providers->description }}</textarea><label class="form__label">Clinic description (optional)</label></div>
              <div class="form__content">
                <div class="form__content form__content--row">
                @if($providers->philhealth_accredited_1 == '1')
                <label class="form__sublabel">Yes<input value="1" class="form__trigger" type="radio" name="philhealth_accredited_1" checked /><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input value="0" class="form__trigger" type="radio" name="philhealth_accredited_1" /><span class="form__radio"></span></label>
                  @else
                  <label class="form__sublabel">Yes<input value="1" class="form__trigger" type="radio" name="philhealth_accredited_1" /><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input value="0" class="form__trigger" type="radio" name="philhealth_accredited_1" checked/><span class="form__radio"></span></label>
                @endif
                </div>
                <label class="form__label form__label--blue" for="philhealth-accredited">Are you Philhealth accredited? </label>
              </div>
            </div>
            <div class="tabs__details">
              <ul class="form__group">
                <li class="form__group-item"><h2 class="section__heading">Clinic gallery</h2>
                <div class="dz-default dz-message dropzoneDragArea gallery" id="dropzoneDragArea">
                  <div class="gallery__icon"><img class="gallery__image gallery__image--upload" src="{{URL::asset('img/icon-upload.png')}}" alt="Upload icon" /></div>
                  <span class="gallery__text gallery__text--gray">Upload image maximum 2 mb,<br>maximum 5 images</span><span class="gallery__text">Select file</span>
                </div>  
                <ul class="gallery__list" id="tpl">
                @foreach($galleries as $gallery)
                <li class="gallery__item dz-preview dz-file-preview"><img data-dz-thumbnail class="gallery__image" src="{{ $gallery->file_url}}">
                <a href="{{ route('provider.deleteGallery',['id' => $gallery->id, 'clinicId' => $gallery->clinic_id]  )}}" class="button button--close" aria-hidden="true">&times;</a>
                </li>
                  @endforeach
                </ul>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic hours</h2>
                  <ul class="form__group form__group--schedule">
                    @foreach($clinic_hours as $clinic_hour)
                    @if ($clinic_hour->froms == NULL && $clinic_hour->tos == NULL)
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">@if($clinic_hour->days == 'Thursday') {{ ucfirst(substr($clinic_hour->days, 0, 2)) }} @else {{ ucfirst(substr($clinic_hour->days, 0, 1)) }} @endif<input class="form__trigger" type="checkbox" name="days[{{ $clinic_hour->id_value}}]" value="{{ $clinic_hour->days }}"/><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]" value=""/><input class="form__input" type="time" name="to[]" value="" placeholder="closing time" />
                    </li>
                    @else
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">@if($clinic_hour->days == 'thursday'){{ ucfirst(substr($clinic_hour->days, 0, 2)) }} @else {{ ucfirst(substr($clinic_hour->days, 0, 1)) }} @endif <input class="form__trigger" type="checkbox" name="days[{{ $clinic_hour->id_value}}]" value="{{ $clinic_hour->days }}" checked/><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]" value="{{ $clinic_hour->froms }}"/><input class="form__input" type="time" name="to[]" value="{{ $clinic_hour->tos }}" placeholder="closing time" />
                    </li>
                    @endif
                    @endforeach
                    
                  </ul>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <h2 class="section__heading">Available services</h2>
              <ul class="form__group form__group--createProviderServices">
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Modern method</h3>
                  @foreach($service_modern as $method)
                  @if($method->is_checked == 1)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" checked/><span class="form__checkmark"></span></label>
                  @else
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endif
                  @endforeach
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Permanent method</h3>
                  @foreach($service_permanent as $method)
                  @if($method->is_checked == 1)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" checked/><span class="form__checkmark"></span></label>
                  @else
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endif
                  @endforeach
                </li>
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Natural method</h3>
                  @foreach($service_natural as $method)
                  @if($method->is_checked == 1)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" checked/><span class="form__checkmark"></span></label>
                  @else
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[{{ $method->id }}]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endif
                  @endforeach
                </li>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <div class="form__content">
                <div class="form__content form__content--row">
                  @if ($providers->paid_service == '1')
                  <label class="form__sublabel">Yes<input class="form__trigger" id="js-yes-paid" type="radio" name="paid" checked="checked" value="1"/><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" id="js-no-paid" type="radio" name="paid" value="0" /><span class="form__radio"></span></label>
                  @else
                  <label class="form__sublabel">Yes<input class="form__trigger" id="js-yes-paid" type="radio" name="paid" value="1"/><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" id="js-no-paid" type="radio" name="paid" checked="checked" value="0" /><span class="form__radio"></span></label>
                  @endif
                </div>
                <label class="form__label form__label--blue" for="paid-services">Do you have paid services?</label>
              </div>
              <div class="js-services-content">
                <h2 class="section__heading section__heading--margin">Which of your services are paid?</h2>
                <ul class="form__group form__group--createProviderServices">
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Modern method</h3>
                    @foreach($modernMethod as $method)
                    @if($method->is_checked == '1')
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" checked name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @else
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @endif
                  @endforeach
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Permanent method</h3>
                    @foreach($permanentMethod as $method)
                    @if($method->is_checked == '1')
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" checked name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @else
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @endif
                  @endforeach
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Natural method</h3>
                    @foreach($naturalMethod as $method)
                    @if($method->is_checked == '1')
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" checked name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @else
                    <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                    @endif
                  @endforeach

                  </li>
                </ul>
              </div>
            </div>
            <div class="form__button form__button--end"><input value="Save changes" class="button js-trigger"></div>
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
