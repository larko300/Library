@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="d-flex">
                            <div class="p-2"><h5 class="card-title">Edit user:</h5></div>
                            <div class="ml-auto p-2"><a href="{{ route('user.index') }}"><button type="submit" class="btn btn-secondary">Back</button></a></div>
                        </div>
                        <form method="POST" action="{{ route('user.update', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" required autocomplete="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required autocomplete="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">New password</label>
                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password-confirm" class="col-md-4 col-form-label text-md-right">Confirm new password</label>
                                <div class="col-md-6">
                                    <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                        @include('errors')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
