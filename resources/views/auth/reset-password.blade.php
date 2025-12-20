@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<h2>Reset password</h2>

<p>Enter your email and choose a new password.</p>

<form method="post" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <label for="email">Email</label>
    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', request('email')) }}"
        required
        autocomplete="email"
        placeholder="email@example.com">

    @error('email')
    <div class="error">{{ $message }}</div>
    @enderror

    <label for="password">New password</label>
    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="new-password"
        placeholder="Type your new password">
    @error('password')
    <span id="password-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="password-confirm">Confirm new password</label>
    <input
        id="password-confirm"
        type="password"
        name="password_confirmation"
        required
        autocomplete="new-password"
        placeholder="Type again the new password">
    @error('password_confirmation')
    <span id="password-error" class="error" role="alert">{{ $message }}</span>
    @enderror        

    <button type="submit">Reset password</button>

</form>
@endsection