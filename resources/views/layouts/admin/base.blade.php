<!doctype html>

{{-- Language attribute --}}
{{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#language-attribute --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- The order of the <title> and <meta> tags --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#the-order-of-the-title-and-meta-tags --}}
    <meta charset="utf-8">

    {{-- Based on https://medium.com/ title format --}}
    <title>
        @hasSection('title')
        @yield('title') – {{ config('app.name') }}
        @else
        {{ config('app.name') }}
        @endif
    </title>

    {{-- Meta Description --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#meta-description --}}
    <meta name="description" content="@yield('description', config('boilerplate.description'))">

    {{-- Mobile Viewport --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#mobile-viewport --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Smart App Banners in iOS 6+ Safari --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#smart-app-banners-in-ios-6-safari --}}
    @if($itunesAppId = config('boilerplate.itunes_app_id'))
    <meta name="apple-itunes-app" content="app-id={{ $itunesAppId }}">
    @endif

    {{-- Name the Pinned Site for Windows --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#name-the-pinned-site-for-windows --}}
    <meta name="application-name" content="{{ config('app.name') }}">

    {{-- Give your Pinned Site a tooltip --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#give-your-pinned-site-a-tooltip --}}
    <meta name="msapplication-tooltip" content="{{ config('boilerplate.description') }}">

    {{-- Set a default page for your Pinned Site --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#set-a-default-page-for-your-pinned-site --}}
    <meta name="msapplication-starturl" content="{{ config('app.url') }}">

    {{-- Facebook Open Graph data --}}
    {{-- https://developers.facebook.com/docs/sharing/webmasters --}}
    {{-- https://developers.facebook.com/tools/debug/ --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#facebook-open-graph-data --}}
    @if($facebookAppId = config('boilerplate.facebook_app_id'))
    <meta property="fb:app_id" content="{{ $facebookAppId }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="{{ config('app.locale', config('app.fallback_locale')) }}">

    {{-- Twitter Cards --}}
    {{-- https://dev.twitter.com/cards/overview --}}
    {{-- https://cards-dev.twitter.com/validator --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#twitter-cards --}}
    @if($twitterSiteId = config('boilerplate.twitter_site_id'))
    <meta name="twitter:site:id" content="{{ $twitterSiteId }}">
    @endif
    <meta name="twitter:card" content="summary">

    {{-- Facebook & Twitter Commons --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', config('boilerplate.description'))">
    <meta property="og:image" content="@yield('image', asset('apple-touch-icon.png'))">

    {{-- Theme Color --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#theme-color --}}
    <meta name="theme-color" content="#fafafa">

    {{-- CSRF Protection --}}
    {{-- See VerifyCsrfToken.php --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https://fonts.googleapis.com;">
    {{-- Google Analytics --}}
    @if($googleAnalyticsTrackingId = config('boilerplate.google_analytics_tracking_id'))
        <meta name="google_analytics_tracking_id" content="{{ $googleAnalyticsTrackingId }}">
    @endif

    {{-- Web App Manifest --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#web-app-manifest --}}
    {{-- Note: Don't forget to modify theme-color meta tag. --}}
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Favicons and Touch Icon --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/html.md#favicons-and-touch-icon --}}
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    {{-- Place favicon.ico in the root directory --}}

    {{-- Humans TXT --}}
    {{-- http://humanstxt.org/Standard.html --}}
    <link rel="author" href="{{ asset('humans.txt') }}">

    {{-- Canonical URL --}}
    {{-- https://github.com/h5bp/html5-boilerplate/blob/v7.3.0/dist/doc/extend.md#canonical-url --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Styles --}}
    @stack('styles')
</head>

<body>
    <!--[if IE]>
        <div class="container pt-3">
            <div class="alert alert-warning text-center" role="alert">@lang('boilerplate.outdated')</div>
        </div>
    <![endif]-->



    <main class="py-4">
        @if(session('alert'))
            <div class="container">
                <div class="alert alert-{{ session('alert.context', 'info') }} alert-dismissible fade show" role="alert">
                    @if(session('alert.title'))
                        <strong>{{ session('alert.title') }}</strong>
                    @endif

                    {{ session('alert.message') }}

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
    <script src="{{ asset('assets/app/js/admin.js') }}"></script>
    <script src="{{ asset('assets/app/js/bootstrap.min.js') }}"></script>
    @if(config('boilerplate.google_analytics_tracking_id'))
        <script src="{{ asset('assets/base/js/google-analytics.js') }}"></script>
        <script src="https://www.google-analytics.com/analytics.js" async></script>
    @endif
</body>

</html>
