@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
    <section id="jobpost">
        <form method = "POST" action="{{ route('jobpost.delete', ['jobpost' => $jobPost->id]) }}">
            @csrf
            @method('DELETE')
            <button class="delete-button" onclick="return confirm('Do you want to delete?');">Delete</button>
        </form>
        @include('partials.jobpost', ['jobPost' => $jobPost])
        <p class="description">Description: {{ $jobPost->description }} </p>
        <button class="apply-button">Apply Now</button>
        <a href="{{ route('jobpost.edit', ['jobpost' => $jobPost->id]) }}"><button class="apply-button">Edit</button></a>
        <a href="{{ route('pages.jobposts.index') }}" ><button class="return" >return</button></a>
    </section>

@endsection