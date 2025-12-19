@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-md-center">
        <div class="col-md-8 col-lg-6">
            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email">E-mail</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                inputmode="email"
                                autocomplete="email">
                            @error('email')
                            <span id="email-error" class="error" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password">
                            @error('password')
                            <span id="password-error" class="error" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <a href="{{ route('password.request') }}" class="text-decoration-none fs-5 fw-medium">Forgot your password?</a>
                        </div>

                        <div class="mb-4">
                            <label>
                                <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                                Remember me
                            </label>
                        </div>


                        <div class="actions">
                            <button class="button" type="submit">Login</button>
                            <a class="button button-outline" href="{{ route('register') }}">Register</a>
                        </div>

                        @if (session('status'))
                        <p class="success" role="status">{{ session('status') }}</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection