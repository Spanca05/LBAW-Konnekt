@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
    <section id="jobpost">
        @include('partials.jobpost', ['jobPost' => $jobPost])
        <button class="apply-button">Apply Now</button>
        <button class="apply-button">Edit</button>
        <a href="{{ route('pages.jobposts.index') }}" class="return"><button >return</button></a>
    </section>

@endsection