@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7 col-xl-6">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h1 class="h4 mb-4">Create account</h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <span class="help-icon">
                                ?
                                <span class="tooltip-text">Please enter your full name as it will appear on your public profile.</span>
                            </span>                            
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Your Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                Role
                                <span class="help-icon">
                                    ?
                                    <span class="tooltip-text">JobSeeker can apply to jobs, Employer is the one who posts job offers</span>
                                </span>
                            </label>
                            <select
                                id="role"
                                name="role"
                                class="@error('role') is-invalid @enderror"
                                required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
                                <option value="JobSeeker" {{ old('role') === 'JobSeeker' ? 'selected' : '' }}>JobSeeker</option>
                                <option value="Employer" {{ old('role') === 'Employer' ? 'selected' : '' }}>Employer</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            {{-- Phone --}}
                            <div class="col-12 col-md-6">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input
                                    id="phone_number"
                                    type="tel"
                                    placeholder="ex:123456789"
                                    name="phone_number"
                                    value="{{ old('phone_number') }}"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    autocomplete="tel">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-12 col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <span class="help-icon">
                                    ?
                                <span class="tooltip-text">Please enter the location where you want to find work or you live.</span>
                            </span>
                                <input
                                    id="location"
                                    type="text"
                                    name="location"
                                    value="{{ old('location') }}"
                                    class="form-control @error('location') is-invalid @enderror"
                                    autocomplete="street-address"
                                    placeholder="ex:Lisboa">
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mt-3 mb-3">
                            <label for="email" class="form-label">E-Mail Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autocomplete="email"
                                inputmode="email"
                                placeholder="email@example.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Skills --}}
                        <div id="skills-wrapper" class="mb-3">
                            <label class="form-label">Select your skills (only for JobSeekers)</label>

                            <div class="d-flex flex-wrap gap-3">
                                @foreach($skills as $skill)
                                <div class="form-check">
                                    <input
                                        class="btn-check"
                                        type="checkbox"
                                        name="skills[]"
                                        value="{{ $skill->id }}"
                                        id="skill-{{ $skill->id }}"
                                        {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-dark btn-lg" for="skill-{{ $skill->id }}">
                                        {{ $skill->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            @error('skills')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input
                                id="description"
                                name="description"
                                type="text"
                                value="{{ old('description') }}"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Small description about you">
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            {{-- Password --}}
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label">
                                    Password
                                    <span class="help-icon">
                                        ?
                                        <span class="tooltip-text">Password must be at least 8 characters</span>
                                    </span>
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Type your password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm password --}}
                            <div class="col-12 col-md-6">
                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <span class="help-icon">
                                        ?
                                    <span class="tooltip-text">You must enter the same password here that you typed in the previous field.</span>
                                    </span>
                                <input
                                    id="password-confirm"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Repeat password">
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <button type="submit" class="button">Register</button> 
                            <a class="button button-outline" href="{{ route('login') }}">Cancel</a>
                        </div>
                            <br>
                            <p>Do you have an Account?</p>
                            <a class="button button-outline" href="{{ route('login') }}">Login</a>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection