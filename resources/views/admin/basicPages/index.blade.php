@extends('layouts.admin.dashboard')

@section('title', 'User Management')
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
          <h1 class="section__title">Basic Pages</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="basic-pages.php">Basic Pages</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <table class="table" id="basic">
            <thead>
              <tr>
                <th class="table__head">Title</th>
                <th class="table__head">Content</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($content as $contents)
                <tr class="table__row js-view" data-href="about.php">
                <td class="table__details">About us</td>
                <td class="table__details">Sample</td>
              </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
</div>
@endsection
