@extends('layouts.admin.app')

@push('styles')
    {{-- @TB: If you need custom styles for dashboard place it in assets/dashboard/css/ --}}
    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('assets/app/css/admin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- @TB: If you need custom scripts for dashboard place it in assets/dashboard/js/ --}}
    <script src="{{ asset('assets/app/js/app.js') }}"></script>
@endpush
