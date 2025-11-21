@extends('layouts.app')

@section('title', $jobpost->title . ' | ' . config('app.name'))

@section('content')
    <section id="jobpost">
        {{-- Render a single jobpost using the partial --}}
        @include('partials.jobpost', ['jobpost' => $jobpost])
    </section>
@endsection
