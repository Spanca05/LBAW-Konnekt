@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="profile_info">
    @if(auth()->check() && auth()->id() === $user->id)
    <h2>My Profile</h2>
    @else
    <h2>{{ $user->name }}'s Profile</h2>
    @endif

    @if(!empty($user->photo_url))
    <div style="margin-bottom: 1rem">
        <img
            src="{{ $user->photo_url }}"
            alt="Profile Picture of {{ $user->name }}"
            style="max-width: 150px; max-height:150px; object-fit:cover; border-radius:6px;">
    </div>
    @else
    <div style="margin-bottom:1rem">
        <img
            src="{{ asset('images/avatar-placeholder.png') }}"
            alt="No photo"
            style="max-width:150px; max-height:150px; object-fit:cover; border-radius:6px;">
    </div>
    @endif

    <ul>
        <li><strong>ID:</strong> {{ $user->id}}</li>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        <li><strong>Role:</strong> {{ $user->role}}</li>

        @if($user->role === 'JobSeeker' && (optional($user->cv)->file_path || optional($user->cv)->description))
        <li>
            <strong>CV:</strong>
            @if(optional($user->cv)->file_path)
            <a class="button" href="{{ route('profile.cv.download') }}">Download CV</a>
            @endif
            @if(optional($user->cv)->description)
            <div style="margin-top:0.5rem">{{ $user->cv->description }}</div>
            @endif
        </li>
        @endif
    </ul>

    <p>
        @if(auth()->check() && auth()->id() === $user->id)
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
        @if(auth()->user()->role === 'Employer')
        <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
        @endif
        @endif
    </p>

</section>

@if($user->role === 'Employer')

<section id="jobposts">
    @if(auth()->check() && auth()->id() === $user->id && $user->role === 'Employer')
    <h2>My JobPosts</h2>
    @elseif($user->role === 'Employer')
    <h2>{{ $user->name }}'s JobPosts</h2>
    @endif

    @foreach ($jobPosts as $jobPost)
    {{-- Mostra cada job usando o partial --}}
    @include('partials.jobpost', ['jobPost' => $jobPost])
    @endforeach

</section>

@endif


@endsection