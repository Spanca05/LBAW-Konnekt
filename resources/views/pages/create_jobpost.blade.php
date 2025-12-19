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
        @error('salary')
        <span class="error">{{ $message }}</span>
        @enderror

        <label for="location">Location</label>
        <input
            id="location"
            type="text"
            name="location"
            value=""
            autocomplete="street-address">
        @error('location')
        <span id="location-error" class="error" role="alert">{{ $message }}</span>
        @enderror

        Category:
        <select name="category_id" id="category_id" required>
            <option value="1">Coding</option>
            <option value="2">Design</option>
            <option value="3">Marketing</option>
            <option value="4">Finance</option>
            <option value="5">Education</option>
            <option value="6">Healthcare</option>
            <option value="7">Engineering</option>
            <option value="8">HumanResources</option>
            <option value="9">Law</option>
            <option value="10">Management</option>
            <option value="11">Construction</option>
            <option value="12">Science</option>
            <option value="13">Other</option>
        </select>


        <label for="work_model">Work Model:</label>
        <select name="work_model" id="work_model" required>
            <option value="Remote">Remote</option>
            <option value="On-site">On-site</option>
            <option value="Hybrid">Hybrid</option>
        </select>

        <label for="contract_type">Contract Type:</label>
        <select name="contract_type" id="contract_type" required>
            <option value="Internship">Internship</option>
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
        </select>

        <div class="mt-4">
            <button class="button " type="submit">Create</button>
        </div>
        <div class="mt-4">
            <a class="button " href="{{ url()->previous() }}">Go Back</a>
        </div>
    </form>
</section>

@endsection