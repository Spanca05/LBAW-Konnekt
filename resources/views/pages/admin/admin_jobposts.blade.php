@extends('layouts.app')

@section('title', 'Admin - JobPosts Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            <h3 class="mb-3">JobPosts Management</h3>
            <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" class="button button-outline mb-3">Back to Admin Dashboard</a>
            <p class="mb-3"><strong>Total JobPosts:</strong> {{$jobpostCount}}</p>

            <div class="card shadow-sm">
                <div class="card-body p-3">
                    @if($jobpostCount > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Employer</th>
                                    <th>Created Date</th>
                                    <th>Blocked</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobposts as $jobpost)
                                <tr>
                                    <td>{{ $jobpost->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $jobpost->title }}</span>
                                            @if($jobpost->isBlocked())
                                            <span class="badge jobpost-badge">Blocked</span>
                                            @else
                                            <span class="badge jobpost-badge-soft">Active</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $jobpost->employer->name }}</td>
                                    <td>{{ $jobpost->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($jobpost->isBlocked()) Yes
                                        @else No
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 admin-actions">
                                            <a href="{{ route('jobpost.show', $jobpost->id) }}" class="button  button-sm">View JobPost</a>
                                            <a href="{{ route('admin.jobpost.applications', $jobpost->id) }}" class="button  button-sm">View Applications</a>
                                            <form method="POST" action="{{ route('admin.deleteJobPost', $jobpost->id) }}" onsubmit="return confirm('Are you sure you want to delete this jobpost?');">
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
                        {{ $jobposts->links() }}
                    </div>
                    @else
                    <p class="mb-0">No jobposts found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection