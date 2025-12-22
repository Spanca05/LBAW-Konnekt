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

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fs-4">&#127775 Favourite Job Posts</h5>
                </div>
                <div class="card-body">
                    @if($favourites->isEmpty())
                        <p class="text-muted mb-0 fs-5">No favourites yet.</p>
                    @else
                        <div class="row g-4">
                            @foreach($favourites as $job)
                                @if ($job->employer)
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        @include('partials.jobpost', ['jobPost' => $job])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($user->role === 'Employer')
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="jobpostTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fs-5" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">Active JobPosts</button>
                            </li>
                            @if(auth()->check() && auth()->id() === $user->id)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fs-5" id="expired-tab" data-bs-toggle="tab" data-bs-target="#expired" type="button" role="tab">Expired JobPosts</button>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="jobpostTabsContent">

                            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                                @if(isset($jobPosts) && $jobPosts->isNotEmpty())
                                    <div class="row g-4">
                                        @foreach($jobPosts as $jobPost)
                                            <div class="col-12 col-sm-6 col-lg-4">
                                                @include('partials.jobpost', ['jobPost' => $jobPost])
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0 fs-5">You have no active job posts.</p>
                                @endif
                            </div>

                            @if(auth()->check() && auth()->id() === $user->id)
                                <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
                                    @if(isset($expiredjobPosts) && $expiredjobPosts->isNotEmpty())
                                        <div class="row g-4">
                                            @foreach($expiredjobPosts as $expiredjobPost)
                                                <div class="col-12 col-sm-6 col-lg-4">
                                                    @include('partials.jobpost', ['jobPost' => $expiredjobPost])
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0 fs-5">You have no expired job posts.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection