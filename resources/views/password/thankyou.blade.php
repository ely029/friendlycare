@extends('layouts.admin.dashboard')

@section('content')
<!-- password creation success -->
<div class="login login--success">
    <div class="login__container login__container--password">
    <div class="login__top">
        <div class="login__wrapper"><img class="login__image" src="img/logo.png" alt="Logo of e-Plano" /></div>
        <div class="login__title">
        <h2 class="login__text">e-Plano</h2>
        <span class="login__span">
            Family Planning Informational <br />
            &amp; Booking App
        </span>
        </div>
    </div>
    <div class="login__card">
        <h2 class="section__heading">Success!</h2>
        <p class="login__details">
        You may now use your email and password to access and manage your clinic. <br />
        <br />
        Download the app to get started.
        </p>
    </div>
    </div>
</div>

<!-- resetting password success -->

<div class="login login--success">
    <div class="login__container login__container--password">
    <div class="login__top">
        <div class="login__wrapper"><img class="login__image" src="img/logo.png" alt="Logo of e-Plano" /></div>
        <div class="login__title">
        <h2 class="login__text">e-Plano</h2>
        <span class="login__span">
            Family Planning Informational <br />
            &amp; Booking App
        </span>
        </div>
    </div>
    <div class="login__card">
        <h2 class="section__heading">Success!</h2>
        <p class="login__details">Password has been reset.</p>
    </div>
    </div>
</div>
@endsection

<!-- Your password are now updated <a href="{{ route('index') }}">Click Here</a> -->