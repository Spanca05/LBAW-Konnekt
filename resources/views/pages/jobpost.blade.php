@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
    <section id="jobpost">
        @include('partials.jobpost', ['jobPost' => $jobPost])
        <p class="description">Description {{ $jobPost->description }} </p>
        <button class="apply-button">Apply Now</button>
        <a href="{{ route('pages.jobposts.index') }}"><button class="apply-button">Edit</button></a>
        <a href="{{ route('pages.jobposts.index') }}" ><button class="return" >return</button></a>
    </section>

@endsection