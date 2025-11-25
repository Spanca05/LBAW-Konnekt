@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="container">
    <h2>My Profile</h2>

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
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        @if(optional($user->cv)->file_path || optional($user->cv)->description)
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
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
    </p>

</section>
@endsection