@extends('layouts.app')

@section('title', 'Job Posts | ' . config('app.name'))

@section('content')
<h1 class="m-4">Job Posts</h1>
<div class="container">

    <div class="row g-4" id="jobposts">
        @foreach ($jobPosts as $jobPost)
        {{-- Mostra cada job usando o partial --}}
        @if ($jobPost->employer)
        <div class="col-12 col-sm-6 col-lg-4">
            @include('partials.jobpost', ['jobPost' => $jobPost])
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection