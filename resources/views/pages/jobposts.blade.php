@extends('layouts.app')

@section('content')
<section id="jobposts">
    {{-- Render each jobpost using the partial --}}
    @each('partials.jobpost', $jobposts, 'jobpost')

    {{-- Form for creating a new jobpost --}}
    <article class="card">
        <form class="new_jobpost">
            <input type="text" name="title" placeholder="Job title">
            <input type="text" name="location" placeholder="Location (optional)">
            <input type="text" name="salary" placeholder="Salary (optional)">
            <textarea name="description" placeholder="Description (optional)"></textarea>
            <button type="submit">Create</button>
        </form>
    </article>
</section>

@endsection
