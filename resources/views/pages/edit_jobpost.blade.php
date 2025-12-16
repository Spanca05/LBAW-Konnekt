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
               value="{{ old('title', $jobPost->title) }}" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required>{{ old('description', $jobPost->description) }}</textarea>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" 
               value="{{ old('salary', $jobPost->salary) }}" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" 
               value="{{ old('location', $jobPost->location) }}" 
               autocomplete="street-address">

        <label for="work_model">Work Model:</label>
        <select name="work_model" id="work_model" required>
            <option value="Remote" {{ old('work_model', $jobPost->work_model) == 'Remote' ? 'selected' : '' }}>Remote</option>
            <option value="On-site" {{ old('work_model', $jobPost->work_model) == 'On-site' ? 'selected' : '' }}>On-site</option>
            <option value="Hybrid" {{ old('work_model', $jobPost->work_model) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ old('category_id', $jobPost->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="deadline">Deadline:</label>
        <input
            type="datetime-local"
            id="deadline"
            name="deadline"
            value="{{ old('deadline', $jobPost->deadline) }}"
        >

        @error('deadline')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Update</button>
    </form>
</section>
@endsection
