@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
<div class="sidebar">
        <div class="sidebar__logo">
          <div class="sidebar__logo-wrapper"><img class="sidebar__logo-image" src="{{URL::asset('img/logo.png')}}" alt="e-Plano Logo" /></div>
          <span class="sidebar__logo-text">e-Plano</span>
        </div>
        <div class="sidebar__container">
          <div class="sidebar__menu">
            <h3 class="sidebar__title">Controls</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="{{ route('userManagement')}}">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-user-management.png')}}" alt="User Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-user-management-white.png')}}" alt="User Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">User Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="{{ route('providerManagement')}}">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-provider-management.png')}}" alt="Provider Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-provider-management-white.png')}}" alt="Provider Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Provider Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="staff-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-staff-management.png')}}" alt="Staff Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-staff-management-white.png')}}" alt="staff Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Staff Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="patient-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-patient-management.png')}}" alt="Patient Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-patient-management-white.png')}}" alt="Patient Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Patient Management</span>
                </a>
              </li>
            </ul>
            <h3 class="sidebar__title">Content</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="{{  route('familyPlanningMethod.index')}}">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-family-planning.png')}}" alt="Family Planning Methods icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-family-planning-white.png')}}" alt="Family Planning Methods icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Family planning methods</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="{{ route('basicPages')}}">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-basic-pages.png')}}" alt="Basic Pages icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-basic-pages-white.png')}}" alt="Basic Pages icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Basic Pages</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href=".php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-events-and-pn.png')}}" alt="Events &amp; Push Notifications icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-events-and-pn-white.png')}}" alt="Events &amp; Push Notifications icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Events &amp; push notifications</span>
                </a>
              </li>
            </ul>
            <h3 class="sidebar__title">Reports</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="bookings.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-bookings.png')}}" alt="Bookings icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-bookings-white.png')}}" alt="Bookings icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Bookings</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="survey.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-survey.png')}}" alt="Survey icon for e-plano" /><img class="sidebar__icon sidebar__icon--white" src="img/icon-survey-white.png" alt="Survey icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Survey</span>
                </a>
              </li>
            </ul>
            <h3 class="sidebar__title">Others</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="ad-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-ad-management.png')}}" alt="Ad management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-ad-management-white.png')}}" alt="Ad management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Ad management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="admin-logs.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="{{URL::asset('img/icon-admin-log.png')}}" alt="Admin logs icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="{{URL::asset('img/icon-admin-log-white.png')}}" alt="Admin logs icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Admin logs</span>
                </a>
              </li>
            </ul>
          </div>
          <a class="sidebar__footer" href="my-account.php">
            <div class="sidebar__footer-content">
              <h2 class="sidebar__footer-heading">My Account</h2>
              <span class="sidebar__footer-span">Admin</span>
            </div>
            <div class="sidebar__footer-wrapper"><img class="sidebar__footer-image" src="{{ URL::asset('img/icon-arrow-right.png') }}" alt="navigation to the user profile" /></div>
          </a>
        </div>
</div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">Create user</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="user-management.php">User management</a><a class="breadcrumbs__link" href="create-user.php">Create user</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
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

          <form class="form" method="POST" action="{{ route('createAdmin' )}}">
            @csrf
            <div class="form__inline">
              <div class="form__content">
                <select class="form__input form__input--select" id="role">
                  <option disabled selected>---</option>
                  <option value="{{ route('adminFirstPage') }}">Admin</option>
                  <option value="{{ route('staffFirstPage') }}" selected>Staff</option>
                </select>
                <label class="form__label">Role*</label>
              </div>
              <div class="form__content">
                <select class="form__input form__input--search">
                @foreach ($clinics as $clinic)
                    <option value="{{ $clinic->id }}">{{ $clinic->clinic_name }}</option>
                    @endforeach
                </select>
                <label class="form__label">Provider clinic</label>
              </div>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" placeholder="First name*" name="first_name" value="{{ old('first_name')}}" /><label class="form__label">First name* </label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Last name*" name="last_name" value="{{ old('last_name')}}"/><label class="form__label">Last name* </label></div>
            </div>
            <div class="form__inline">
              <div class="form__content"><input class="form__input" type="text" placeholder="Profession (optional)" value="{{ old('professions')}}"name="professions"/><label class="form__label">Profession (optional)</label></div>
              <div class="form__content"><input class="form__input" type="text" placeholder="Training (optional)" name="trainings" value="{{ old('trainings')}}"/><label class="form__label">Training (optional)</label></div>
            </div>
            <div class="form__content"><input class="form__input" type="text" placeholder="Email Address*" name="email" value="{{ old('email')}}"/><label class="form__label">Email Address*</label></div>
            <div class="form__button form__button--end"><input type="submit" class="button" value="Create Account"></div>
          </form>
        </div>
      </div>
</div>
@endsection
