@extends('layouts.app')

@section('Results')

@section('content')
    <h2>Results for: "{{$query }}"</h2>

    @if($jobPosts->isEmpty())
        <p>No results.</p>
    @else
        <ul>
        @foreach ($jobPosts as $jobpost)
            <a href="{{ route('jobpost.show', $jobpost->id) }}">
                @include('partials.jobpost', ['jobPost' => $jobpost])  
            </a>
        @endforeach
        </ul>
    @endif
@endsection
