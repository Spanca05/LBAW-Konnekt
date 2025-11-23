@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
    <section id="jobpost">
        @auth
            @if(Auth::id() === $jobPost->employer_id)
                <form method="POST" action="{{ route('jobpost.delete', ['jobpost' => $jobPost->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="delete-button" onclick="return confirm('Do you want to delete?');">Delete</button>
                </form>
            @endif
        @endauth

        @include('partials.jobpost', ['jobPost' => $jobPost])
        <p class="description">Description: {{ $jobPost->description }} </p>
        @auth
            @if(Auth::user()->role === 'JobSeeker')
                <a href="{{ route('jobpost.apply.form', ['jobpost' => $jobPost->id]) }}"><button class="apply-button">Apply Now</button></a>
            @endif
        @else
            <a href="{{ route('login') }}" class="apply-button">Login to apply</a>
        @endauth

        @auth
            @if(Auth::id() === $jobPost->employer_id)
                <a href="{{ route('jobpost.edit', ['jobpost' => $jobPost->id]) }}"><button class="edit-button">Edit</button></a>
            @endif
        @endauth
        <a href="{{ route('pages.jobposts.index') }}" ><button class="return" >return</button></a>
    </section>

@endsection