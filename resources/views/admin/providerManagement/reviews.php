<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FriendlyCare Cubao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta property="og:image" content="img/logo.png" />
    <meta name="theme-color" content="#186031" />
    <meta name="description" content="" />
    <link rel="icon" href="img/logo.png" />
    <link rel="apple-touch-icon" href="img/logo.png" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css" />
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/dropzone/dist/dropzone.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="sidebar">
        <div class="sidebar__logo">
          <div class="sidebar__logo-wrapper"><img class="sidebar__logo-image" src="img/logo.png" alt="e-Plano Logo" /></div>
          <span class="sidebar__logo-text">e-Plano</span>
        </div>
        <div class="sidebar__container">
          <div class="sidebar__menu">
            <h3 class="sidebar__title">Controls</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="user-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-user-management.png" alt="User Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-user-management-white.png" alt="User Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">User Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="provider-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-provider-management.png" alt="Provider Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-provider-management-white.png" alt="Provider Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Provider Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="staff-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-staff-management.png" alt="Staff Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-staff-management-white.png" alt="staff Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Staff Management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="patient-management.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-patient-management.png" alt="Patient Management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-patient-management-white.png" alt="Patient Management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Patient Management</span>
                </a>
              </li>
            </ul>
            <h3 class="sidebar__title">Content</h3>
            <ul class="sidebar__list">
              <li class="sidebar__item">
                <a class="sidebar__link" href="family-planning-methods.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-family-planning.png" alt="Family Planning Methods icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-family-planning-white.png" alt="Family Planning Methods icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Family planning methods</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="basic-pages.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-basic-pages.png" alt="Basic Pages icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-basic-pages-white.png" alt="Basic Pages icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Basic Pages</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href=".php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-events-and-pn.png" alt="Events &amp; Push Notifications icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-events-and-pn-white.png" alt="Events &amp; Push Notifications icon on hover for e-plano" />
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
                    <img class="sidebar__icon" src="img/icon-bookings.png" alt="Bookings icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-bookings-white.png" alt="Bookings icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Bookings</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="survey.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-survey.png" alt="Survey icon for e-plano" /><img class="sidebar__icon sidebar__icon--white" src="img/icon-survey-white.png" alt="Survey icon on hover for e-plano" />
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
                    <img class="sidebar__icon" src="img/icon-ad-management.png" alt="Ad management icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-ad-management-white.png" alt="Ad management icon on hover for e-plano" />
                  </div>
                  <span class="sidebar__text">Ad management</span>
                </a>
              </li>
              <li class="sidebar__item">
                <a class="sidebar__link" href="admin-logs.php">
                  <div class="sidebar__wrapper">
                    <img class="sidebar__icon" src="img/icon-admin-log.png" alt="Admin logs icon for e-plano" />
                    <img class="sidebar__icon sidebar__icon--white" src="img/icon-admin-log-white.png" alt="Admin logs icon on hover for e-plano" />
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
            <div class="sidebar__footer-wrapper"><img class="sidebar__footer-image" src="img/icon-arrow-right.png" alt="navigation to the user profile" /></div>
          </a>
        </div>
      </div>
      <div class="section">
        <div class="section__top">
          <h1 class="section__title">FriendlyCare Cubao</h1>
          <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="provider-management.php">Provider management</a><a class="breadcrumbs__link" href="view-provider.php">FriendlyCare Cubao</a><a class="breadcrumbs__link" href="reviews.php">Reviews</a>
          </div>
        </div>
        <div class="section__container">
          <form class="form form--viewProvider" id="js-provider-form" action="">
            <ul class="form__group form__group--viewProvider">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image" src="img/placeholder.jpg" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--blue">FriendlyCare Cubao</label>
                  <span class="form__text form__text--group">
                    <div id="rateYo"></div>
                    <span class="form__text">(17)</span><a class="form__link form__link--gray" href="">View reviews?</a>
                  </span>
                  <span class="form__text">friendlycarecubao@friendlycare.com</span><span class="form__text">09857754852</span>
                </div>
              </li>
            </ul>
          </form>
          <form class="form" action="">
            <h2 class="section__heading">User reviews</h2>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">John Smith</label>
              <div id="rateYo"></div>
              <span class="form__text">Maayos at naintindihan ko lahat ng recommendation ni doc. Mabait po at malaki ang tulong sa amin.</span>
            </div>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">Elizabeth Townsend</label>
              <div id="rateYo"></div>
              <span class="form__text">Doctor was a bit inpatient. Felt like rushing me through the consultation. I got what i needed though.</span>
            </div>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">Kristine Dimagiba</label>
              <div id="rateYo"></div>
              <span class="form__text">Pagdating ko, nag hintay pa ako ng isang oras bago makapag-kunsulta</span>
            </div>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">MJ Valenciano</label>
              <div id="rateYo"></div>
              <span class="form__text">Maayos at naintindihan ko lahat ng recommendation ni doc. Mabait po at malaki ang tulong sa amin.</span>
            </div>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">John Smith</label>
              <div id="rateYo"></div>
              <span class="form__text">Maayos at naintindihan ko lahat ng recommendation ni doc. Mabait po at malaki ang tulong sa amin.</span>
            </div>
            <div class="form__content form__content--reverse">
              <label class="form__label form__label--blue">Elizabeth Townsend</label>
              <div id="rateYo"></div>
              <span class="form__text">Doctor was a bit inpatient. Felt like rushing me through the consultation. I got what i needed though.</span>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
    <script src="https://cdn.tiny.cloud/1/yjtil7vjw9cus6nrlnbphyor2ey71lojenzvv4yqmy0luh43/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="js/dropzone/dist/dropzone.js"></script>
  </body>
</html>
