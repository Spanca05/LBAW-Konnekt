@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="container my-5">
    @if($query!="")
    <h2 class="h2 mb-4">Results for: "{{ $query }}"</h2>
    @endif

    <div class="row g-4">
        {{-- Filters column --}}
        <div class="col-12 col-lg-4">
            @if($type=='search_jobpost')
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h3 class="mb-3">Filter by</h3>

                    <label class="form-label" for="Categories">Category</label>
                    <select class="form-select mb-3 fs-5" name="Categories" id="Categories">
                        <option value='all'>All</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="location">Location</label>
                    <select class="form-select mb-3 fs-5" name="location" id="location">
                        <option value='all'>All</option>
                        @if(empty($location))
                        <option value="no_location" {{ $selectedLocation == 'no_location' ? 'selected' : '' }}>Not specified</option>
                        @endif
                        @foreach($locations as $location)
                        <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="work_model">Work Model</label>
                    <select class="form-select mb-3 fs-5" name="work_model" id="work_model">
                        <option value='all_'>All</option>
                        @foreach($work_models as $model)
                        <option value="{{ $model }}" {{ $selectedWork == $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="contract_type">Contract Type</label>
                    <select class="form-select mb-3 fs-5" name="contract_type" id="contract_type">
                        <option value='all'>All</option>
                        @foreach($contract_type as $contract)
                        <option value="{{ $contract }}" {{ $selectedContract == $contract ? 'selected' : '' }}>{{ $contract }}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="ordem">Sort by</label>
                    <select class="form-select mb-3 fs-5" name="ordem" id="ordem">
                        <option value="relevance" {{ $ordem == 'relevance' ? 'selected' : '' }}>Relevance</option>
                        <option value="Name_A_Z" {{ $ordem == 'Name_A_Z' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="Name_Z_A" {{ $ordem == 'Name_Z_A' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="high" {{ $ordem == 'high' ? 'selected' : '' }}>Salary (high)</option>
                        <option value="low" {{ $ordem == 'low' ? 'selected' : '' }}>Salary (low)</option>
                    </select>

                    <div class="mt-2">
                        <h4 class="h3">Salary Range</h4>
                        <div class="d-flex flex-column flex-sm-row gap-2 align-items-end ">
                            <div class="flex-fill ">
                                <label class="form-label fs-5" for="min-salary">Minimum</label>
                                <input id="min-salary" type="number" class="form-control fs-5" name="min_salary" placeholder="0" min="0" value="{{ $minSalary }}">
                            </div>
                            <div class="flex-fill">
                                <label class="form-label fs-5" for="max-salary">Maximum</label>
                                <input id="max-salary" type="number" class="form-control v" name="max_salary" placeholder="10000000000" min="0" value="{{ $maxSalary }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h3 class="h6 mb-3">Filter by</h3>
                    <label class="form-label" for="location">Location</label>
                    <select class="form-select mb-3" name="location" id="location">
                        <option value='all'>All</option>
                        @if(empty($location))
                        <option value="no_location" {{ $selectedLocation == 'no_location' ? 'selected' : '' }}>Not specified</option>
                        @endif
                        @foreach($locations as $location)
                        <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="ordem">Sort by</label>
                    <select class="form-select" name="ordem" id="ordem">
                        <option value="relevance" {{ $ordem == 'relevance' ? 'selected' : '' }}>Relevance</option>
                        <option value="Name_A_Z" {{ $ordem == 'Name_A_Z' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="Name_Z_A" {{ $ordem == 'Name_Z_A' ? 'selected' : '' }}>Name (Z-A)</option>
                    </select>
                </div>
            </div>
            @endif
        </div>

        {{-- Results column --}}
        <div class="col-12 col-lg-8">
            @if($jobPosts->isEmpty() && $employers->isEmpty())
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="mb-0 text-muted">No results.</p>
                </div>
            </div>
            @else
            @if($type=='search_jobpost')
            <div class="row g-4">
                @foreach ($jobPosts as $jobpost)
                    <div class="col-12 col-sm-6 col-lg-4">
                        @include('partials.jobpost', ['jobPost' => $jobpost])
                    </div>
                @endforeach
            </div>
            @else
            <div class="row g-3">
                @foreach ($employers as $employer)
                <div class="col-12">
                    <a class="text-decoration-none" href="{{ route('employer.show', $employer->id) }}">
                        <div class="card jobpost-card p-3">
                            <h5 class="mb-2 jobpost-title">{{ $employer->name }}</h5>
                            <p class="mb-1 text-muted">Location: {{ $employer->location ?? 'No Location' }}</p>
                            <p class="mb-0 text-muted">Email: {{ $employer->email }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection