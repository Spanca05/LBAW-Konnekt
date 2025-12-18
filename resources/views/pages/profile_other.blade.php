@extends('layouts.app')

@section('title', 'Profile | ' . ($other->name))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">

            @if($other->isBlocked())
            <div class="card shadow-sm">
                <div class="card-body p-5 text-center">
                    <h2 class="h4 mb-3">This user has been blocked</h2>
                    <p class="text-muted mb-0">Continue searching for other opportunities.</p>
                </div>
            </div>
            @else

            <h3 class="mb-3">{{ $other->name }}'s Profile</h3>

            <!-- Profile Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Photo -->
                        <div>
                            <img
                                src="{{ !empty($other->photo_url) ? $other->photo_url : asset('images/profile-placeholder.png') }}"
                                alt="Profile Picture of {{ $other->name }}"
                                class="rounded"
                                style="width: 64px; height: 64px; object-fit: cover;">
                        </div>

                        <!-- Name and Role -->
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="mb-0">{{ $other->name }}</h5>
                            <span class="badge jobpost-badge">{{ $other->role }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role-specific Tabs -->
            @if($other->role === 'JobSeeker')
            @include('partials.profile_tabs_jobseeker_other', ['user' => $other])
            @elseif($other->role === 'Employer')
            @include('partials.profile_tabs_employer_other', ['user' => $other, 'jobPosts' => $jobPosts ?? collect()])
            @endif

            <!-- Return Button -->
            <div class="mt-4">
                <a class="button button-outline" href="{{ url()->previous() }}">Go Back</a>
            </div>

            @endif
        </div>
    </div>
</div>
@endsection