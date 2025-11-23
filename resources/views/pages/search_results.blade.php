@extends('layouts.app')

@section('Results')

@section('content')
    <h2>Results for: "{{$query }}"</h2>

    @if($jobPosts->isEmpty())
        <p>No results.</p>
    @else
        <ul>
        @foreach ($jobPosts as $jobpost)
            <li>
                <a href="{{ route('jobpost.show', $jobpost->id) }}">
                    {{ $jobpost->title }}
                </a>
            </li>
        @endforeach
        </ul>
    @endif
@endsection
