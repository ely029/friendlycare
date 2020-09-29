@extends('layouts.base')

@push('styles')
    {{-- @TB: If you need custom styles for dashboard place it in assets/dashboard/css/ --}}
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/app/css/app.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- @TB: If you need custom scripts for dashboard place it in assets/dashboard/js/ --}}
    <script src="{{ asset('assets/app/js/app.js') }}"></script>
@endpush
