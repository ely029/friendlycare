@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
<div class="section__top">
    <h1 class="section__title">Create provider</h1>
    <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('providerManagement')}}">Provider management</a><a class="breadcrumbs__link">Create Provider</a><a class="breadcrumbs__link"></a></div>
</div>
<div class="section__container">
    @if ($errors->any())

    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    @endif
    <form class="form" id="js-provider-form" method="POST" action="{{ route('storeFirstPage') }}" enctype="multipart/form-data">
        @csrf
    <div class="form__tab">
        <ul class="form__group form__group--upload">
        <li class="form__group-item">
            <div class="form__wrapper"><img class="form__image" src="{{URL::asset('img/placeholder.jpg')}}" alt="Image placeholder" /></div>
        </li>
        <li class="form__group-item">
            <div class="form__content">
            <input class="button button--upload" id="js-upload" type="file" name="pic" /><label class="form__label form__label--upload" for="js-upload">Upload a logo or a clinic photo</label>
            </div>
        </li>
        </ul>
        <div class="form__inline">
        <div class="form__content"><input class="form__input" name="clinic_name" value="{{ old('clinic_name')}}" type="text" placeholder="Provider name*" /><label class="form__label">Provider name* </label></div>
        <div class="form__content">
            <select class="form__input form__input--select" name="region" id="region">
            @for ($e = 0; $e < 15; $e++)
            <option value="{{ $region[$e]['id'] }}">{{ $region[$e]['name'] }}</option> 
            @endfor
            </select>
            <label class="form__label">Region*</label>
        </div>
        </div>
        <div class="form__inline">
        <div class="form__content"><select class="form__input form__input--select" type="text" placeholder="Category*" name="type" >
                            <option value="">Choose Category</option>
                            <option value="1">Private</option>
                            <option value="2">Government</option>
                            <option value="3">NGO</option>
        </select><label class="form__label">Category*</label></div>
        <div class="form__content">
            <select class="form__input form__input--select" id="province" name="province">

            </select>
            <label class="form__label province-label">Province*</label>
        </div>
        </div>
        <div class="form__inline">
        <div class="form__content"><input class="form__input" type="number" placeholder="Contact number*" name="contact_number" value="{{ old('contact_number')}}" /><label class="form__label">Contact number*</label></div>
        <div class="form__content">
            <select class="form__input form__input--select" id="city" name="city"></select>
            <label class="form__label">City*</label>
        </div>
        </div>
        <div class="form__inline">
        <div class="form__content"><input class="form__input" type="email" name="email" placeholder="Email Address*" value="{{ old('email')}}" /><label class="form__label">Email Address*</label></div>
        <div class="form__content">
            <select class="form__input form__input--select" id="barangay" name="barangay"></select>
            <label class="form__label barangay-label">Barangay*</label>
        </div>
        </div>
        <div class="form__content form__content--full"><input class="form__input" type="text" name="street_address" value="{{ old('street_address')}}" placeholder="Street address*" /><label class="form__label">Street address*</label></div>
        <div class="form__content form__content--full"><textarea class="form__input form__input--message" name="description"  placeholder="Clinic description (optional)">{{ old('description')}} </textarea><label class="form__label">Clinic description (optional)</label></div>
        <div class="form__content">
        <div class="form__content form__content--row">
            <label class="form__sublabel">Yes<input class="form__trigger" type="radio" name="philhealth_accredited_1" value="1" checked /><span class="form__radio"></span></label>
            <label class="form__sublabel">No<input class="form__trigger" type="radio" name="philhealth_accredited_1" value="0" /><span class="form__radio"></span></label>
        </div>
        <label class="form__label form__label--blue" for="philhealth-accredited">Are you Philhealth accredited? </label>
        </div>
    </div>
    <div class="form__button form__button--steps">
        <a class="button" href="">Back</a>
        <div class="steps">
        <ul class="steps__list">
            <li class="steps__item active"></li>
            <li class="steps__item"></li>
            <li class="steps__item"></li>
        </ul>
        </div>
        <a class="button" href="">Next</a>
    </div>
    </form>
</div>
</div>
<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">

            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item active">Basic Pages</a>
            </div>

        </aside>
        <main class="col-10 invisible">
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
            <form method="POST" action="{{ route('storeFirstPage') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                     <div class="col-md-12">
                         <span>Profile Icon</span>
                         <input type="file" name="pic"/>
                     </div>
                </div>
            <div class="row">
                 <div class="col-md-4">
                    <input type="text" value="{{ old('clinic_name') }}" name="clinic_name" class="form-control" placeholder="Provider name">
                </div>
                <div class="col-md-4">
                    <input type="text" name="province" value="{{ old('clinic_name')}}" id="province" class="form-control" placeholder="Province">
                                    </div>
                <div class="col-md-4">        
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <select name="type" class="form-control">
                            <option value="1">Private</option>
                            <option value="2">Government</option>
                            <option value="3">NGO</option>
                        </select>
                </div>
                <div class="col-md-4">
                        <input type="text" class="form-control" value="{{ old('city') }}" id="city" name="city" placeholder="City">
                </div>   
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" maxlength="14" placeholder="Contact Number">
                </div>
                <div class="col-md-4">
                <input type="text" class="form-control" valu="{{ old('municipality') }}" name="municipality" placeholder="Municipality">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <input type="email" name="email" value=" {{ old('email') }}"class="form-control" placeholder="Email Address">
                </div>
                <div class="col-md-4">
                       <input type="text" name="description" value="{{ old('description') }}"class="form-control" placeholder="Description">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <input type="text" class="form-control" name="address" value="{{ old('address') }}"placeholder="Street Address"><br/>
                <span>Is this philhealth accredited?</span><br/>
                <input type="radio" name="philhealth_accredited_1" value="1" checked>Yes</br>
                <input type="radio" name="philhealth_accredited_1" value="0">No
                </div>
                <div class="col-md-4">
                    <input type="submit" value="Next" class="btn btn-info">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
             <div class="col-md-12">
             @if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif
             </div>
            </div>
        </form>
            
        </main>
    </div>

</div> -->
@endsection
