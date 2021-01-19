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
    <form class="form" id="js-provider-form" method="POST" action="{{ route('storeSecondPage')}}">
     @csrf
    <div class="form__tab">
        <ul class="form__group">
        <li class="form__group-item">
            <h2 class="section__heading">Clinic gallery</h2>
            <div class="dz-default dz-message dropzoneDragArea" id="dropzoneDragArea1"><span>Upload File</span></div>
            <input type="hidden" name="id" id="id" value="{{ session()->get('id') }}"/>
            <div class="dropzone-previews"></div>
        </li>
        <li class="form__group-item">
            <h2 class="section__heading">Clinic hours</h2>
            <ul class="form__group form__group--schedule">
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="days[]" value="sunday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">M<input class="form__trigger" type="checkbox" name="days[]" value="monday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" type="checkbox" name="days[]" value="tuesday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">W<input class="form__trigger" type="checkbox" name="days[]" value="wednesday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">T<input class="form__trigger" type="checkbox" name="days[]" value="thursday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">F<input class="form__trigger" type="checkbox" name="days[]" value="friday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            <li class="form__group-item">
                <label class="form__sublabel form__sublabel--day">S<input class="form__trigger" type="checkbox" name="days[]" value="saturday" /><span class="form__checkmark"></span></label>
                <input class="form__input" name="from[]" type="time" placeholder="opening time" />
                <input class="form__input" name="to[]" type="time" placeholder="closing time" />
            </li>
            </ul>
        </li>
        </ul>
    </div>

    <div class="form__button form__button--steps">
    <a class="button" href="{{ url()->previous() }}">Back</a>
        <div class="steps">
        <ul class="steps__list">
            <li class="steps__item"></li>
            <li class="steps__item active"></li>
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
            <form method="POST" action="{{ route('storeSecondPage')}}" enctype="multipart/form-data">
                @csrf
            <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id" id="id" value="{{ session()->get('id') }}"/>
                  </div>
            </div>  
            <div class="row">
                <input type="file" name="files[]" multiple/>
            </div>  
            <div class="row">
                
            </div> 
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Sunday</span>
                    <input checked type="checkbox" name="days[]" value="sunday">
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
                    <input checked type="checkbox" name="days[]" value="monday">
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
                    <input checked type="checkbox" name="days[]" value="tuesday">
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
                    <input checked type="checkbox" name="days[]" value="wednesday">
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
                    <input checked type="checkbox" name="days[]" value="thursday">
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
                    <input checked type="checkbox" name="days[]" value="friday">
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
                    <input checked type="checkbox" name="days[]" value="saturday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div> 
            <div class="row">
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-success" value="Next">                    
                  </div>
            </div>
            </form>           
        </main>
    </div>
</div> -->
@endsection
