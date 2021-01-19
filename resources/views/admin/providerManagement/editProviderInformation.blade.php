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
          <input type="hidden" id="provider_id" value="{{ $providers->id}}">
          <h1 class="section__title">{{ $providers->clinic_name}}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider management</a><a class="breadcrumbs__link">{{ $providers->clinic_name }}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--viewProvider" id="js-provider-form" action="">
            <ul class="form__group form__group--viewProvider">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image" src="{{ $providers->photo_url}}" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">{{ $providers->clinic_name}}</label>
                  <span class="form__text form__text--group">
                    <input type="hidden" id="rate" value="{{ $ratings }}">
                    <div id="rateYo"></div>
                    <span class="form__text">({{$countPatient}})</span><a class="form__link form__link--gray" href="{{ route('provider.reviews', $providers->id)}}">View reviews?</a>
                  </span>
                  <span class="form__text">{{ $providers->email}}</span><span class="form__text">{{$providers->contact_number }}</span>
                </div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">Status</label><label class="form__switch" for=""> @if ($providers->is_close == 1)
                  <input class="form__trigger form__trigger--switch" type="checkbox" id="provider_information_checkbox" />
                  @else
                  <input class="form__trigger form__trigger--switch" type="checkbox" checked id="provider_information_checkbox" />
                    @endif
                  <span class="form__slider"></span></label>
                </div>
              </li>
            </ul>
            <ul class="form__group">
              <li class="form__group-item">
                <h2 class="section__heading">Clinic info</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Address</label><span class="form__text">{{ $providers->street_address}}</span>
                </div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Category</label><span class="form__text">
                @if($providers->type == '1')
                            <span>Private</span>
                            @elseif($providers->type == '2')
                            <span>Government</span>
                            @elseif($providers->type == '3')
                            <span>NGO</span>
                            @endif
                </span></div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description</label>
                  <span class="form__text">
                    {{ $providers->description }}
                  </span>
                </div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Operating hours</label>
                @foreach ($clinicHours as $hours)
                  <ul class="form__group">
                    <li class="form__group-item">
                      <span class="form__text">{{ $hours->days}}</span>
                    </li>

                    <li class="form__group-item">
                      <span class="form__text">{{ $hours->froms}} - {{ $hours->tos }}</span>
                    </li>
                  </ul>
                    
                    @endforeach
              </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Assigned staff</label>
                  @foreach($staffs as $staff)
                       <span class="form__text">{{ $staff->first_name}} {{ $staff->last_name}}</span>
                       @endforeach
                </div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Clinic gallery</h2>
                <ul class="form__gallery">
                @foreach($galleries as $gallery)
                <li class="form__gallery-item"><img class="form__gallery-image" src="{{ url(('uploads/'.$gallery->file_name)) }}" alt="Gallery image" /></li>
                @endforeach
                </ul>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Available services</label>
                  <ul class="form__group form__group--viewProviderServices">
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Modern method</h3>
                      @foreach ($modernMethod as $method)
                      <span class="form__text">{{ $method->name }}</span>
                            @endforeach
                    </li>
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Permanent method</h3>
                      @foreach ($permanentMethod as $method)
                      <span class="form__text">{{ $method->name }}</span>
                            @endforeach
                    </li>
                    <li class="form__group-item">
                      <h3 class="section__heading section__heading--sub">Natural method</h3>
                      @foreach ($naturalMethod as $method)
                      <span class="form__text">{{ $method->name }}</span>
                            @endforeach
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--start">
            <a class="button" href="{{ route('editPage',$providers->id )}}">Edit provider</a>
            <a class="button button--transparent js-trigger">Delete provider</a></div>
            <div class="modal js-modal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal__background js-modal-background"></div>
              <div class="modal__container">
                <div class="modal__box">
                  <h2 class="modal__title">Delete provider?</h2>
                  <p class="modal__text">You are about to delete this provider. Proceed?</p>
                  <div class="modal__button"><button class="button button--transparent js-modal-close">Cancel</button><a href="{{ route('deleteProvider',$providers->id )}}" class="button button--medium button--medium__delete" role="button">Delete provider</a></div>
                </div>
              </div>
            </div>
            <!-- <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            </div> -->
          </form>
          <!-- <div class="modal js-modal">
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
          </div> -->
        </div>
      </div>
@endforeach
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
