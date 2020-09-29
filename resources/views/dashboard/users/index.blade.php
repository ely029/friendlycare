@extends('layouts.dashboard')

@section('title', 'View Users')
@section('description', 'View Users')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="float-left my-2">Users</h5>
                <a class="btn btn-primary shadow-sm float-right" href="/dashboard/users/create">New</a>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table m-0 table-sm table-hover">
                    <thead>
                    <tr class="text-uppercase">
                        <th scope="col"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-right">
                                    <img class="rounded-circle" src="{{ $user->photo_url }}" alt="{{ $user->photo_alt }}" width="16" height="16">
                                </td>
                                <th scope="row" class="align-middle">
                                    <a href="/dashboard/users/{{ $user->id }}/edit">
                                        {{ $user->name }}
                                    </a>
                                </th>
                                <td class="align-middle">
                                    <a href="mailto:{{ $user->email }}" target="_blank">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="/dashboard/roles/{{ $user->role->id }}/edit">
                                        {{ $user->role->name }}
                                    </a>
                                </td>
                                <td class="text-monospace small">
                                    {{ $user->created_at->toCookieString() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">You don't have any users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left text-muted my-1">
                    <strong>{{ $users->total() }}</strong> {{ Str::plural('result', $users->total()) }}
                </div>
                <div class="float-right">
                    <a class="btn btn-outline-secondary btn-sm shadow-sm @empty($users->previousPageUrl()) disabled @endempty" href="{{ $users->previousPageUrl() }}">Previous</a>
                    <a class="btn btn-outline-secondary btn-sm shadow-sm @empty($users->nextPageUrl()) disabled @endempty" href="{{ $users->nextPageUrl() }}">Next</a>
                </div>
            </div>
        </div>
    </div>
@endsection
