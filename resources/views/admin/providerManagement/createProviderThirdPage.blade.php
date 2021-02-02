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
    <form class="form"  method="POST" action="{{ route('storeThirdPage') }}">
    @csrf
    <div class="form__tab">
        <h2 class="section__heading">Available services</h2>
        <ul class="form__group form__group--viewProviderServices">
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Modern method</h3>
            @foreach ($modernMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="available_service[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Permanent method</h3>
            @foreach ($permanentMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="available_service[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        <li class="form__group-item">
            <h3 class="section__heading section__heading--sub">Natural method</h3>
            @foreach ($naturalMethod as $method)
            <label class="form__sublabel form__sublabel--services">{{ $method->name }}<input class="form__trigger" type="checkbox" name="available_service[]" value="{{ $method->id }}" /><span class="form__checkmark"></span></label>
            @endforeach
        </li>
        </ul>
        <div class="form__content form__content--reverse">
            <label class="form__label form__label--blue" for="paid-services">Do you have paid services?</label>
                <div class="form__content form__content--row" id="js-paid-services">
                  <label class="form__sublabel">Yes<input class="form__trigger" id="js-yes-paid" type="radio" name="paid" checked="checked" value="1"/><span class="form__radio"></span></label>
                  <label class="form__sublabel">No<input class="form__trigger" id="js-no-paid" type="radio" name="paid" value="0" /><span class="form__radio"></span></label>
                </div>

                <div class="form__content form__content--reverse form__content--full" id="js-services-content">
                <h2 class="section__heading section__heading--margin">Which of your services are paid?</h2>
                <ul class="form__group form__group--viewProviderServices">
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Modern method</h3>
                    @foreach($modernMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="paid_services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach
                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Permanent method</h3>
                    @foreach($permanentMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="paid_services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach

                  </li>
                  <li class="form__group-item">
                    <h3 class="section__heading section__heading--sub">Natural method</h3>
                    @foreach($naturalMethod as $method)
                  <label class="form__sublabel form__sublabel--services">{{ $method->name}}<input class="form__trigger" type="checkbox" name="paid_services[]" value="{{$method->id}}" /><span class="form__checkmark"></span></label>
                  @endforeach

                  </li>
                </ul>
              </div>
              </div>
              
    </div>
    <div class="form__button form__button--steps">
        <button class="button button--back" id="back-provider-page" >Back</button>
        <div class="steps">
        <ul class="steps__list">
            <li class="steps__item "></li>
            <li class="steps__item"></li>
            <li class="steps__item active"></li>
        </ul>
        </div>
        <button class="button" type="submit">Next</button>
    </div>
    </form>
</div>
</div>
@endsection
