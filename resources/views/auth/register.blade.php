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

    <label for="role">Role
        <span class="help-icon">
            ?
          <span class="tooltip-text">JobSeeker can apply to jobs, Employer is the one who posts job offers</span>
        </span>
    </label>
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

    <label for="location">Location</label>
    <input
        id="location"
        type="text"
        name="location"
        value="{{ old('location') }}"
        autocomplete="street-address"
    >
    @error('location')
      <span id="location-error" class="error" role="alert">{{ $message }}</span>
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

   <div id="skills-wrapper">
      <label>Select your skills</label>
        @foreach($skills as $skill)
            <label>
                <input type="checkbox" name="skills[]" value="{{ $skill->id }}">
                {{ $skill->name }}
            </label>
        @endforeach
        @error('skills')
            <small class="error" role="alert">{{ $message }}</small>
        @enderror
    </div>

    @error('description')
      <span id="description-error" class="error" role="alert">{{ $message }}</span>
    @enderror
      <label for="description">Description</label>
      <input id="description" name="description" type="text" >

    <label for="password">Password
        <span class="help-icon">
            ?
          <span class="tooltip-text">Password must be at least 8 characters</span>
        </span>
      </label>
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