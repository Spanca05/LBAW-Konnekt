@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="container">
    <h2>Edit Profile</h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
        @error('name') <small class="error">{{ $message }}</small> @enderror

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}">
        @error('email') <small class="error">{{ $message }}</small> @enderror

        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}">
        @error('phone') <small class="error">{{ $message }}</small> @enderror

        <label for="password">New password (leave blank to keep current)</label>
        <input id="password" name="password" type="password">
        @error('password') <small class="error">{{ $message }}</small> @enderror

        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" name="password_confirmation" type="password">

        <p>
            <button type="submit" class="button">Save changes</button>
            <a class="button" href="{{ route('profile') }}">Cancel</a>
        </p>
    </form>
</section>
@endsection