@extends('layouts.app')

@section('title', 'Admin - Applications Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            <h3 class="mb-3">Applications</h3>
            <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" class="button button-outline mb-3">Back to Admin Dashboard</a>
            <p class="mb-3"><strong>Total Applications:</strong> {{ $applicationCount }}</p>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <form action="{{ route('admin.applications.search') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by jobseeker, job title, status or motivation" value="{{ $search ?? '' }}" required>
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
                                <tr>
                                    <th>ID</th>
                                    <th>Jobseeker</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Blocked</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $application->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $application->status }}</td>
                                    <td>{{ $application->date }}</td>
                                    <td>
                                        @if($application->isBlocked()) Yes
                                        @else No
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 admin-actions">
                                            <a href="{{ route('admin.application.show', $application->id) }}" class="button button-sm">View Application</a>
                                            <a href="{{ route('profile.other', $application->jobseeker_id) }}" class="button button-sm">View Jobseeker</a>
                                            <a href="{{ route('jobpost.show', $application->jobpost_id) }}" class="button button-sm">View JobPost</a>
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
                    <p class="mb-0">No applications found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection