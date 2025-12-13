@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-md-center">
        <div class="col-md-8 col-lg-6">
            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name">Name</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name">
                            @error('name')
                            <span id="name-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
                                <option value="JobSeeker" {{ old('role') === 'JobSeeker' ? 'selected' : '' }}>JobSeeker</option>
                                <option value="Employer" {{ old('role') === 'Employer' ? 'selected' : '' }}>Employer</option>
                            </select>
                            @error('role')
                            <span id="role-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone_number">Phone Number</label>
                            <input
                                id="phone_number"
                                type="text"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                autocomplete="tel">
                            @error('phone_number')
                            <span id="phone_number-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="location">Location</label>
                            <input
                                id="location"
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                autocomplete="street-address">
                            @error('location')
                            <span id="location-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email">E-Mail Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                inputmode="email">
                            @error('email')
                            <span id="email-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="skills-wrapper" class="mb-4">
                            <label>Select your skills (only for JobSeekers)</label>
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

                        <div class="mb-4">
                            <label for="description">Description</label>
                            <input id="description" name="description" type="text">
                            @error('description')
                            <span id="description-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password">
                            @error('password')
                            <span id="password-error" class="error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm">Confirm Password</label>
                            <input
                                id="password-confirm"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password">
                        </div>

                        <button type="submit">Register</button>
                        <a class="button button-outline" href="{{ route('login') }}">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection