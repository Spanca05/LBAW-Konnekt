@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
<div class="container my-4">
    @if(session('success'))
    <div class="message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="message error">{{ session('error') }}</div>
    @endif

    @auth
    @if(Auth::id() === $jobPost->employer_id)
    <form method="POST" action="{{ route('jobpost.delete', ['jobpost' => $jobPost->id]) }}">
        @csrf
        @method('DELETE')
        <button class="delete-button" onclick="return confirm('Do you want to delete?');">Delete</button>
    </form>
    @endif
    @endauth

    @php
    $myApplication = null;
    if (Auth::check()) {
    $myApplication = \App\Models\Application::where('jobpost_id', $jobPost->id)
    ->where('jobseeker_id', Auth::id())
    ->first();
    }
    $hasApplied = (bool) $myApplication;
    @endphp

    @include('partials.jobpost', ['jobPost' => $jobPost, 'detailed' => true, 'description' => $jobPost->description])


    @auth
    @if(Auth::user()->role === 'JobSeeker')
    @if(!$hasApplied)
    <a class="button" href="{{ route('jobpost.apply.form', ['jobpost' => $jobPost->id]) }}">Apply Now</a>
    @else
    <button class="apply-button" disabled>Already applied</button>
    @if($myApplication)
    <a class="button" href="{{ route('applications.edit', ['application' => $myApplication->id]) }}">Edit application</a>
    @endif
    @endif
    @elseif(Auth::id() === $jobPost->employer_id)
    <a class="button" href="{{ route('jobpost.edit', ['jobpost' => $jobPost->id]) }}">Edit</a>
    @endif
    @else
    <a class="button" href="{{ route('login') }}">Login to apply</a>
    @endauth

    @include('partials.applications_received', ['jobPost' => $jobPost])

    <a class="button mt-4" href="{{ route('pages.jobposts.index') }}">Return</a>
</div>

@endsection