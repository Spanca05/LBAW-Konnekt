@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="container">
    <h2>Edit Profile</h2>

    @if(session('success'))
    <div class="message success" role="alert">{{ session('success') }}</div>
    @endif

    {{-- CV upload form (separate) --}}
    @if($user->role === 'JobSeeker')
    <form method="POST" action="{{ route('profile.cv.store') }}" enctype="multipart/form-data" style="margin-bottom:1.5rem">
        @csrf

        <label for="cv_file">Upload CV (PDF, DOC, DOCX)</label>
        <input id="cv_file" name="cv_file" type="file" accept=".pdf,.doc,.docx">
        @error('cv_file') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="cv_description">CV Description / Summary</label>
        <textarea id="cv_description" name="cv_description">{{ old('cv_description', optional($user->cv)->description) }}</textarea>
        @error('cv_description') <small class="error" role="alert">{{ $message }}</small> @enderror

        @if(optional($user->cv)->file_path)
        <p>
            <a class="button" href="{{ route('profile.cv.download') }}">Download current CV</a>
        </p>
        @endif

        <p>
            <button type="submit" class="button">Save CV</button>
        </p>
    </form>
    @endif

    {{-- Profile form (photo, name, email, etc.) --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="photo">Profile Picture</label>
        <input id="photo" name="photo" type="file" accept="image/*">
        @error('photo') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
        @error('name') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}">
        @error('email') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="phone_number">Phone</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}">
        @error('phone_number') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="password">New password (leave blank to keep current)</label>
        <input id="password" name="password" type="password">
        @error('password') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" name="password_confirmation" type="password">

        <p>
            <button type="submit" class="button">Save changes</button>
            <a class="button" href="{{ route('profile') }}">Cancel</a>
        </p>
    </form>
</section>
@endsection