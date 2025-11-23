@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Name</label>
    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name') }}"
        required
        autofocus
        autocomplete="name"
    >
    @error('name')
      <span id="name-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="role">Role</label>
    <select id="role" name="role" required>
        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
        <option value="JobSeeker" {{ old('role') === 'JobSeeker' ? 'selected' : '' }}>JobSeeker</option>
        <option value="Employer" {{ old('role') === 'Employer' ? 'selected' : '' }}>Employer</option>
    </select>
    @error('role')
      <span id="role-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="phone_number">Phone Number</label>
    <input
        id="phone_number"
        type="text"
        name="phone_number"
        value="{{ old('phone_number') }}"
        autocomplete="tel"
    >
    @error('phone_number')
      <span id="phone_number-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="email">E-Mail Address</label>
    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autocomplete="email"
        inputmode="email"
    >
    @error('email')
      <span id="email-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="password">Password</label>
    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="new-password"
    >
    @error('password')
      <span id="password-error" class="error" role="alert">{{ $message }}</span>
    @enderror

    <label for="password-confirm">Confirm Password</label>
    <input
        id="password-confirm"
        type="password"
        name="password_confirmation"
        required
        autocomplete="new-password"
    >

    <button type="submit">Register</button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
@endsection