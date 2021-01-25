@extends('layouts.admin.dashboard')

@section('content')
<!-- create password -->
<div class="login">
    <div class="login__container login__container--password">
    <div class="login__top">
        <div class="login__wrapper"><img class="login__image" src="{{URL::asset('img/logo.png')}}" alt="Logo of e-Plano" /></div>
        <div class="login__title">
        <h2 class="login__text">e-Plano</h2>
        <span class="login__span">
            Family Planning Informational <br />
            &amp; Booking App
        </span>
        </div>
    </div>
    <div class="login__content">
        <div class="login__card">
        <h2 class="section__heading">Welcome!</h2>
        <p class="login__details">e-Plano has created an account for you. Please create a password to complete the process (Minimum of 8 characters).</p>
        <form class="form form--login" action="{{ route('password.readyPassword')}}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{ $id }}">
            <div class="form__content"><input class="form__input" name="password" id="js-password" type="password" placeholder="Enter password" /><label class="form__label">Enter password</label><i class="fa fa-eye-slash" id="js-eye-password"></i></div>
            <div class="form__content"><input class="form__input" name="password_confirmation" id="js-confirm-password" type="password" placeholder="Confirm password" /><label class="form__label">Confirm password</label><i class="fa fa-eye-slash" id="js-eye-confirm-password"></i></div>
            <div class="form__button"><input class="button" type="submit" value="Create Account"/></div>
        </form>
        </div>
        <div class="login__card">
        <h2 class="section__heading">Account details</h2>
        <form class="form form--login">
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Email</label><span class="form__text">johnsmith@gmail.com</span></div>
            <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Provider clinic</label><span class="form__text">Shaw Clinic</span></div>
        </form>
        </div>
    </div>
    </div>
</div>

<!-- reset password -->
<div class="login login--success">
    <div class="login__container login__container--password">
    <div class="login__top">
        <div class="login__wrapper"><img class="login__image" src="{{URL::asset('img/logo.png')}}" alt="Logo of e-Plano" /></div>
        <div class="login__title">
        <h2 class="login__text">e-Plano</h2>
        <span class="login__span">
            Family Planning Informational <br />
            &amp; Booking App
        </span>
        </div>
    </div>
    <div class="login__card">
        <h2 class="section__heading">Password reset</h2>
        <p class="login__details">Enter your new password (Minimum of 8 characters).</p>
        <form class="form form--login" action="{{ route('password.readyPassword')}}">
        <div class="form__content"><input class="form__input" name="password" id="js-password" type="password" placeholder="Enter password" /><label class="form__label">Enter password</label><i class="fa fa-eye-slash" id="js-eye-password"></i></div>
        <div class="form__content"><input class="form__input" name="password_confirmation" id="js-confirm-password" type="password" placeholder="Confirm password" /><label class="form__label">Confirm password</label><i class="fa fa-eye-slash" id="js-eye-confirm-password"></i></div>
        <div class="form__button"><input type="submit" class="button" value="Create account"></div>
        </form>
    </div>
    </div>
</div>

<!-- email for password reset -->
<div class="email">
      <div class="email__header">
        <div class="email__header-title">
          <h2>e-Plano</h2>
          <span class="email__header__span">Family Planning Informational &amp; Booking App</span>
        </div>
        <div class="email__header-wrapper"><img class="email__image" src="src/img/logo.png" alt="logo of e-plano" /></div>
      </div>
      <div class="email__content">
        <h2 class="email__title">Hi </h2>
        <p class="email__text">
          We have received a request to reset your password for your FriendlyCare account. <br />
          <br />
          Please use the link below to reset the password for your account. If you did not request to reset your password, you can safely delete this email.
        </p>
        <a class="email__link" href="">Click link here</a>
      </div>
      <div class="email__bottom">
        <div class="email__bottom-container"></div>
        <p class="email__bottom-text">
          For more information, you can send an email to: <a class="email__bottom-link" href="mailto:info@friendlycare.org">info@friendlycare.org </a><span>or contact our office hotlines (+632) 722-2968 | (+632) 722-5205</span>
        </p>
      </div>
      <div class="email__footer">
        <div class="email__footer-top">
          <div class="email__footer-wrapper"><img class="email__image" src="src/img/logo.png" alt="white logo of e-plano" /></div>
          <h2 class="email__footer-text">e-Plano</h2>
        </div>
        <ul class="email__footer-links">
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="src/img/icon-facebook.png" alt="facebook icon" /></a>
          </li>
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="src/img/icon-twitter.png" alt="twitter icon" /></a>
          </li>
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="src/img/icon-ig.png" alt="ig icon" /></a>
          </li>
        </ul>
      </div>
    </div>


<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.readyPassword')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                             
                            <div class="col-md-6">
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                  <input type="hidden" name="id" value="{{ $id }}">
                                 
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
