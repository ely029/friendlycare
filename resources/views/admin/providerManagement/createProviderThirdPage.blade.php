@extends('layouts.admin.dashboard')

@section('title', 'Provider Management')
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
    <form class="form" id="js-provider-form" method="POST" action="{{ route('storeThirdPage') }}">
    @csrf
    <div class="form__tab">
        <h2 class="section__heading">Available services</h2>
        <ul class="form__group form__group--createProviderServices">
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Modern method</h3>
            @foreach ($modernMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="modern[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Permanent method</h3>
            @foreach ($permanentMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="modern[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Natural method</h3>
            @foreach ($naturalMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="modern[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        </ul>
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
    <div class="form__button form__button--steps">
        <button class="button" >Back</button>
        <div class="steps">
        <ul class="steps__list">
            <li class="steps__item active"></li>
            <li class="steps__item"></li>
            <li class="steps__item"></li>
        </ul>
        </div>
        <button class="button" type="submit">Next</button>
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
            <form method="POST" action="{{ route('storeThirdPage') }}">
                @csrf
            <div class="row">
                   <div class="col-md-12">
                       <h5>Modern Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($modernMethod as $method)
                    <input type="checkbox" name="modern[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
                   <div class="col-md-12">
                       <h5>Permanent Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($permanentMethod as $method)
                    <input type="checkbox" name="permanent[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
                   <div class="col-md-12">
                       <h5>Natural Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($naturalMethod as $method)
                    <input type="checkbox" name="natural[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
            </div>
            <div class="row">
            </div>
            <div class="row">
            </div>
            <div class="row">
                 <div class="col-md-12">
                     <span>Do you have paid services?</span><br/>
                     <span><input type="radio" name="paid" value="1">Yes&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="paid" value="0" checked>No</span>
                 </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               <h4>Modern Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($modernMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                   <span></span>
               <h4>Natural Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($naturalMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               <h4>Permanent Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($permanentMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row h-100">
                  <div class="col-md-12">
                      <input type="submit" value="Next" class="btn btn-success">
                  </div>
            </div>
            </form>       
        </main>
    </div>
</div> -->
@endsection
