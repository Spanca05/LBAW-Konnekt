@extends('layouts.app')

@section('title', 'Profile | ' . ($other->name))

@section('content')
<section class="container">
    <h2>Profile: {{ $other->name }}</h2>

    @if(!empty($other->photo_url))
    <div style="margin-bottom: 1rem">
        <img
            src="{{ $other->photo_url }}"
            alt="Profile Picture of {{ $other->name }}"
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
        <li><strong>Name:</strong> {{ $other->name}}</li>
        <li><strong>Email:</strong> {{ $other->email}}</li>
        <li><strong>Phone:</strong> {{ $other->phone_number}}</li>
        @if(!empty($other->location))
            <li><strong>Location:</strong> {{ $other->location }}</li>
        @else
            <li><strong>Location:</strong>Not specified</li>
        @endif
        <li><strong>Role:</strong> {{ $other->role}}</li>
        @if($other->role === 'JobSeeker')
            <li>
                <strong>Skills:</strong>
            @if($other->skills && count($other->skills))
                <ul>
                @foreach($other->skills as $skill)
                    <li>{{ $skill->name}}</li>
                @endforeach
                </ul>
            @else
                <p>{{ $other->name }} has no Skills</p>
            @endif
            </li>
        @endif
    </ul>

    @if($other->role==='Employer' && isset($jobPosts) && $jobPosts->isNotEmpty())
        <li><strong>Description:</strong>
            @if($other->description !== null)
            <div style="margin-top:0.5rem">{{ $other->description }}</div>
            @else
            No description.
            @endif
        </li>
    </ul>

    @if ($other->role === 'Employer')
    @if(isset($jobPosts) && $jobPosts->isNotEmpty())
    <section class="card">
        <h3>Job Posts by {{ $other->name }}</h3>
        <ul>
            @foreach($jobPosts as $job)
            <li>
                <a href="{{ route('jobpost.show', ['jobpost' => $job->id]) }}"><strong>{{ $job->title }}</strong></a>
                <p>
                    Salary:{{ $job->salary }} <br>
                    Work Model: {{ $job->work_model }} <br>
                    Category: {{ $job->jobCategory->name  }}  
                </p>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    @elseif ($other->role === 'JobSeeker')
    @if(optional($other->cv)->file_path)
    <strong>CV:</strong>
    <a class="button" href="{{ route('profile.cv.download_other', ['user' => $other->id]) }}">Download CV</a>
    @endif
    @endif

    <p><a class="button" href="{{ route('pages.jobposts.index') }}">return</a></p>
</section>
@endsection