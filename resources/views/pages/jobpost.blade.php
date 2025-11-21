@extends('layouts.app')

@section('title', $jobPost->title . ' | ' . config('app.name'))

@section('content')
    <section id="jobposts">
        {{-- Render a single job post using the partial --}}
        @include('partials.jobpost', ['jobPost' => $jobPost])
    </section>
@endsection