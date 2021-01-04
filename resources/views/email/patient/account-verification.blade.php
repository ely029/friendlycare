<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!-- If you delete this meta tag, the ground will open and swallow you. -->
    <meta name="viewport" content="width=device-width"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table class="head-wrap" style="overflow: hidden;">
    <tr class="container">
        <td class="container" >
            <!-- content -->
            <div class="content" style="padding: 35px 15px 15px">
                <table>
                    <tr style="font-size:15px;">
                        <td width="10px"></td>
                        <td align="center">
                            <span style="padding:0 50px 10px; display: block; font-size: 25px; line-height: 1.8;">
                            @foreach ($users as $user)
                            Hi Sir/Ma'am ! <br>
                                <br><br>
                                This email is for your security for stealing your account. 
                                <br/>
                                <br/>
                                If you are not logged in here, Please Click <a href=" {{ route('resetPassword.index',$user->id)}}">Here</a> to reset your password
                            @endforeach
                                
                            </span>
                            <br>
                    
                            <br>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
    </tr>
</table>
</body>
</html>


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
        <h2 class="email__title">Hi [First name]</h2>
        <p class="email__text">
        Your FriendlyCare account is used today during app login, [Current date here]. Was this you? If so, you can safely delete this email. 
 <br />
          <br />
          If this wasn’t you, we advise resetting the password of your account using the link below.
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