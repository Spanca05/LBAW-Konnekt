@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="profile_info">
    @if(auth()->check() && auth()->id() === $user->id)
    <h2>My Profile</h2>
    @else
    <h2>{{ $user->name }}'s Profile</h2>
    @endif

    @if(!empty($user->photo_url))
    <div style="margin-bottom: 1rem">
        <img
            src="{{ $user->photo_url }}"
            alt="Profile Picture of {{ $user->name }}"
            style="max-width: 150px; max-height:150px; object-fit:cover; border-radius:6px;">
    </div>
    @else
    <div style="margin-bottom:1rem">
        <img
            src="{{ asset('images/avatar-placeholder.png') }}"
            alt="No photo"
            style="max-width:150px; max-height:150px; object-fit:cover; border-radius:6px;"> 
    </div>
    @endif

    <ul>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        <li><strong>Role:</strong> {{ $user->role}}</li>

        @if(!empty($user->location))
            <li><strong>Location:</strong> {{ $user->location }}</li>
        @else
            <li><strong>Location:</strong> Not specified</li>
        @endif

        @if($user->role === 'JobSeeker')
            <li>
                <strong>Skills:</strong>
            @if($user->skills && count($user->skills))
                <ul>
                @foreach($user->skills as $skill)
                    <li>{{ $skill->name}}</li>
                @endforeach
                </ul>
            @else
                <p>You have no Skills</p>
            @endif
            </li>
        @endif

        @if($user->role === 'JobSeeker' && (optional($user->cv)->file_path || optional($user->cv)->description))
        <li>
            <strong>CV:</strong>
            @if(optional($user->cv)->file_path)
            <a class="button" href="{{ route('profile.cv.download') }}">Download CV</a>
            @endif
            @if(optional($user->cv)->description)
            <div style="margin-top:0.5rem">{{ $user->cv->description }}</div>
            @endif
        </li>
        @endif
        
    </ul>

    <p>
        @if(auth()->check() && auth()->id() === $user->id)
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>
        @if(auth()->user()->role === 'Employer')
        <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
        @endif
        @endif
    </p>

    @if ($user->role === 'JobSeeker')
    <section class="card">
        <h2>My Applications</h2>
        @if(isset($applications) && $applications->isNotEmpty())
        <ul>
            @foreach($applications as $app)
            <li>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <a href="{{ route('jobpost.show', ['jobpost' => $app->jobPost->id ?? $app->jobpost_id]) }}">
                            {{ $app->jobPost->title ?? ('Job #' . ($app->jobpost_id ?? '')) }}
                        </a>
                        <div class="muted">Submitted: {{ $app->date ?? '' }} — Status: {{ $app->status ?? '' }}</div>
                        @if(!empty($app->motivation))
                        <p>{{ Illuminate\Support\Str::limit($app->motivation, 250) }}</p>
                        @endif
                    </div>
                    <div style="display:flex;gap:8px">
                        <a class="button" href="{{ route('applications.edit', ['application' => $app->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('applications.destroy', ['application' => $app->id]) }}" onsubmit="return confirm('Withdraw this application?');">
                            @csrf
                            @method('DELETE')
                            <button class="button" type="submit">Withdraw</button>
                        </form>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <p>You have not applied to any jobs yet.</p>
        @endif
    </section>
    @elseif($user->role === 'Employer')
    <section id="jobposts">
        @if(auth()->check() && auth()->id() === $user->id)
        <h2>My JobPosts</h2>
        @else
        <h2>{{ $user->name }}'s JobPosts</h2>
        @endif

        @if (isset($jobPosts) && $jobPosts->isNotEmpty())
        @foreach ($jobPosts as $jobPost)
        @include('partials.jobpost', ['jobPost' => $jobPost])
        @endforeach
        @else
        <p>You have not created any job posts.</p>
        @endif
    </section>
    @endif

</section>

@endsection