@extends('layouts.app')

@section('title', 'Edit Job Post | ' . config('app.name'))

@section('content')
    <section id="edit_jobpost">
        <p class="description">Description {{ $jobPost->description }} </p>
        <form method="POST" action="{{ route('jobpost.update', ['jobpost' => $jobPost->id]) }}">
            @csrf
            @method('PUT')

            <label for="title">Title:</label>   
            <input type="text" id="title" name="title" value="{{ $jobPost->title }}" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ $jobPost->description }}</textarea>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" value="{{ $jobPost->salary }}" required>

            <label for="work_model">Work Model:</label>
            <input type="text" id="work_model" name="work_model" value="{{ $jobPost->work_model }}" required>

            <button type="submit">Update Job Post</button>
        </form>
        <button class="apply-button">Apply Now</button>
        <a href="{{ route('pages.jobposts.index') }}"><button class="apply-button">Edit</button></a>
        <a href="{{ route('pages.jobposts.index') }}" ><button class="return" >return</button></a>
    </section>

@endsection