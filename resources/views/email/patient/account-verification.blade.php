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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="box-sizing: border-box;">


<!-- xandy -->
<div class="email">
      <div class="email__header" style="background-color: #911aa2;
        width: 100%;
        text-align: center;
        color: #fff;
        font-family: Arial;
        padding: 80px 290px;">
        <div class="email__header-title" style="width: 230px;
        margin: 0 auto 25px;">
          <h2>e-Plano</h2>
          <span class="email__header__span" style="margin-top: 10px;">Family Planning Informational &amp; Booking App</span>
        </div>
        <div class="email__header-wrapper" style="width: 219px;
        height: 190px;
        margin: 0 auto;"><img style="width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;" class="email__image" src="{{URL::asset('img/logo.png')}}" alt="logo of e-plano" /></div>
      </div>
      <div class="email__content" style="padding: 100px 130px;
        font-family: 'Open Sans', sans-serif;">
        <h2 class="email__title" style="color: #911aa2;
        font-size: 24px;">Hi </h2>
        <p class="email__text" style="color: #000;
        font-size: 20px;
        margin-top: 30px;">
          Your FriendlyCare account is used today during app login, [Current date here]. Was this you? If so, you can safely delete this email. 
 <br />
          <br />
          If this wasn’t you, we advise resetting the password of your account using the link below.
        </p>
      </div>
      <div class="email__bottom" style="background-color: #f2f2f2;
        padding: 70px 130px;
        font-family: 'Open Sans', sans-serif;">
        <div class="email__bottom-container"></div>
        <p class="email__bottom-text" style="color: #00375e;
        font-size: 24px;
        margin-bottom: 20px;">
          For more information, you can send an email to: <a class="email__bottom-link" style="color: #b964c4;
        -webkit-transition: 0.4s;
        -o-transition: 0.4s;
        transition: 0.4s;" href="mailto:info@friendlycare.org">info@friendlycare.org</a><span> or contact our office hotlines (+632) 722-2968 | (+632) 722-5205</span>
        </p>

        <a class="email__link" href="{{ route('resetPassword.index',$id)}}" style="width: 100%;
        text-align: center;
        color: #b964c4;
        -webkit-transition: 0.4s;
        -o-transition: 0.4s;
        transition: 0.4s;
        display: block;
        margin: 70px auto 0;
        font-size: 20px;">Click link here</a>
      </div>
      <div class="email__footer" style="background-color: #b964c4;
        padding: 80px 290px;
        font-family: Arial;
        color: #fff;">
        <div class="email__footer-top" style="margin: 0 auto 40px;
        width: 255px;
        position: relative;">
          <div class="email__footer-wrapper" style="width: 86px;
        height: 74px;
        display: inline-block;
        vertical-align: middle;"><img style="width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;" class="email__image" src="{{URL::asset('img/logo-white.png')}}" alt="white logo of e-plano" /></div>
          <h2 class="email__footer-text" style="position: absolute;
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
        vertical-align: middle;">e-Plano</h2>
        </div>
        <!-- <ul class="email__footer-links">
          <li class="email__footer-item" style="margin-right: 20px;">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-facebook.png')}}" alt="facebook icon" /></a>
          </li>
          <li class="email__footer-item" style="margin-right: 20px;">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-twitter.png')}}" alt="twitter icon" /></a>
          </li>
          <li class="email__footer-item">
            <a href=""><img class="email__image" src="{{URL::asset('img/icon-ig.png')}}" alt="ig icon" /></a>
          </li>
        </ul> -->
      </div>
    </div>
</body>
</html>
