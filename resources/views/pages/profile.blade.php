@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">

            <h3 class="mb-3 h1">
                @if(auth()->check() && auth()->id() === $user->id)
                    My Profile
                @else
                    {{ $user->name }}'s Profile
                @endif
            </h3>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3 d-flex align-items-center gap-3">

                    <div>
                        <img
                            src="{{ $user->avatarUrl() }}"
                            alt="Profile Picture of {{ $user->name }}"
                            class="avatar"
                            style="width: 64px; height: 64px; object-fit: cover;">
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h5 class="mb-0 h2">{{ $user->name }}</h5>
                        
                        <span class="badge jobpost-badge fs-5">{{ $user->role }}</span>
                    </div>
                </div>
            </div>

            @if($user->role === 'JobSeeker')
                <div class="mb-4">
                    @include('partials.profile_tabs_jobseeker', ['user' => $user, 'applications' => $applications ?? collect()])
                </div>
            @elseif($user->role === 'Employer')
                <div class="mb-4">
                    @include('partials.profile_tabs_employer', ['user' => $user, 'jobPosts' => $jobPosts ?? collect()])
                </div>
            @endif
        </div>
    </div>
</div>
@endsection