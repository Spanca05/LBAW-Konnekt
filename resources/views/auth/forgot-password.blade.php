@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<h2>Forgot your password?</h2>

<p>Enter your email address and we will send you a password reset link.</p>

<form method="post" action="{{ route('password.email') }}">
    @csrf

    <label for="email">Email</label>
    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email') }}"
        required
    >

    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Send password reset link</button>
</form>
@endsection