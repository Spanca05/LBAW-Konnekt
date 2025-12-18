@extends('layouts.app')

@section('title', 'Edit Job Post | ' . config('app.name'))

@section('content')
<section id="edit_jobpost">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('jobpost.update', ['jobpost' => $jobPost->id]) }}">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" id="title" name="title"  
               value="{{ old('title', $jobPost->title) }}" required placeholder="ex:Designer">
        @error('title')
            <span class="error" id="title" role="alert">{{ $message }}</span>
        @enderror

        <label for="description">Description:</label>
        <textarea id="description" name="description" required placeholder="Small description about the work">{{ old('description', $jobPost->description) }}</textarea>
        @error('description')
            <span class="error" role="alert" id="description-error">{{ $message }}</span>
        @enderror

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" 
               value="{{ old('salary', $jobPost->salary) }}" required placeholder="ex:12000">
        @error('salary')
            <span class="error" id="salary-error" role="alert">{{ $message }} </span>
        @enderror

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" 
               value="{{ old('location', $jobPost->location) }}" 
               autocomplete="street-address"
               placeholder="ex:Porto"
               class="location">
        @error('location')
            <span class="error" id="locarion-error" role="alert">{{ $message }}</span>
        @enderror


        <label for="work_model">Work Model:</label>
        <select name="work_model" id="work_model" required >
            <option value="Remote" {{ old('work_model', $jobPost->work_model) == 'Remote' ? 'selected' : '' }}>Remote</option>
            <option value="On-site" {{ old('work_model', $jobPost->work_model) == 'On-site' ? 'selected' : '' }}>On-site</option>
            <option value="Hybrid" {{ old('work_model', $jobPost->work_model) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
        @error('work_model')
            <span class="error" id="work_model-error" role="alert">{{ $message }} </span>
        @enderror

        <label for="contract_type">Contract Type:</label>
        <select name="contract_type" id="contract_type" required >
            <option value="Internship" {{ old('contract_type', $jobPost->contract_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
            <option value="Full-time" {{ old('contract_type', $jobPost->contract_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
            <option value="Part-time" {{ old('contract_type', $jobPost->contract_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
        </select>
        @error('contract_type')
            <span class="error" role="alert" id="contract_type-error">{{ $message }} </span>
        @enderror

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required >
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ old('category_id', $jobPost->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <span class="error" role="alert" id="category_id-error">{{ $message }} </span>
        @enderror

        <label for="deadline">Deadline:</label>
        <input
            type="datetime-local"
            id="deadline"
            name="deadline"
            value="{{ old('deadline', $jobPost->deadline) }}"
        >

        @error('deadline')
            <span class="error" role="alert" id="deadline-error">{{ $message }}</span>
        @enderror

        <button type="submit">Update</button>
    </form>
</section>
@endsection
