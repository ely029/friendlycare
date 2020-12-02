@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">Create method</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="family-planning-methods.php">Family planning methods</a><a class="breadcrumbs__link" href="create-method.php">Create method</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form form--method" id="js-provider-form">
            <div class="form__tab">
              <ul class="form__group form__group--editMethod">
                <li class="form__group-item">
                  <h2 class="section__heading">Details</h2>
                  <ul class="form__group form__group--upload form__group--editUpload">
                    <li class="form__group-item">
                      <div class="form__wrapper"><img class="form__image form__image--method" src="img/placeholder.jpg" alt="Image placeholder" /></div>
                    </li>
                    <li class="form__group-item">
                      <div class="form__content">
                        <input class="button button--upload button--upload__method" id="js-upload" type="file" accept="image/*" name="js-upload" /><label class="form__label form__label--upload" for="js-upload">Upload a service icon </label>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="form__group-item">
                  <h2 class="section__heading">Effectiveness (in percent)</h2>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Sa tamang paggamit*" required /><label class="form__label">Sa tamang paggamit* </label></div>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Tipikal na bisa*" required /><label class="form__label">Tipikal na bisa* </label></div>
                </li>
              </ul>
              <ul class="form__group">
                <li class="form__group-item">
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Method name*" required /><label class="form__label">Method name* </label></div>
                  <div class="form__content form__content--full"><input class="form__input" type="text" placeholder="Short name*" required /><label class="form__label">Short name* </label></div>
                  <div class="form__content form__content--full">
                    <select class="form__input form__input--select"></select>
                    <label class="form__label">Category* </label>
                  </div>
                </li>
              </ul>
            </div>
            
            <div class="form__button form__button--steps">
              <button class="button"  type="button">Back</button>
              <div class="steps">
                <ul class="steps__list">
                  <li class="steps__item active"></li>
                  <li class="steps__item"></li>
                  <li class="steps__item"></li>
                </ul>
              </div>
              <button class="button"  type="button">Next</button>
            </div>
          </form>
        </div>
      </div>
<!-- <div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item active">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            hidden spacer
        </main>
        <main class="col offset-2 h-100">
        <form method="POST" action="{{ route('familyPlanningMethod.createOne')}}" enctype="multipart/form-data">
            @csrf
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Create Service</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                     <span>Details</span><br/>
                     <input type="file" name="icon"><br/><br/>
                     <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Method Name">
                     <br/></br>
                     <input type="text" name="short_name" value="{{ old('short_name') }}" class="form-control" placeholder="Short Name"><br/><br/>
                     <select name="family_plan_type_id" class="form-control">
                         <option value="">Select Method...</option>
                         <option value="1">Modern Method</option>
                         <option value="2">Permanent Method</option>
                         <option value="3">Natural Method</option>
                     </select>
                 </div>
                 <div class="col-md-6">
                 <span>Effectiveness</span><br/>
                 <br/><br/>
                     <input type="text" name="percent_effective" value="{{ old('percent_effective') }}" class="form-control" placeholder="Sa tamang paggamit"/><br/>
                     <input type="text" name="typical_validity" value="{{ old('typical_validity') }}"class="form-control" placeholder="Typikal na bisa">
                 </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-success" value="Next"/>
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
        </form>
        </main>
    </div>
</div> -->
@endsection
