@extends('layouts.dashboard')

@section('title', 'View Roles')
@section('description', 'View Roles')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="float-left my-2">Roles</h5>
                <a class="btn btn-primary shadow-sm float-right" href="/dashboard/roles/create">New</a>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table m-0 table-sm table-hover">
                    <thead>
                    <tr class="text-uppercase">
                        <th scope="col"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Created</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="text-right">
                                </td>
                                <th scope="row" class="">
                                    <a href="/dashboard/roles/{{ $role->id }}/edit">
                                        {{ $role->name }}
                                    </a>
                                </th>
                                <td class="text-monospace small">
                                    {{ $role->created_at->toCookieString() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">You don't have any role</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left text-muted my-1">
                    <strong>{{ $roles->total() }}</strong> {{ Str::plural('result', $roles->total()) }}
                </div>
                <div class="float-right">
                    <a class="btn btn-outline-secondary btn-sm shadow-sm @empty($roles->previousPageUrl()) disabled @endempty" href="{{ $roles->previousPageUrl() }}">Previous</a>
                    <a class="btn btn-outline-secondary btn-sm shadow-sm @empty($roles->nextPageUrl()) disabled @endempty" href="{{ $roles->nextPageUrl() }}">Next</a>
                </div>
            </div>
        </div>
    </div>
@endsection
