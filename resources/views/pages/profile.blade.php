@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="container">
    <h2>My Profile</h2>

    <ul>
        <li><strong>ID:</strong> {{ $user->id}}</li>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        <li><strong>Role:</strong> {{ $user->role}}</li>
    </ul>
    
    <p>
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
        <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
    </p>

</section>
@endsection
