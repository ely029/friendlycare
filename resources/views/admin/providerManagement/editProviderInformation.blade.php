@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">FriendlyCare Cubao</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="provider-management.php">Provider management</a><a class="breadcrumbs__link" href="view-provider.php">FriendlyCare Cubao</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" id="js-provider-form" action="">
            <div class="tabs">
              <ul class="tabs__list">
                <li class="tabs__item tabs__item--current">
                  <div class="tabs__wrapper"><img class="tabs__image" src="img/icon-step.png" alt="Step 1" /></div>
                  <span class="tabs__text">Company info</span>
                </li>
                <li class="tabs__item">
                  <div class="tabs__wrapper"><img class="tabs__image" src="img/icon-step.png" alt="Step 2" /></div>
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
                <div class="form__content"><input class="form__input" type="text" placeholder="Provider name*" required /><label class="form__label">Provider name* </label></div>
                <div class="form__content">
                  <select class="form__input form__input--select" id="region" required></select>
                  <label class="form__label">Region*</label>
                </div>
              </div>
              <div class="form__inline">
                <div class="form__content"><input class="form__input" type="text" placeholder="Category*" required /><label class="form__label">Category*</label></div>
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

<!-- 
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
           <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        @foreach ($provider as $providers)
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>{{ $providers->clinic_name }}</h2>
                    <span>Provider Management</span>&nbsp;&nbsp;&nbsp;<span>{{ $providers->clinic_name }}</span>
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
            <form method="POST" action="#">
             @csrf
             <div class="row">
                 <div class="col-md-6">
                        <img class="rounded-cirle" width="100" height="100" src="{{ $providers->photo_url }}"/>
                                <div class="edit-page-provider-info-image-side">
                                    <span>{{ $providers->clinic_name }}</span><br>
                                    <span>{{$providers->email }}</span><br>
                                    <span>{{ $providers->contact_number }}</span>
                                </div>
                 </div>
                 <div class="col-md-2">
                 </div>
                 <div class="col-md-4">
                   <span>Status</span>
                   <input type="checkbox" name="is_enabled" checked/>
                 </div>
             </div>
                    <div class="row clinic-info-title">
                        <div class="col-md-6">
                        <h4><b>Clinic Info</b></h4>
                        </div>
                        <div class="col-md-6">
                            <span>Gallery</span><br/>
                            @foreach($galleries as $gallery)
                <img height="50" width="50" src="{{ url(('uploads/'.$gallery->file_name)) }}">
                  @endforeach<br/>
                        </div>
                    </div>
                    <div class="row clinic-info-street">
                        <div class="col-md-6">
                        <h6><b>Street Address</b></h6>
                            <span>{{ $providers->street_address }}{{ $providers->city }}{{ $providers->municipality }} {{ $providers->province }}</span>
                        </div>
                    </div>
                    <div class="row clinic-info-category">
                        <div class="col-md-6">
                        <h6><b>Category</b></h6>
                            @if($providers->type == '1')
                            <span>Private</span>
                            @elseif($providers->type == '2')
                            <span>Government</span>
                            @elseif($providers->type == '3')
                            <span>NGO</span>
                            @endif
                        </div>
                    </div>
                    <div class="row clinic-info-description">
                        <div class="col-md-6">
                        <h6><b>Description</b></h6>
                            <span>{{ $providers->description }}</span>
                        </div>
                    </div>
                    <div class="row bg-white">
                    <h4><b>Services</b></h4>
                    </div>
                        <div class="row bg-white">
                            <div class="col-md-4">
                            <h5>Modern Method</h5><br>
                            @foreach ($modernMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                            <div class="col-md-4">
                            <h5>Permanent Method</h5><br>
                            @foreach ($permanentMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                            <div class="col-md-4">
                            <h5>Natural Method</h5><br>
                            @foreach ($naturalMethod as $method)
                            {{ $method->name}}<br/>
                            @endforeach
                            </div>
                        </div>
                    <div class="row bg-white">
                       <div class="col-md-12">
                       <h5><b>Staffs</b></h5>
                       </div>
                    </div>
                    <div class="row bg-white">
                       <div class="col-md-12">
                       @foreach($staffs as $staff)
                       <span>{{ $staff->first_name}} {{ $staff->last_name}}</span><br/>
                       @endforeach
                       </div>
                    </div>
                    <div class="row bg-white">
                        <div class="col-md-12">
                            <h5><b>Paid Services</b></h5>
                        </div>
                    </div>
                    <div class="row bg-white">
                        <div class="col-md-12">
                            @foreach ($paidServices as $paidService)
                            <span>{{ $paidService->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row bg-white">
                              <div class="col-md-12">
                                  <span>Philhealth Accredited?</span><br/>
                                  @if ($providers->philhealth_accredited_1 == '1')
                                  <span>Yes</span>
                                  @else
                                  <span>No</span>
                                  @endif
                              </div>
                    </div>
                    <div class="row bg-white">
                      <div class="col-md-12">
                      <h5>Clinic Hours</h5>
                      </div>
                    </div>
                    @foreach ($clinicHours as $hours)
                    <div class="row bg-white">
                      <div class="col-md-4">
                      <span>{{ $hours->days}}</span>
                      </div>
                      <div class="col-md-8">
                      <span>{{ $hours->froms}} - {{ $hours->tos }}</span>
                      </div>
                    </div>
                    @endforeach
                    <div class="row">
                          <div class="col-md-6">
                              <a href="{{ route('editPage',$providers->id )}}" class="btn btn-success">Edit Profile</a>
                          </div>
                          <div class="col-md-6">
                              @if (Auth::user()->role_id == 2)
                              @else
                              <a data-toggle="modal" data-target="#confirmProviderCreation" href="#" class="btn btn-secondary">Delete Provider</a>
                              @endif
                          </div>
                    </div>

                    <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Provider</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete this provider. Proceed?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('deleteProvider',$providers->id )}}" class="btn btn-success">Delete Provider</a>
                                </div>
                        </div>
                    </div>
            </div>
            </form>           
        </main>
        @endforeach
        
    </div>
</div> -->
@endsection
