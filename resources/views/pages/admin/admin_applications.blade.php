@extends('layouts.app')

@section('title', 'Admin - Applications Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            
            <h1 class="mb-3">Applications Management</h1>
            
            <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" class="btn btn-secondary mb-3"style="color:white">Back to Admin Dashboard</a>

            
            <p class="mb-3"><strong>Total Applications:</strong> {{ $applicationCount }}</p>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <form action="{{ route('admin.applications.search') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by jobseeker, job title or status" value="{{ $search ?? '' }}" required>
                        <button type="submit" class="button">Search</button>
                        <a href="{{ route('admin.applications') }}" class="button button-outline">Clear</a>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-3">
                    @if($applicationCount > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="fs-3">
                                    <th class="px-4 ">ID</th>
                                    <th >Jobseeker</th>
                                    <th >Status</th>
                                    <th >Date</th>
                                    <th >Blocked</th>
                                    <th >Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td class="fs-4 px-4 fw-semibold">{{ $application->id }}</td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center gap-2 fs-4 fw-semibold">
                                            <span>{{ $application->user->name }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="fs-5">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    
                                    <td class="fs-5">{{ $application->date }}</td>
                                    
                                    <td class="fs-5">
                                        @if($application->isBlocked())
                                            <span class="badge bg-danger">Blocked</span>
                                        @else
                                            <span class="badge bg-success bg-opacity-75">Active</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 admin-actions" style="letter-spacing: 0.5px;">
                                            
                                            <a href="{{ route('admin.application.show', $application->id) }}" class="button ">
                                                View Application
                                            </a>
                                            
                                            <a href="{{ route('profile.other', $application->jobseeker_id) }}" class="button " style="background-color: cornflowerBlue;">
                                                Jobseeker
                                            </a>
                                            
                                            <a href="{{ route('jobpost.show', $application->jobpost_id) }}" class="button " style="background-color:grey">
                                                JobPost
                                            </a>
                                            
                                            <form method="POST" action="{{ route('admin.deleteApplication', $application->id) }}" onsubmit="return confirm('Are you sure you want to delete this application?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="button button-danger button-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-center">
                        {{ $applications->links() }}
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <p class="mb-0 fs-5">No applications found.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection