@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
<section id="jobpost">
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

    {{--  MUDAR ISTO EM BAIXO PARA CONTROLLER E POLICIES  --}}

    @php
    $myApplication = null;
    if (Auth::check()) {
        $myApplication = \App\Models\Application::where('jobpost_id', $jobPost->id)
            ->where('jobseeker_id', Auth::id())
            ->first();
    }
    $hasApplied = (bool) $myApplication;
    @endphp

    @include('partials.jobpost', ['jobPost' => $jobPost])
    <p class="description">Description: {{ $jobPost->description }} </p>

    <p>
        <strong>Deadline:</strong>
        @if($jobPost->deadline)
            {{ $jobPost->deadline->format('d M Y, H:i') }}
        @else
            None
        @endif
    </p>

    
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

        @if(auth()->check() && auth()->user()->role === 'JobSeeker')
            <form action="{{ route('jobpost.favourite', $jobPost->id) }}" method="POST">
                @csrf
                <button type="submit" class="favourite-button">
                    @if(auth()->user()->favouriteJobs->contains($jobPost->id))
                        ★ Remove Favourite
                    @else
                        ☆ Add to Favourite
                    @endif
                </button>
            </form>
        @endif

    @else
        <a href="{{ route('login') }}" class="apply-button"><button>Login to apply</button></a>
    @endauth

    @include('partials.applications_received', ['jobPost' => $jobPost, 'applications' => $applications])

    <a href="{{ url()->previous() }}"><button class="return">return</button></a>
</section>

@endsection