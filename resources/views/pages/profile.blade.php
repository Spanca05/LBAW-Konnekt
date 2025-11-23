@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="container">
    <h2>My Profile</h2>

    <ul>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
    </ul>
    
    <p>
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
    </p>

</section>
@endsection
