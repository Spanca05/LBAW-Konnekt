@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="container">
    <h2>Edit Profile</h2>

    @if(session('success'))
    <div class="message success" role="alert">{{ session('success') }}</div>
    @endif

    {{-- Unified profile + CV form --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if($user->role !== 'Admin')
            <label for="photo">Profile Picture</label>
            <input id="photo" name="photo" type="file" accept="image/*">
            @error('photo') <small class="error" role="alert">{{ $message }}</small> @enderror
            
            @if($user->photo_path)
            <p>
                <em>Current photo uploaded.</em>
            </p>
            @endif
        @endif
            
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
        @error('name') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}">
        @error('email') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="phone_number">Phone</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}">
        @error('phone_number') <small class="error" role="alert">{{ $message }}</small> @enderror

        @if($user->role !== 'Admin')
            <label for="location">Location</label>
            <input id="location" name="location" type="text" value="{{ old('location', $user->location) }}">
            @error('location') <small class="error" role="alert">{{ $message }}</small> @enderror
        @endif

        @if ($user->role ==='JobSeeker')
            <label>Change your skills</label>
            @foreach($skills as $skill)
                <label>
                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                        {{ (collect(old('skills', $user->skills->pluck('id')))->contains($skill->id)) ? 'checked' : '' }}>
                    {{ $skill->name }}
                </label>
            @endforeach
            @error('skills')
                <small class="error" role="alert">{{ $message }}</small>
            @enderror
        @endif

        @if($user->role !== 'Admin')
            <label for="description">Description</label>
            <input id="description" name="description" type="text" value="{{ old('description', $user->description) }}">
            @error('description') <small class="error" role="alert">{{ $message }}</small> @enderror
        @endif

        <label for="password">New password (leave blank to keep current)</label>
        <input id="password" name="password" type="password">
        @error('password') <small class="error" role="alert">{{ $message }}</small> @enderror

        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" name="password_confirmation" type="password">

        @if($user->role === 'JobSeeker')
        <section style="margin-top:1rem">
            <h3>Curriculum Vitae</h3>

            <label for="cv_file">Upload CV (PDF, DOC, DOCX)</label>
            <input id="cv_file" name="cv_file" type="file" accept=".pdf,.doc,.docx">
            @error('cv_file') <small class="error" role="alert">{{ $message }}</small> @enderror
        </section>
        @endif

        <p>
            <button type="submit" class="button">Save changes</button>
            <a class="button" href="{{ $user->role === 'Admin' ? route('admin.index') : route('profile') }}">Cancel</a>
        </p>
    </form>

    @if($user->photo_path)
    <form method="POST" action="{{ route('profile.photo.destroy') }}" style="margin-top:0.5rem">@csrf @method('DELETE')
        <button class="button" type="submit">Remove photo</button>
    </form>
    @endif

    @if(optional($user->cv)->file_path)
    <section style="margin-top:1rem">
        @if(optional($user->cv)->file_path)
        <p>
            <a class="button" href="{{ route('profile.cv.download') }}">Download current CV</a>
        </p>

        <form method="POST" action="{{ route('profile.cv.destroy') }}" style="margin-top:0.5rem">@csrf @method('DELETE')
            <button class="button" type="submit">Remove CV</button>
        </form>
        @endif
    </section>
    @endif
</section>
@endsection