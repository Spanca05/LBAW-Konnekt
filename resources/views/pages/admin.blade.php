@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div>
    <h2>Admin Dashboard</h2>
    <h3>Profile</h3>
    <div>
        <div>
            <p><strong>Name:</strong> {{ $admin->name}}</p>
            <p><strong>Email:</strong> {{ $admin->email}}</p>
            <p><strong>Phone:</strong> {{ $admin->phone_number}}</p>
            <p><strong>Role:</strong> {{ $admin->role}}</p>
        </div>
    </div>
    <h3>Admin Tools</h3>
    <h4>Create Admin Account</h4>
    <form method="POST" action="{{ url('/admin/create-admin') }}">
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
    <h4>User management</h4>
    <p><strong>Total Users:</strong> {{ $userCount }}</p>
    <a href="{{ route('admin.users') }}" class="button">View All Users</a>
    <h4>JobPosts Management</h4>
    <p><strong>Total JobPosts:</strong> {{ $jobpostCount }}</p>
    <a href="{{ route('admin.jobposts') }}" class="button">View All JobPosts</a>
    <h4>Applications Management</h4>
    <p><strong>Total Applications:</strong> {{ $applicationCount }}</p>
    <a href="{{ route('admin.applications') }}" class="button">View All Applications</a>

</div>
</div>
@endsection