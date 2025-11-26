@extends('layouts.app')

@section('Results')

@section('content')
    <h2>Results for: "{{$query }}"</h2>

    @if($jobPosts->isEmpty() && $employers->isEmpty())
        <p>No results.</p>
    @else
        @if($type=='search_jobpost')
            <ul>
            @foreach ($jobPosts as $jobpost)
                <a href="{{ route('jobpost.show', $jobpost->id) }}">
                    @include('partials.jobpost', ['jobPost' => $jobpost])  
                </a>
            @endforeach
            </ul>
        @else
            @foreach ($employers as $employer)
            
                {{--<a href="{{ route('profile.show', $employer->id) }}">--}}

                <h2>{{$employer->name}} </h2>
                <p>Email: {{$employer->email}}</p>
            @endforeach
        @endif

    @endif
@endsection
