@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section id="profile" class="container">
    <h2>My Profile</h2>

    <ul>
        <li><strong>Name:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Phone:</strong> {{ $user->phone }}</li>
    </ul>
</section>
@endsection