@extends('layouts.admin.base')

@push('scripts')
<script type="text/javascript"  src="{{ asset('assets/app/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/main.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/admin.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/notification.js') }}"></script>
@endpush
@push('styles')

    <!-- Styles -->
    <link href="{{ asset('assets/app/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/app/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
