@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<section class="container">
    <h2>Applications for: {{ $jobpost->title }}</h2>

    @if($applications->isEmpty())
        <p>No applications yet.</p>
    @else
        <ul>
            @foreach($applications as $app)
                <li>
                    <strong>{{ $app->user->name }}</strong>
                    <p>{{ $app->motivation }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    <p><a class="button" href="{{ route('jobpost.show', ['jobpost' => $jobpost->id]) }}">Back to job</a></p>
</section>
@endsection
