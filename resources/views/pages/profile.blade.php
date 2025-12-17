@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">

            <h3 class="mb-3">
                @if(auth()->check() && auth()->id() === $user->id)
                My Profile
                @else
                {{ $user->name }}'s Profile
                @endif
            </h3>

            <!-- Profile Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Photo -->
                        <div>
                            <img
                                src="{{ !empty($user->photo_url) ? $user->photo_url : asset('images/profile-placeholder.png') }}"
                                alt="Profile Picture of {{ $user->name }}"
                                class="rounded"
                                style="width: 64px; height: 64px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='{{ asset('images/profile-placeholder.png') }}';">
                        </div>

                        <!-- Name and Role -->
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="mb-0">{{ $user->name }}</h5>
                            <span class="badge jobpost-badge">{{ $user->role }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role-specific Tabs -->
            @if($user->role === 'JobSeeker')
            @include('partials.profile_tabs_jobseeker', ['user' => $user, 'applications' => $applications ?? collect()])
            @elseif($user->role === 'Employer')
            @include('partials.profile_tabs_employer', ['user' => $user, 'jobPosts' => $jobPosts ?? collect()])
            @endif

        </div>
    </div>
</div>
@endsection