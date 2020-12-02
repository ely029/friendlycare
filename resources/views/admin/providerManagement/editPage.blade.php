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
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="provider-management.php">Provider management</a><a class="breadcrumbs__link" href="view-provider.php">FriendlyCare Cubao</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" id="js-provider-form" action="">
            <div class="tabs">
              <ul class="tabs__list">
                <li class="tabs__item tabs__item--current">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.png')}}" alt="Step 1" /></div>
                  <span class="tabs__text">Company info</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="{{URL::asset('img/icon-step.png')}}" alt="Step 2" /></div>
                  <span class="tabs__text">Gallery / schedule</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="img/icon-step.png" alt="Step 3" /></div>
                  <span class="tabs__text">Clinic services</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="img/icon-step.png" alt="Step 4" /></div>
                  <span class="tabs__text">Paid services</span>
                </li>
              </ul>
            </div>
            <div class="tabs__details tabs__details--active">
              <ul class="form__group form__group--upload">
                <li class="form__group-item">
                  <div class="form__wrapper"><img class="form__image" src="img/placeholder.jpg" alt="Image placeholder" /></div>
                </li>
                <li class="form__group-item">
                  <div class="form__content">
                    <input class="button button--upload" id="js-upload" type="file" accept="image/*" name="js-upload" /><label class="form__label form__label--upload" for="js-upload">Upload a logo or a clinic photo</label>
                  </div>
                </li>
              </ul>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="text" placeholder="Provider name*" value="{{$providers->clinic_name}}" required /><label class="form__label">Provider name* </label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="region" required></select>
                  <label class="form__label">Region*</label>
                </div>
              </div>
              <div class="form__inline">
              @if ($providers->type == '1')
                 <select name="type" class="form__input">
                 <option value="1" selected>Private</option>
                 <option value="2">Government</option>
                 <option value="3">NGO</option>
                 </select>
                 @elseif ($providers->type == '2')
                 <select name="type" class="form__input">
                 <option value="1">Private</option>
                 <option value="2" selected>Government</option>
                 <option value="3">NGO</option>
                 </select>
                 @elseif ($providers->type == '3')
                 <select name="type" class="form__input">
                 <option value="1">Private</option>
                 <option value="2">Government</option>
                 <option value="3" selected>NGO</option>
                 </select>
                 @endif
                <div class="form__content">
                  <select class="form__input form__input--select" id="province" required></select>
                  <label class="form__label">Province*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="number" placeholder="Contact number*" required /><label class="form__label">Contact number*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="city" required></select>
                  <label class="form__label">City*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="email" placeholder="Email Address*" required /><label class="form__label">Email Address*</label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="barangay" required></select>
                  <label class="form__label">Barangay*</label>
                </div>
              </div>
              <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Street address*" /><label class="form__label">Street address*</label></div>
              <div class="form__content form__content--full"><textarea class="form__input form__input--message" placeholder="Clinic description (optional)"></textarea><label class="form__label">Clinic description (optional)</label></div>
              <div class="form__content">
                <div class="form__content form__content--row">
                  <label class="form__sublabel">Yes<input class="form__trigger" type="radio" name="philhealth-accredited" /><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" type="radio" name="philhealth-accredited" /><span class="form__radio"></span></label>
                </div>
                <label class="form__label form__label--blue" for="philhealth-accredited">Are you Philhealth accredited? </label>
              </div>
            </div>
            <div class="tabs__details">
              <ul class="form__group">
                <li class="form__group-item"><h2 class="section__heading">Clinic gallery</h2></li>
                <li class="form__group-item">
                  <h2 class="section__heading">Clinic hours</h2>
                  <ul class="form__group form__group--schedule">
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">M<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">W<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">F<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
                    </li>
                    <li class="form__group-item">
                      <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                      <input class="form__input" type="time" placeholder="opening time" /><input class="form__input" type="time" placeholder="closing time" />
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
                  <label class="form__sublabel form__sublabel--services">COC / Pills<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Pop / Minipills<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Injectables<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">PSI Implants<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">IUD<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Condom<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Permanent method</h3>
                  <label class="form__sublabel form__sublabel--services">Bilateral tubal ligation<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">No scalpel vasectomy<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"> </span></label>
                </li>
                <li class="form__group-item">
                  <h3 class="section__heading section__heading--sub">Natural method</h3>
                  <label class="form__sublabel form__sublabel--services">Lactational Amenorrhea<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Billings Ovulation Method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Basal body temperature<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Sympto-thermal method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  <label class="form__sublabel form__sublabel--services">Standard days method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                </li>
              </ul>
            </div>
            <div class="tabs__details">
              <div class="form__content">
                <div class="form__content form__content--row">
                  <label class="form__sublabel">Yes<input class="form__trigger" id="js-yes-paid" type="radio" name="paid-services" checked="checked" /><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" id="js-no-paid" type="radio" name="paid-services" /><span class="form__radio"></span></label>
                </div>
                <label class="form__label form__label--blue" for="paid-services">Do you have paid services?</label>
              </div>
              <div class="js-services-content">
                <h2 class="section__heading section__heading--margin">Which of your services are paid?</h2>
                <ul class="form__group form__group--createProviderServices">
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Modern method</h3>
                    <label class="form__sublabel form__sublabel--services">COC / Pills<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Pop / Minipills<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Injectables<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">PSI Implants<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">IUD<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Condom<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Permanent method</h3>
                    <label class="form__sublabel form__sublabel--services">Bilateral tubal ligation<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">No scalpel vasectomy<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"> </span></label>
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Natural method</h3>
                    <label class="form__sublabel form__sublabel--services">Lactational Amenorrhea<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Billings Ovulation Method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Basal body temperature<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Sympto-thermal method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                    <label class="form__sublabel form__sublabel--services">Standard days method<input class="form__trigger" type="checkbox" name="" /><span class="form__checkmark"></span></label>
                  </li>
                </ul>
              </div>
            </div>
            <div class="form__button form__button--end"><button class="button" type="button">Save changes</button></div>
          </form>
        </div>
      </div>

