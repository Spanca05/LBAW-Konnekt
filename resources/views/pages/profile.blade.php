@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="profile_info">
    @if(auth()->id() === $user->id)
        <h2>My Profile</h2>
    @else
        <h2>{{ $user->name }}'s Profile</h2>
    @endif

    <ul>
        <li><strong>ID:</strong> {{ $user->id}}</li>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        <li><strong>Role:</strong> {{ $user->role}}</li>
    </ul>

    @if(auth()->id() === $user->id)
        <p>
            <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
            <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
        </p>
    @endif


</section>

@if($user->role === 'Employer')

    <section id="jobposts">
        @if(auth()->id() === $user->id && $user->role === 'Employer')
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
