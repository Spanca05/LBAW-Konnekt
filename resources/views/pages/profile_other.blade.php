@extends('layouts.app')

@section('title', 'Profile | ' . ($other->name))

@section('content')
<section class="container">
    <h2>Profile: {{ $other->name }}</h2>

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
                <section>
                    <span class="salary">Salary:{{ $job->salary }}€</span>
                    <span class="work_model">Work Model: {{ $job->work_model }}</span>
                    <span class="category">Category ID: {{ $job->category_id }}</span>  
                </section>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    <p><a class="button" href="{{ route('pages.jobposts.index') }}">return</a></p>
</section>
@endsection