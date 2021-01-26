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
    <style>
      @font-face {
        font-family: VAGRounded BT;
        font-display: auto;
        src: "{{ asset('assets/app/css/fonts/VAGRoundedBT.eot') }}";
        src: local("☺"), "{{ asset('assets/app/css/fonts/VAGRoundedBT.ttf') }}" format("ttf"), "{{ asset('assets/app/css/fonts/VAGRoundedBT.eot?#iefix') }}" format("embedded-opentype"), "{{ asset('assets/app/css/fonts/VAGRoundedBT.woff') }}" format("woff");
      }
      .email * {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
      }
      .email__header {
        background-color: #911aa2;
        width: 100%;
        text-align: center;
        color: #fff;
        font-family: "VAGRounded BT";
        padding: 80px 290px;
      }
      .email__header-title {
        width: 230px;
        margin: 0 auto 25px;
      }
      .email__header-span {
        margin-top: 10px;
      }
      .email__header-wrapper {
        width: 219px;
        height: 190px;
        margin: 0 auto;
      }
      .email__footer {
        background-color: #b964c4;
        padding: 80px 290px;
        font-family: "VAGRounded BT";
        color: #fff;
      }
      .email__footer-links {
        width: 100%;
        margin: 0 auto;
        text-align: center;
        padding: 0;
      }
      .email__footer-item {
        display: inline-block;
        width: 35px;
        height: 35px;
      }
      .email__footer-wrapper {
        width: 86px;
        height: 74px;
        display: inline-block;
        vertical-align: middle;
      }
      .email__footer-top {
        margin: 0 auto 40px;
        width: 255px;
        position: relative;
      }
      .email__footer-text {
        position: absolute;
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 38px;
        display: inline-block;
        margin: 0 0 0 3vh;
        vertical-align: middle;
      }
      .email__bottom {
        background-color: #f2f2f2;
        padding: 70px 130px;
        font-family: "Open Sans", sans-serif;
      }
      .email__bottom-text {
        color: #00375e;
        font-size: 24px;
        margin-bottom: 20px;
      }
      .email__bottom-link {
        color: #b964c4;
        -webkit-transition: 0.4s;
        -o-transition: 0.4s;
        transition: 0.4s;
      }
      .email__bottom-link:hover {
        color: #6e1a7b;
      }
      .email__content {
        padding: 100px 130px;
        font-family: "Open Sans", sans-serif;
      }
      .email__title {
        color: #911aa2;
        font-size: 24px;
      }
      .email__text {
        color: #000;
        font-size: 20px;
        margin-top: 30px;
      }
      .email__image {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
      }
      .email__link {
        width: 100%;
        text-align: center;
        color: #b964c4;
        -webkit-transition: 0.4s;
        -o-transition: 0.4s;
        transition: 0.4s;
        display: block;
        margin: 70px auto 0;
        font-size: 20px;
      }
      .email__link:hover {
        color: #6e1a7b;
      }
    </style>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<!-- xandy -->
<div class="email">
      <div class="email__header">
        <div class="email__header-title">
          <h2>e-Plano</h2>
          <span class="email__header__span">Family Planning Informational &amp; Booking App</span>
        </div>
        <div class="email__header-wrapper"><img class="email__image" src="src/img/logo-outline.png" alt="logo of e-plano" /></div>
      </div>
      <div class="email__content">
        <h2 class="email__title">Hi!</h2>
        <p class="email__text">
          Here are the upcoming bookings.
          @foreach($details as $detail)
          <ul>
              <li>Patient Name: {{ $detail->patient_name}}</li>
              <li> Date: {{ $detail->date_booked }}</li>
              <li>Service: {{ $detail->service_name }}</li>
          </ul>
          @endforeach
        </p>
      </div>
      <div class="email__bottom">
        <div class="email__bottom-container"></div>
        <p class="email__bottom-text">
          For more information, you can send an email to: <a class="email__bottom-link" href="mailto:info@friendlycare.org">info@friendlycare.org</a><span> or contact our office hotlines (+632) 722-2968 | (+632) 722-5205</span>
        </p>
      </div>
      <div class="email__footer">
        <div class="email__footer-top">
          <div class="email__footer-wrapper"><img class="email__image" src="{{URL::asset('img/logo-white.png')}}" alt="white logo of e-plano" /></div>
          <h2 class="email__footer-text">e-Plano</h2>
        </div>
        <ul class="email__footer-links">
          <li class="email__footer-item" style="margin-right: 20px;">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-facebook.png')}}" alt="facebook icon" /></a>
          </li>
          <li class="email__footer-item" style="margin-right: 20px;">
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