@extends('layouts.dashboard')

@section('title', ($method === 'POST' ? 'Create a user' : 'Update user details'))
@section('description', ($method === 'POST' ? 'Create a user' : 'Update user details'))

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST"
                action="{{ url('/dashboard/users', isset($user) ? $user->id : null) }}" enctype="multipart/form-data">
            @csrf
            {{ method_field($method) }}

            <div class="card">
                <div class="card-header">
                    <h5 class="float-left my-2">Users</h5>
                    @if($method === 'PATCH')
                        <div class="dropdown float-right">
                            <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                •••
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault();
                                                    document.getElementById('delete-form').submit();">
                                    Delete user
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($method === 'PATCH')
                        <div class="form-group row">
                            <label for="id" class="col-md-4 col-form-label text-md-right">ID</label>

                            <div class="col-md-8">
                                <input id="id" type="text" class="form-control-plaintext" value="{{ $user->id }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="created_at" class="col-md-4 col-form-label text-md-right">Created</label>

                            <div class="col-md-8">
                                <input id="created_at" type="text" class="form-control-plaintext" value="{{ $user->created_at->toCookieString() }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="updated_at" class="col-md-4 col-form-label text-md-right">Updated</label>

                            <div class="col-md-8">
                                <input id="updated_at" type="text" class="form-control-plaintext" value="{{ $user->updated_at->toCookieString() }}" readonly>
                            </div>
                        </div>

                        <hr>
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }} row">
                        <label for="role_id" class="col-md-4 col-form-label text-md-right">User Role</label>

                        <div class="col-md-8">
                            <select name="role_id" id="role_id" class="form-control  @error('name') is-invalid @enderror custom-select" required>
                                <option value="">Choose Role</option>
                                @foreach (\App\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', isset($user) ? $user->role_id : null) == $role->id ? 'selected' : null }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                        <label for="password" class="col-md-4 col-form-label text-md-right ">Password</label>

                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                           
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                        <div class="col-md-8">
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row">
                        <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                        <div class="col-md-8">
                            @if($method === 'PATCH')
                                <p>
                                    <a href="{{ $user->photo_url }}" target="_blank">
                                        <img src="{{ $user->photo_url }}" alt="{{ $user->photo_alt }}"
                                                width="16" height="16">
                                    </a>
                                </p>
                            @endif
                            <div class="custom-file">
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept=".gif,.jpeg,.jpg,.jpe,.png">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>

                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('photo_alt') ? ' has-error' : '' }} row">
                        <label for="photo_alt" class="col-md-4 col-form-label text-md-right">Photo Alternative Text</label>

                        <div class="col-md-8">
                            <input id="photo_alt" type="text" class="form-control  @error('photo_alt') is-invalid @enderror" name="photo_alt"
                                    value="{{ old('photo_alt', isset($user) ? $user->photo_alt : null) }}"
                            >

                            @error('photo_alt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="/dashboard/users">Cancel</a>
                    <button type="submit"class="btn btn-primary">
                        {{ $method === 'POST' ? 'Create' : 'Update' }} user
                    </button>
                </div>
            </div>
        </form>

        @if($method === 'PATCH')
            <form id="delete-form" action="{{ url('dashboard/users/'.$user->id) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection
