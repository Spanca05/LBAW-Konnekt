    @extends('layouts.app')

    @section('title', 'Edit Job Post | ' . config('app.name'))

    @section('content')
        <section id="edit_jobpost">
            <form method="POST" action="{{ route('jobpost.update', ['jobpost' => $jobPost->id]) }}">
                @csrf
                @method('PUT')
                <label for="title">Title:</label>   
                <input type="text" id="title" name="title" value="{{ $jobPost->title }}" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required>{{ $jobPost->description }}</textarea>

                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="{{ $jobPost->salary }}" required>

                <label for="location">Location</label>
                <input
                    id="location"
                    type="text"
                    name="location"
                    value="{{ $jobPost->location }}"
                    autocomplete="street-address"
                >
                @error('location')
                <span id="location-error" class="error" role="alert">{{ $message }}</span>
                @enderror

                <label for="work_model">Work Model:</label>
                <select name="work_model" id="work_model" required>
                    <option value= "Remote" {{ $jobPost->work_model == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value= "On-site" {{ $jobPost->work_model == 'On-site' ? 'selected' : '' }}>On-site</option>
                    <option value= "Hybrid" {{ $jobPost->work_model == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>

                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    @foreach ($categories as $category)
                    <option value = "{{$category->name}}" {{$jobPost->jobCategory->name == $category->name ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
                </select>
                <button type="submit">Update</button>
            </form>
        </section>

    @endsection