@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($provider as $providers)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{$providers->clinic_name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider management</a><a class="breadcrumbs__link" href="view-provider.php">{{$providers->clinic_name}}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
        @if ($errors->any())

        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
          @endif
          <form method="POST" class="form" id="js-provider-form" action="{{ route('updateProvider') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="clinic_id" value="{{ $providers->id}}">
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
                  <div class="form__wrapper"><img class="form__image" src="{{URL::asset('img/placeholder.jpg')}}" alt="Image placeholder" /></div>
                </li>
                <li class="form__group-item">
                  <div class="form__content">
                    <input class="button button--upload" id="js-upload" type="file" accept="image/*" name="js-upload" /><label class="form__label form__label--upload" for="js-upload">Upload a logo or a clinic photo</label>
                  </div>
                </li>
              </ul>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="text" placeholder="Provider name*" name="clinic_name" value="{{$providers->clinic_name}}" required /><label class="form__label">Provider name* </label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="region"></select>
                  <label class="form__label">Region*</label>
                </div>
              </div>
              <div class="form__inline">
              @if ($providers->type == '1')
                 <select name="type" class="form__input form__input--select">
                 <option value="1" selected>Private</option>
                 <option value="2">Government</option>
                 <option value="3">NGO</option>
                 </select>
                 @elseif ($providers->type == '2')
                 <select name="type" class="form__input form__input--select">
                 <option value="1">Private</option>
                 <option value="2" selected>Government</option>
                 <option value="3">NGO</option>
                 </select>
                 @elseif ($providers->type == '3')
                 <select name="type" class="form__input form__input--select">
                 <option value="1">Private</option>
                 <option value="2">Government</option>
                 <option value="3" selected>NGO</option>
                 </select>
                 @endif
                <div class="form__content">
                  <select class="form__input form__input--select" id="province"></select>
                  <label class="form__label">Province*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="number" placeholder="Contact number*" name="contact_number" value="{{ $providers->contact_number}}"/><label class="form__label">Contact number*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="city" name="city"></select>
                  <label class="form__label">City*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input name="email" class="form__input" type="email" value="{{$providers->email}}" placeholder="Email Address*" required /><label class="form__label">Email Address*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="barangay"></select>
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
                <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea"><span>Click to Upload File</span></div>
              </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic hours</h2>
                  <ul class="form__group form__group--schedule">
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="days[]" value="sunday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">M<input class="form__trigger" type="checkbox" name="days[]" value="monday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" type="checkbox" name="days[]" value="tuesday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">W<input class="form__trigger" name="days[]" value="wednesday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" name="days[]" value="thursday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">F<input class="form__trigger" type="checkbox" name="days[]" value="friday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="days[]" value="saturday" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" name="from[]"/><input class="form__input" type="time" name="to[]" placeholder="closing time" />
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <h2 class="section__heading">Available services</h2>
              <ul class="form__group form__group--createProviderServices">
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Modern method</h3>
                  @foreach($modernMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="avail_services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Permanent method</h3>
                  @foreach($permanentMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" value="{{$method->id}}" name="avail_services[]" /><span class="form__checkmark"></span></label>
                  @endforeach
                </li>
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Natural method</h3>
                  @foreach($naturalMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" value="{{$method->id}}" name="avail_services[]" /><span class="form__checkmark"></span></label>
                  @endforeach
                </li>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <div class="form__content">
                <div class="form__content form__content--row">
                  <label class="form__sublabel">Yes<input class="form__trigger" id="js-yes-paid" type="radio" name="paid" checked="checked" value="1"/><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" id="js-no-paid" type="radio" name="paid" value="0" /><span class="form__radio"></span></label>
                </div>
                <label class="form__label form__label--blue" for="paid-services">Do you have paid services?</label>
              </div>
              <div class="js-services-content">
                <h2 class="section__heading section__heading--margin">Which of your services are paid?</h2>
                <ul class="form__group form__group--createProviderServices">
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Modern method</h3>
                    @foreach($modernMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Permanent method</h3>
                    @foreach($permanentMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach

                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Natural method</h3>
                    @foreach($naturalMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}} / {{ $method->short_name }}<input class="form__trigger" type="checkbox" name="services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach

                  </li>
                </ul>
              </div>
            </div>
            <div class="form__button form__button--end"><button class="button" type="submit">Save changes</button></div>
          </form>
        </div>
      </div>

@endforeach
@endsection
