@extends('layouts.app')

@section('title', 'Edit Job Post | ' . config('app.name'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">

                    <h1 class="mb-4">Edit Job Post</h1>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('jobpost.update', ['jobpost' => $jobPost->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title"  
                                   value="{{ old('title', $jobPost->title) }}" required
                                   placeholder="ex: Designer"
                                   class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" required
                                      placeholder="Small description about the work"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4">{{ old('description', $jobPost->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" id="salary" name="salary"
                                       value="{{ old('salary', $jobPost->salary) }}" required
                                       placeholder="ex: 12000"
                                       class="form-control @error('salary') is-invalid @enderror">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" id="location" name="location"
                                       value="{{ old('location', $jobPost->location) }}"
                                       placeholder="ex: Porto"
                                       class="form-control @error('location') is-invalid @enderror"
                                       autocomplete="street-address">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-12 col-md-6">
                                <label for="work_model" class="form-label">Work Model</label>
                                <select name="work_model" id="work_model"
                                        class="form-select @error('work_model') is-invalid @enderror" required>
                                    <option value="Remote" {{ old('work_model', $jobPost->work_model) == 'Remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="On-site" {{ old('work_model', $jobPost->work_model) == 'On-site' ? 'selected' : '' }}>On-site</option>
                                    <option value="Hybrid" {{ old('work_model', $jobPost->work_model) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('work_model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="contract_type" class="form-label">Contract Type</label>
                                <select name="contract_type" id="contract_type"
                                        class="form-select @error('contract_type') is-invalid @enderror" required>
                                    <option value="Internship" {{ old('contract_type', $jobPost->contract_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="Full-time" {{ old('contract_type', $jobPost->contract_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('contract_type', $jobPost->contract_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                </select>
                                @error('contract_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $jobPost->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="datetime-local" id="deadline" name="deadline"
                                   value="{{ old('deadline', $jobPost->deadline) }}"
                                   class="form-control @error('deadline') is-invalid @enderror">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <button type="submit" class="button">Update</button>
                            <a href="{{ url()->previous() }}" class="button button-outline">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