@endforeach

<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">

            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create provider</h2>
                    <span>Provider Management</span><span>Create Provider</span>
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
            <form method="POST" action="{{ route('updateProvider') }}" enctype="multipart/form-data">
                @csrf
             @foreach ($provider as $providers)
             <input type="hidden" name="clinic_id" value="{{ $providers->id}}">
             <table class="table table-bordered">
                 <tr>
                     <td>Clinic Name</td>
                     <td><input type="text" name="clinic_name" value="{{ $providers->clinic_name }}"></td>
                 </tr>
                 <tr>

                 <tr>
                     <td>Description</td>
                     <td><input type="text" name="description" value="{{ $providers->description }}"></td>
                 </tr>
                 <tr>
                
                     <td>Email</td>
                     <td><input type="text" name="email" value="{{ $providers->email }}"></td>
                 </tr>
                 <tr>
                     <td>City</td>
                     <td><input type="text" name="city" value="{{ $providers->city }}"></td>
                 </tr>
                 <tr>
                     <td>Province</td>
                     <td><input type="text" name="province" value="{{ $providers->province }}"></td>
                 </tr>
                 <tr>
                     <td>Municipality</td>
                     <td><input type="text" name="municipality" value="{{ $providers->municipality }}"></td>
                 </tr>
                 <tr>
                     <td>Contact-Number</td>
                     <td><input type="text" name="contact_number" maxlength="14" value="{{ $providers->contact_number }}"></td>
                 </tr>
                 <tr>
                     <td>Street Address</td>
                     <td><input type="text" name="street_address" value="{{ $providers->street_address }}"></td>
                 </tr>
                 <tr>
                 <td>Type</td>
                 </tr>
                 <tr>
                 @if ($providers->type == '1')
                 <td>
                 <select name="type" class="form-control">
                 <option value="1" selected>Private</option>
                 <option value="2">Government</option>
                 <option value="3">NGO</option>
                 </select>
                 </td>
                 @elseif ($providers->type == '2')
                 <td>
                 <select name="type" class="form-control">
                 <option value="1">Private</option>
                 <option value="2" selected>Government</option>
                 <option value="3">NGO</option>
                 </select>
                 </td>
                 @elseif ($providers->type == '3')
                 <td>
                 <select name="type" class="form-control">
                 <option value="1">Private</option>
                 <option value="2">Government</option>
                 <option value="3" selected>NGO</option>
                 </select>
                 </td>
                 @endif
                 <tr>
                 <td>Paid Service?</td>
                 <td>
                 @if ($providers->paid_service == 0)
                 <input type="radio" name="paid" value="1">Yes <br/><input type="radio" name="paid" value="0" checked>No
                 @elseif ($providers->paid_service == 1)
                 <input type="radio" name="paid" value="1" checked>Yes <br/><input type="radio" name="paid" value="0">No
                 @endif
                 </td>
                 </tr>
                  </tr>
                  <tr>
                      <td>Phil Health Accredited?</td><td>
                          @if($providers->philhealth_accredited_1 == '1')
                          <input type="radio" name="philhealth_accredited_1" value="1" checked>Yes<br/>
                          <input type="radio" name="philhealth_accredited_1" value="0">No
                          @elseif ($providers->philhealth_accredited_1 == '0')
                          <input type="radio" name="philhealth_accredited_1" value="1">Yes<br/>
                          <input type="radio" name="philhealth_accredited_1" value="0" checked>No
                          @else 
                          <input type="radio" name="philhealth_accredited_1" value="1">Yes<br/>
                          <input type="radio" name="philhealth_accredited_1" value="0" checked>No
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <td>Paid Services</td>
                      <td>
                          <span>Modern Method</span><br/>
                          @foreach($modernMethod as $method)
                          <input type="checkbox" name="services[]" value="{{$method->id}}">{{ $method->name}}<br/>
                          @endforeach
                          <span>Natural Method</span><br/>
                          @foreach($naturalMethod as $method)
                          <input type="checkbox" name="services[]" value="{{$method->id}}">{{ $method->name}}<br/>
                          @endforeach
                          <span>Permanent Method</span><br/>
                          @foreach($permanentMethod as $method)
                          <input type="checkbox" name="services[]" value="{{$method->id}}">{{ $method->name}}<br/>
                          @endforeach
                      </td>
                  </tr>
                  <tr>
                  <td>Clinic Hours</td>
                  <td><div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Sunday</span>
                    <input type="checkbox" name="days[]" value="sunday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Monday</span>
                    <input type="checkbox" name="days[]" value="monday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Tuesday</span>
                    <input type="checkbox" name="days[]" value="tuesday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Wednesday</span>
                    <input type="checkbox" name="days[]" value="wednesday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Thursday</span>
                    <input type="checkbox" name="days[]" value="thursday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Friday</span>
                    <input type="checkbox" name="days[]" value="friday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Saturday</span>
                    <input type="checkbox" name="days[]" value="saturday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            </td>
                  </tr>
                  <tr>
                  <td>Gallery</td>
                  <td>                  
                  @foreach($galleries as $gallery)
                <img height="50" width="50" src="{{ url(('uploads/'.$gallery->file_name)) }}">
                  @endforeach<br/>
                  <input type="file" name="gallery[]" multiple>
                  </td>
                  </tr>
                 <tr>
                     <td><input type="submit" value="Edit Profile" class="btn btn-success"></td>
                 </tr>
             </table>
             @endforeach
              
             
        </form>
            
        </main>
    </div>
</div> -->
@endsection
