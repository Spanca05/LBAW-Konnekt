@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            <h3 class="mb-3 h1">Admin Dashboard</h3>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <img src="{{ !empty($admin->photo_url) ? $admin->photo_url : asset('images/profile-placeholder.png') }}" alt="Profile Picture of {{ $admin->name }}" class="rounded" style="width: 64px; height: 64px; object-fit: cover;">
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="mb-0 h2">{{ $admin->name }}</h5>
                            <span class="badge jobpost-badge fs-5">{{ $admin->role }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-0" id="adminTabs" role="tablist">
                <li class="nav-item m-0" role="presentation">
                    <button class="nav-link {{ $activeTab === 'profile' ? 'active' : '' }} fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="{{ $activeTab === 'profile' ? 'true' : 'false' }}">
                        Profile
                    </button>
                </li>
                <li class="nav-item m-0" role="presentation">
                    <button class="nav-link {{ $activeTab === 'admin-tools' ? 'active' : '' }} fs-5" id="admin-tools-tab" data-bs-toggle="tab" data-bs-target="#admin-tools" type="button" role="tab" aria-controls="admin-tools" aria-selected="{{ $activeTab === 'admin-tools' ? 'true' : 'false' }}">
                        Admin Tools
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 rounded-0 rounded-bottom p-4 bg-white" id="adminTabsContent">
                <div class="tab-pane fade {{ $activeTab === 'profile' ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-5">
                        <p class="mb-1 text-muted fs-5">Email</p>
                        <p class="mb-0 h5 fs-4">{{ $admin->email }}</p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-1 text-muted fs-5">Phone</p>
                        <p class="mb-0 h5 fs-4">{{ $admin->phone_number }}</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('profile.edit') }}" class="button">Edit Profile</a>
                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button class="button">Delete Profile</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade {{ $activeTab === 'admin-tools' ? 'show active' : '' }}" id="admin-tools" role="tabpanel" aria-labelledby="admin-tools-tab">
                    <div class="row gy-3">
                        <div class="col-12 mb-5">
                            <h5 class="mb-3 fs-4">Create Admin Account</h5>
                            <a href="{{ route('admin.create.form') }}" class="button">Create Admin Account</a>
                        </div>

                        <div class="col-12 mb-5">
                            <h5 class="mb-3 fs-4">User Management</h5>
                            <p class="mb-2 h5"><strong>Total Users:</strong> {{ $userCount }}</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.users') }}" class="button">View All Users</a>
                                <a href="{{ route('admin.users.blocked') }}" class="button">View Blocked Users ({{ $blockedCount }})</a>
                            </div>
                        </div>

                        <div class="col-12 mb-5">
                            <h5 class="mb-3 fs-4">JobPosts Management</h5>
                            <p class="mb-2 h5"><strong>Total JobPosts:</strong> {{ $jobpostCount }}</p>
                            <a href="{{ route('admin.jobposts') }}" class="button">View All JobPosts</a>
                        </div>

                        <div class="col-12 mb-5">
                            <h5 class="mb-3 fs-4">Applications Management</h5>
                            <p class="mb-2 h5"><strong>Total Applications:</strong> {{ $applicationCount }}</p>
                            <a href="{{ route('admin.applications') }}" class="button">View All Applications</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection