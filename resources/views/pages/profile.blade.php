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
                                style="width: 64px; height: 64px; object-fit: cover;">
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

<!--   
<section>
        <h3> Favourite Job Posts</h3>
        @if($favourites->isEmpty())
            <p>No favourites yet.</p>
        @else
            <ul>
            @foreach($favourites as $job)
                <li>
                    {{-- Mostra cada job usando o partial --}}
                    @if ($job->employer)
                        @include('partials.jobpost', ['jobPost' => $job])
                    @endif
                </li>
            @endforeach
            </ul>
        @endif
    </section>
    @if($user->role === 'Employer')
        <section id="jobposts">
            @if(auth()->check() && auth()->id() === $user->id)
            <h2>My Active JobPosts</h2>
            @else
            <h2>{{ $user->name }}'s JobPosts</h2>
            @endif

    @if (isset($jobPosts) && $jobPosts->isNotEmpty())
            @foreach ($jobPosts as $jobPost)
            @include('partials.jobpost', ['jobPost' => $jobPost])
            @endforeach
            @else
            <p>You have no active job posts</p>
            @endif
        </section>
        @if(auth()->check() && auth()->id() === $user->id)
            <section id="expired_jobposts">
                <h2>My Expired JobPosts</h2>
                @if (isset($expiredjobPosts) && $expiredjobPosts->isNotEmpty())
                    @foreach ($expiredjobPosts as $expiredjobPost)
                        @include('partials.jobpost', ['jobPost' => $expiredjobPost])
                    @endforeach
                @else
                <p>You have no expired jobPosts</p>
                @endif
            </section>
        @endif
    @endif
</section> 
-->