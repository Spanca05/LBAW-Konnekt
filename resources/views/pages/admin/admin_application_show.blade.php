@extends('layouts.app')

@section('title', 'Admin - Application Details')

@section('content')
<div>
    <h2>Application of {{ $application->user->name}} for {{ $application->jobPost->title}}</h2>
    <a href="{{ route('admin.applications') }}" class="button button-outline">Back to Applications</a>

    <div style="margin-top: 1rem;">
        <p><strong>JobPost:</strong> {{ $application->jobPost->title }} (ID: {{ $application->jobpost_id }})</p>
        <p><strong>Jobseeker:</strong> {{ $application->user->name }} (ID: {{ $application->jobseeker_id }})</p>
        <p><strong>Status:</strong> {{ $application->status }}</p>
        <p><strong>Date:</strong> {{ $application->date }}</p>
        <p><strong>Motivation:</strong> {{ $application->motivation }}</p>
    </div>
</div>
@endsection
