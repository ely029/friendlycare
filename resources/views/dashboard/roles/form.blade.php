@extends('layouts.dashboard')

@section('title', ($method === 'POST' ? 'Create a role' : 'Update role details'))
@section('description', ($method === 'POST' ? 'Create a role' : 'Update role details'))

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST"
                action="{{ url('/dashboard/roles', isset($role) ? $role->id : null) }}" enctype="multipart/form-data">
            @csrf
            {{ method_field($method) }}

            <div class="card">
                <div class="card-header">
                    <h5 class="float-left my-2">Role</h5>
                    @if($method === 'PATCH')
                        @if($role->is_deletable)

                        <div class="dropdown float-right">
                            <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                •••
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault();
                                                    document.getElementById('delete-form').submit();">
                                    Delete role
                                </a>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
                <div class="card-body">
                    @if($method === 'PATCH')
                        <div class="form-group row">
                            <label for="id" class="col-md-4 col-form-label text-md-right">ID</label>

                            <div class="col-md-8">
                                <input id="id" type="text" class="form-control-plaintext" value="{{ $role->id }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="created_at" class="col-md-4 col-form-label text-md-right">Created</label>

                            <div class="col-md-8">
                                <input id="created_at" type="text" class="form-control-plaintext" value="{{ $role->created_at->toCookieString() }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="updated_at" class="col-md-4 col-form-label text-md-right">Updated</label>

                            <div class="col-md-8">
                                <input id="updated_at" type="text" class="form-control-plaintext" value="{{ $role->updated_at->toCookieString() }}" readonly>
                            </div>
                        </div>

                        <hr>
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($role) ? $role->name : '') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Role Accesses</label>

                        <div class="col-md-8">
                            <span>
                                <strong>index</strong> - allows viewing of lists.</br>
                                <strong>create</strong> - allows user to access the create form.</br>
                                <strong>store</strong> - allows user to save the create form.</br>
                                <strong>edit</strong> - allows user to view record.</br>
                                <strong>update</strong> - allows user to update record.</br>
                                <strong>destroy</strong> - allows user to delete record.</br>
                            </span>
                            <div class="row">
                                <div class="btn-group">
                                    <a href="#" id="select-all" class="btn btn-primary-outline">Select All</a>
                                    <a href="#" id="deselect-all" class="btn btn-primary-outline">Deselect All</a>
                                </div>
                            </div>
                            <div class="row">
                            @foreach(App\RoleRoute::transformed() as $router)
                            <div class="col-md-3">
                                <p >
                                    <strong>{{ $router['label'] }}</strong>
                                </p>
                                @foreach ($router['actions'] as $key => $route)
                                    <div>
                                        <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input"
                                                        name="role_access[]" id="{{ $router['label'] }}{{ $route['controller_action'] }}"
                                                        value="{{ $route['controller'] }}"
                                                            {{ isset($role) ? ( $role->accesses->where('route', $route['controller'])->first() ? 'checked' : '' ): '' }}
                                                    >
                                            <label class="form-check-label" for="{{ $router['label'] }}{{ $route['controller_action'] }}">{{ $route['controller_action'] }}</label>
                                        </div>
                                       
                                    </div>
                                @endforeach
                            </div>

                            @endforeach

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="/dashboard/roles">Cancel</a>
                    <button type="submit"class="btn btn-primary">
                        {{ $method === 'POST' ? 'Create' : 'Update' }} role
                    </button>
                </div>
            </div>
        </form>

        @if($method === 'PATCH')
            <form id="delete-form" action="{{ url('dashboard/roles/'.$role->id) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/dashboard/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/checkbox.js') }}"></script>
@endpush