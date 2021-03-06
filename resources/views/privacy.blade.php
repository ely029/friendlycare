@extends('layouts.admin.dashboard')

@section('content')
<div class="section section--privacy">
      <div class="privacy__top">
        <div class="privacy__wrapper"><img class="privacy__image" src="{{URL::asset('img/logo.png')}}" alt="Logo of e-Plano" /></div>
        <h2 class="privacy__top-title">e-Plano</h2>
      </div>
      <div class="section__container section__container--privacy">
        <div class="privacy">
          <ul class="privacy__list">
            <li class="privacy__item">
              <h2 class="privacy__title">Who we are</h2>
              <p class="privacy__text">
                Our website address is: <a class="privacy__link" href="https://www.friendlycareclinic.com">https://www.friendlycareclinic.com </a>
                <span>
                  <br />
                  <br />
                  FriendlyCare Foundation ("us", "we", or "our") operates the E-Plano mobile application (the "Service").
                </span>
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">What personal data we collect and why we collect it</h2>
              <p class="privacy__text">
                This page informs you of our policies regarding the collection, use and disclosure of Personal Information when you use our Service.<br />
                <br />
                We will not use or share your information with anyone except as described in this Privacy Policy. <br />
                <br />
                We use your Personal Information for providing and improving the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy
                Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Information Collection And Use</h2>
              <p class="privacy__text">
                While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to, your
                email address, name, phone number, postal address, other information ("Personal Information"). We will also collect personal health information that related to our service for better management. We collect this information
                for the purpose of providing the Service, identifying and communicating with you, responding to your requests/inquiries and improving our services.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Log Data</h2>
              <p class="privacy__text">
                When you access the Service by or through a mobile device, we may collect certain information automatically, including, but not limited to, the type of mobile device you use, your mobile device unique ID, the IP address of
                your mobile device, your mobile operating system, the type of mobile Internet browser you use and other statistics ("Log Data").
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Cookies</h2>
              <p class="privacy__text">
                Cookies are files with a small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and transferred to your device. We use cookies to collect information to
                improve our services for you.<br />
                <br />
                You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. The Help feature on most browsers provide information on how to accept cookies, disable cookies or to notify you when receiving
                a new cookie. <br />
                <br />
                If you do not accept cookies, you may not be able to use some features of our Service and we recommend that you leave them turned on.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Do Not Track Disclosure</h2>
              <p class="privacy__text">
                We do not support Do Not Track ("DNT"). Do Not Track is a preference you can set in your web browser to inform websites that you do not want to be tracked.<br />
                <br />
                You can enable or disable Do Not Track by visiting the Preferences or Settings page of your web browser.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Service Providers</h2>
              <p class="privacy__text">
                We may contract third party health facilities and individuals to facilitate and or provide Service or to perform Service-related services and/or to assist us in analyzing how our Service is used.<br />
                <br />
                These third parties have access to your Personal Information only to perform specific tasks on our behalf and are obligated not to disclose or use your information for any other purpose.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Comments</h2>
              <p class="privacy__text">When visitors leave comments on the app we collect the data shown in the comments form, and also user???s IP address</p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Security</h2>
              <p class="privacy__text">
                The security of your Personal Information is important to us, and we strive to implement and maintain reasonable, commercially acceptable security procedures and practices appropriate to the nature of the information we
                store, in order to protect it from unauthorized access, destruction, use, modification, or disclosure.<br />
                <br />
                However, please be aware that no method of transmission over the internet, or method of electronic storage is 100% secure and we are unable to guarantee the absolute security of the Personal Information we have collected
                from you.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Links To Other Sites</h2>
              <p class="privacy__text">
                Our Service may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site
                you visit.<br />
                <br />
                We have no control over, and assume no responsibility for the content, privacy policies or practices of any third party sites or services.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Children's Privacy</h2>
              <p class="privacy__text">
                Only persons age 18 or older have permission to access our Service. Our Service does not address anyone under the age of 13 ("Children"). We do not knowingly collect personally identifiable information from children under
                13. If you are a parent or guardian and you learn that your Children have provided us with Personal Information, please contact us. If we become aware that we have collected Personal Information from a children under age 13
                without verification of parental consent, we take steps to remove that information from our servers.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">What rights you have over your data</h2>
              <p class="privacy__text">
                If you have an account on app or left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal
                data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Changes To This Privacy Policy</h2>
              <p class="privacy__text">
                This Privacy Policy is effective as of Jan 20, 2021 and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.<br />
                <br />
                We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Service after we post any modifications to the Privacy Policy on this
                page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy. <br />
                <br />
                If we make any material changes to this Privacy Policy, we will notify you either through the email address you have provided us, or by placing a prominent notice on our website.
              </p>
            </li>
            <li class="privacy__item">
              <h2 class="privacy__title">Contact us</h2>
              <p class="privacy__text">If you have any questions about this Privacy Policy, please contact thru our email <a class="privacy__link" href="mailto:info@friendlycare.org">info@friendlycare.org</a></p>
            </li>
          </ul>
        </div>
      </div>
    </div>
@endsection
