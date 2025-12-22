@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">

                    <h1 class="mb-4">Edit Profile</h1>

                    @if(session('success'))
                    <p class="success" role="alert">{{ session('success') }}</p>
                    @endif

                    {{-- Unified profile + CV form --}}
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if($user->role !== 'Admin')
                        <div class="mb-3">
                            <label for="photo" class="form-label">Profile Picture</label>
                            <input id="photo" name="photo" type="file" accept="image/*" class="form-control w-50">
                            @error('photo') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            @if($user->photo_path)
                            <div class="form-text">Current photo uploaded.</div>
                            @endif
                        </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" placeholder="Your Name" class="form-control @error('name') is-invalid @enderror">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="email@example.com" class="form-control @error('email') is-invalid @enderror">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-0">
                            <div class="col-12 col-md-6">
                                <label for="phone_number" class="form-label">Phone</label>
                                <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number', $user->phone_number) }}" placeholder="ex:123456789" class="form-control @error('phone_number') is-invalid @enderror">
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if($user->role !== 'Admin')
                            <div class="col-12 col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input id="location" name="location" type="text" value="{{ old('location', $user->location) }}" placeholder="ex:Famalicão" class="form-control @error('location') is-invalid @enderror">
                                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @endif
                        </div>

                        @if ($user->role === 'JobSeeker')
                        <div class="mt-3 mb-3">
                            <label class="form-label">Change your skills</label>
                            <div class="d-flex flex-wrap gap-3"> @foreach($skills as $skill)
                                <input 
                                    type="checkbox" 
                                    class="btn-check" 
                                    name="skills[]" 
                                    value="{{ $skill->id }}" 
                                    id="skill-{{ $skill->id }}" 
                                    autocomplete="off"
                                    {{ (collect(old('skills', $user->skills->pluck('id')))->contains($skill->id)) ? 'checked' : '' }}
                                >
                                
                                <label class="btn btn-outline-dark btn-lg" for="skill-{{ $skill->id }}">
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>

                            @error('skills') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        @if($user->role !== 'Admin')
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" name="description" type="text" value="{{ old('description', $user->description) }}" placeholder="Small description about you" class="form-control @error('description') is-invalid @enderror">
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label">New password (leave blank to keep current)</label>
                                <input id="password" name="password" type="password" placeholder="Type a new password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm new password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Type new password again" class="form-control">
                            </div>
                        </div>

                        @if($user->role === 'JobSeeker')
                        <div class="mt-4">
                            <label for="cv_file" class="form-label">Upload CV (PDF, DOC, DOCX)</label>
                            <input id="cv_file" name="cv_file" type="file" accept=".pdf,.doc,.docx" class="form-control w-50">
                            @error('cv_file') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <button type="submit" class="button">Save changes</button>
                            <a class="button button-outline" href="{{ $user->role === 'Admin' ? route('admin.index') : route('profile') }}">Cancel</a>
                        </div>
                    </form>

                    @if($user->photo_path)
                    <form method="POST" action="{{ route('profile.photo.destroy') }}" class="mt-3">
                        @csrf 
                        @method('DELETE')
                        <button class="button button-outline" type="submit">Remove photo</button>
                    </form>
                    @endif

                    @if(optional($user->cv)->file_path)
                    <div class="mt-3">
                        <a class="button" href="{{ route('profile.cv.download') }}">Download current CV</a>
                        <form method="POST" action="{{ route('profile.cv.destroy') }}" class="mt-2">
                            @csrf 
                            @method('DELETE')
                            <button class="button button-outline" type="submit">Remove CV</button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection