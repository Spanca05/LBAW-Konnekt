@extends('layouts.app')

@section('title', 'Job Posts | ' . config('app.name'))

@section('content')
    <h1>Job Posts</h1>

    <section id="jobposts">
        @foreach ($jobPosts as $jobPost)
            {{-- Mostra cada job usando o partial --}}
            @include('partials.jobpost', ['jobPost' => $jobPost])
        @endforeach
    </section>
@endsection