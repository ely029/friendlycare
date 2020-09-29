@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('description', 'Dashboard')

@section('content')
    <div class="container">
        @if(config('app.debug'))
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">Warning!</h4>
                <strong>You are in debug mode.</strong>
            </div>
        @endif

        @unless('production' === config('app.env'))
            <div class="alert alert-danger text-center" role="alert">
                <h4 class="alert-heading">Danger!</h4>
                <strong>You are on the {{ strtoupper(config('app.env')) }} environment.</strong>
                <hr>
                This environment is transitory. By using this, you agree to the risks involved during software testing.
            </div>
        @endunless

        <div class="row row-cols-1 row-cols-sm-4">
            <div class="col mb-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h6 class="text-uppercase">{{ Str::plural('User', $userCount) }}</h6>
                        <h1 class="display-4">{{ number_format($userCount) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h6 class="text-uppercase">{{ Str::plural('Role', $roleCount) }}</h6>
                        <h1 class="display-4">{{ number_format($roleCount) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
