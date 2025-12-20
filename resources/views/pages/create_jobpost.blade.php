@extends('layouts.app')

@section('title', 'Create Job Post | ' . config('app.name'))

@section('content')
    <section id="create_jobpost">
        <form method="POST" action="{{ route('jobpost.store') }}">
            @csrf
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required placeholder="ex:Designer">
            @error('title')
                <span class="error" role="alert" id="title-error">{{ $message }}</span>
            @enderror
            <label for="description">Description:</label>
            <textarea id="description" name="description" required placeholder="Small description about the work"></textarea>
            @error('description')
                <span class="error" id="description-error" role="alert">{{ $message }}</span>
            @enderror
            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required placeholder="ex:12000">
            @error('salary')
                <span class="error" id="salary-error" role="alert">{{ $message }}</span>
            @enderror

            <label for="location">Location</label>
            <input
                id="location"
                type="text"
                name="location"
                value=""
                autocomplete="street-address"
                placeholder="ex:Porto"
            >
            @error('location')
            <span id="location-error" class="error" role="alert">{{ $message }}</span>
            @enderror
        
            Category:
            <select name="category_id" id="category_id" required class="category_id">
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
            @error('category_id')
                <span class="error" id="category_id-error" role="alert">{{ $message }}</span>
            @enderror

            <label for="work_model">Work Model:</label>
            <select name="work_model" id="work_model" required class="work_model">
                <option value= "Remote">Remote</option>
                <option value= "On-site">On-site</option>
                <option value= "Hybrid">Hybrid</option>
            </select>
            @error('work_model')
                <span class="error" id="work_model-error" role="alert">{{ $message }}</span>
            @enderror
            <label for="deadline">Deadline:</label>
            <input
                type="datetime-local"
                id="deadline"
                name="deadline"
            >

            @error('deadline')
                <span class="error" id="deadline-error" role="alert">{{ $message }}</span>
            @enderror
            <label for="contract_type">Contract Type:</label>
            <select name="contract_type" id="contract_type" required class="contract_type">
                <option value= "Internship">Internship</option>
                <option value= "Full-time">Full-time</option>
                <option value= "Part-time">Part-time</option>
            </select>
            @error('contract_type')
                <span id="contract-error" class="error" role="alert">{{ $message }}</span>
            @enderror

        <div class="mt-4">
            <button class="button " type="submit">Create</button>
        </div>
        <div class="mt-4">
            <a class="button " href="{{ url()->previous() }}">Go Back</a>
        </div>
    </form>
</section>

@endsection