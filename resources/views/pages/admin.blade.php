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
    <a href="{{ route('profile.edit') }}" class="button">Edit Profile</a>
    <form method="POST" action="{{ route('profile.destroy') }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button class="button">Delete Profile</button>
    </form>
    <h3>Admin Tools</h3>
    <h4>Create Admin Account</h4>
    <a href="{{ route('admin.create.form') }}" class="button">Create Admin Account</a>
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