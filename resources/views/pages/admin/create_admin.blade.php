@extends('layouts.app')

@section('title', 'Create Admin Account')

@section('content')
<div>
    <h2>Create Admin Account</h2>
    <a href="{{ route('admin.index') }}" class="button button-outline">Back to Admin Dashboard</a>

    <form method="POST" action="{{ url('/admin/create-admin') }}" style="margin-top: 1rem;">
        @csrf

        <label for="admin_name">Username</label>
        <input id="admin_name" name="name" type="text" placeholder="username" required />

        <label for="admin_email">Email</label>
        <input id="admin_email" name="email" type="email" placeholder="admin@example.com" required />

        <label for="admin_phone">Phone</label>
        <input id="admin_phone" name="phone_number" type="text" placeholder="123456789" required />

        <label for="admin_password">Password</label>
        <input id="admin_password" name="password" type="password" placeholder="password" required />

        <button class="button" type="submit">Create admin</button>
    </form>
</div>
@endsection
