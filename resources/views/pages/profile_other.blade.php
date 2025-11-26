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
    </ul>

    @if(isset($jobPosts) && $jobPosts->isNotEmpty())
    <section class="card">
        <h3>Job Posts by {{ $other->name }}</h3>
        <ul>
            @foreach($jobPosts as $job)
            <li>
                <a href="{{ route('jobpost.show', ['jobpost' => $job->id]) }}">{{ $job->title }}</a>
                <p>
                    Salary:{{ $job->salary }} <br>
                    Work Model: {{ $job->work_model }} <br>
                    Category ID: {{ $job->category_id }}  
                </p>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    <p><a class="button" href="{{ route('pages.jobposts.index') }}">return</a></p>
</section>
@endsection