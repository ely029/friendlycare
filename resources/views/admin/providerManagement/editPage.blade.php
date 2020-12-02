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
          <form class="form form--viewProvider" id="js-provider-form" action="">
            <ul class="form__group form__group--viewProvider">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image" src="img/placeholder.jpg" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">FriendlyCare Cubao</label>
                  <span class="form__text form__text--group">
                    <div id="rateYo"></div>
                    <span class="form__text">(17)</span><a class="form__link form__link--gray" href="">View reviews?</a>
                  </span>
                  <span class="form__text">friendlycarecubao@friendlycare.com</span><span class="form__text">09857754852</span>
                </div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">Status</label><label class="form__switch" for=""> <input class="form__trigger form__trigger--switch" type="checkbox" checked /><span class="form__slider"></span></label>
                </div>
              </li>
            </ul>
            <ul class="form__group">
              <li class="form__group-item">
                <h2 class="section__heading">Clinic info</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Address</label><span class="form__text">2/F Metrolane Complex, P.Tuazon Corner 20th Avenue, Cubao, Quezon, 20th Ave, Project 4, Quezon City, Metro Manila</span>
                  <a class="form__link" href="">view on map</a>
                </div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Category</label><span class="form__text">Government</span></div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description</label>
                  <span class="form__text">
                    We're located at the heart of Cubao at Metrolane complex. We offer free consultations, diagnostics, and lab procedures. <br />
                    <br />
                    Get expert advice on Family Planning, book an appointment free of charge.
                  </span>
                </div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Operating hours</label><span class="form__text">6:00am to 6:00pm</span></div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Assigned staff</label><span class="form__text">John Smith </span><span class="form__text">Leoniva Reyes </span><span class="form__text">Alan Popa </span>
                  <span class="form__text">Michelle Cruz </span><span class="form__text">Ryan Chua</span>
                </div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Clinic gallery</h2>
                <ul class="form__gallery">
                  <li class="form__gallery-item"><img class="form__gallery-image" src="img/placeholder.jpg" alt="Gallery image" /></li>
                  <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                  <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                  <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                  <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                </ul>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Available services</label>
                  <ul class="form__group form__group--viewProviderServices">
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Modern method</h3>
                      <span class="form__text">COC / pills </span><span class="form__text">Pop / minipills </span><span class="form__text">Injectables </span><span class="form__text">PSI implants </span>
                      <span class="form__text">IUD Condom</span>
                    </li>
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Permanent method</h3>
                      <span class="form__text">Bilateral tubal ligation </span><span class="form__text">No scalpel vasectomy</span>
                    </li>
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Natural method</h3>
                      <span class="form__text">Lactational Amenorrhea </span><span class="form__text">Billings Ovulation Method </span><span class="form__text">Basal body temperature </span>
                      <span class="form__text">Sympto-thermal method </span><span class="form__text">Standard days method</span>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--start"><a class="button" href="edit-provider.php">Edit provider</a><button class="button button--transparent" type="button">Delete provider</button></div>
          </form>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Disable provider?</h2>
                <p class="modal__text">Disabled providers are hidden from the patient app. Are you sure you want to disable?</p>
                <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium" type="button">Disable</button></div>
              </div>
            </div>
          </div>
          <div class="modal js-modal">
            <div class="modal__background js-modal-background"></div>
            <div class="modal__container">
              <div class="modal__box">
                <h2 class="modal__title">Enable provider?</h2>
                <p class="modal__text">Enabled providers will show in the patient's app. Are you sure you want to enable this provider?</p>
                <div class="modal__button"><button class="button button--transparent" type="button">Cancel</button><button class="button button--medium" type="button">Enable</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
