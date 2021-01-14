<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!-- If you delete this meta tag, the ground will open and swallow you. -->
    <meta name="viewport" content="width=device-width"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/app/css/main.css') }}" rel="stylesheet">
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">



<!-- xandy -->
<div class="email">
      <div class="email__header">
        <div class="email__header-title">
          <h2>e-Plano</h2>
          <span class="email__header__span">Family Planning Informational &amp; Booking App</span>
        </div>
        <div class="email__header-wrapper"><img class="email__image" src="{{URL::asset('img/logo-outline.png')}}" alt="logo of e-plano" /></div>
      </div>
      <div class="email__content">
        <h2 class="email__title">Hi </h2>
        <p class="email__text">
          Patient {{ $name }} made a cancellation request on his/her consultation appointment with your clinic dated {{ $date }}. <br><br>
          You can also check on your FriendlyCare provider app for the details of the cancelled booking request. Thank you.

        </p>
      </div>
      <div class="email__bottom">
        <div class="email__bottom-container"></div>
        <p class="email__bottom-text">
          For more information, you can send an email to: <a class="email__bottom-link" href="mailto:info@friendlycare.org">info@friendlycare.org </a><span>or contact our office hotlines (+632) 722-2968 | (+632) 722-5205</span>
        </p>
      </div>
      <div class="email__footer">
        <div class="email__footer-top">
          <div class="email__footer-wrapper"><img class="email__image" src="{{URL::asset('img/logo-white.png')}}" alt="white logo of e-plano" /></div>
          <h2 class="email__footer-text">e-Plano</h2>
        </div>
        <ul class="email__footer-links">
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-facebook.png')}}" alt="facebook icon" /></a>
          </li>
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-twitter.png')}}" alt="twitter icon" /></a>
          </li>
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-ig.png')}}" alt="ig icon" /></a>
          </li>
        </ul>
      </div>
    </div>

    </body>
</html>