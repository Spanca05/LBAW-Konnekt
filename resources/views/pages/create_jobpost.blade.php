@extends('layouts.app')

@section('title', 'Create Job Post | ' . config('app.name'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h1 class="h4 mb-4">Create Job Post</h1>

                    <form method="POST" action="{{ route('jobpost.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                required
                                placeholder="ex:Designer"
                                class="form-control @error('title') is-invalid @enderror"
                            >
                            @error('title')
                                <div class="invalid-feedback" id="title-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea
                                id="description"
                                name="description"
                                required
                                placeholder="Small description about the work"
                                class="form-control @error('description') is-invalid @enderror"
                            ></textarea>
                            @error('description')
                                <div class="invalid-feedback" id="description-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary:</label>
                            <input
                                type="number"
                                id="salary"
                                name="salary"
                                required
                                placeholder="ex:12000"
                                class="form-control @error('salary') is-invalid @enderror"
                            >
                            @error('salary')
                                <div class="invalid-feedback" id="salary-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input
                                id="location"
                                type="text"
                                name="location"
                                value=""
                                autocomplete="street-address"
                                placeholder="ex:Porto"
                                class="form-control @error('location') is-invalid @enderror"
                            >
                            @error('location')
                                <div class="invalid-feedback" id="location-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category:</label>
                            <select
                                name="category_id"
                                id="category_id"
                                required
                                class="form-select @error('category_id') is-invalid @enderror"
                            >
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
                                <div class="invalid-feedback" id="category_id-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="work_model" class="form-label">Work Model:</label>
                            <select
                                name="work_model"
                                id="work_model"
                                required
                                class="form-select @error('work_model') is-invalid @enderror"
                            >
                                <option value="Remote">Remote</option>
                                <option value="On-site">On-site</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                            @error('work_model')
                                <div class="invalid-feedback" id="work_model-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline:</label>
                            <input
                                type="datetime-local"
                                id="deadline"
                                name="deadline"
                                class="form-control @error('deadline') is-invalid @enderror"
                            >
                            @error('deadline')
                                <div class="invalid-feedback" id="deadline-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contract_type" class="form-label">Contract Type:</label>
                            <select
                                name="contract_type"
                                id="contract_type"
                                required
                                class="form-select @error('contract_type') is-invalid @enderror"
                            >
                                <option value="Internship">Internship</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                            </select>
                            @error('contract_type')
                                <div class="invalid-feedback" id="contract-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <button type="submit" class="button">Create</button>
                            <a class="button" href="{{ url()->previous() }}">Go Back</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
