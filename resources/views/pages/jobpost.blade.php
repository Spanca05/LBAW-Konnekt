@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">


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

            @include('partials.jobpost', [
            'jobPost' => $jobPost,
            'variant' => 'detail',
            'description' => $jobPost->description,
            'hasApplied' => $hasApplied,
            'application' => $myApplication,
            ])

            
            
            @include('partials.applications_received', ['jobPost' => $jobPost, 'applications' => $applications])
        </div>
    </div>
</div>

@endsection

<!--
@include('partials.jobpost', ['jobPost' => $jobPost])

    @if($jobPost->jobCategory && $jobPost->jobCategory->skills->isNotEmpty())
        <span class="skills"><b>Skills required:</b>
        <ul>
            @foreach($jobPost->jobCategory->skills as $skill)
                <li><span class="skill_name">{{ $skill->name }}</span></li>
            @endforeach
        </ul>
        </span>
    @endif

    <p class="description"><b>Description:</b> {{ $jobPost->description }} </p>
    <p>
        <strong>Deadline:</strong>
        @if($jobPost->deadline)
            {{ $jobPost->deadline->format('d M Y, H:i') }}
        @else
            None
        @endif
    </p>
            -->