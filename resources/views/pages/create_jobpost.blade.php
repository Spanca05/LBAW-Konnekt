@extends('layouts.app')

@section('title', 'Create Job Post | ' . config('app.name'))

@section('content')
    <section id="create_jobpost">
        <form method="POST" action="{{ route('jobpost.store') }}">
            @csrf
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required>
<!--
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
-->
            <select name="category_id" id="category_id" required>
                <option value= "1">Coding</option>
                <option value= "2">Marketing</option>
                <option value= "3">Design</option>
            </select>


            <label for="work_model">Work Model:</label>
            <select name="work_model" id="work_model" required>
                <option value= "Remote">Remote</option>
                <option value= "On-site">On-site</option>
                <option value= "Hybrid">Hybrid</option>
            </select>

            <button type="submit">Create</button>
        </form>
    </section>

@endsection