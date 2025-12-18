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

            @auth
                @if(Auth::user()->role === 'JobSeeker')
                    @if(!$hasApplied)
                        <a href="{{ route('jobpost.apply.form', ['jobpost' => $jobPost->id]) }}"><button class="apply-button">Apply Now</button></a>
                    @else
                        <button class="apply-button" disabled>Already applied</button>
                        @if($myApplication)
                            <a class="button" href="{{ route('applications.edit', ['application' => $myApplication->id]) }}">Edit application</a>
                        @endif
                    @endif
                @elseif(Auth::id() === $jobPost->employer_id)
                    <a href="{{ route('jobpost.edit', ['jobpost' => $jobPost->id]) }}"><button class="edit-button">Edit</button></a>
                @endif
            @else
                <a href="{{ route('login') }}" class="apply-button"><button>Login to apply</button></a>
            @endauth
            
            @include('partials.applications_received', ['jobPost' => $jobPost, 'applications' => $applications])
            
            <a href="{{ url()->previous() }}"><button class="return">return</button></a>

        </div>
    </div>
</div>

@endsection