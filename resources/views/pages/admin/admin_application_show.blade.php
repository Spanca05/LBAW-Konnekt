@extends('layouts.app')

@section('title', 'Admin - Application Details')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            <h2 class="mb-3">Application Details</h3>
                <a href="{{ route('admin.applications') }}" class="btn btn-secondary mb-3"style="color:white">Back to Applications</a>

                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <h5 class="mb-0">{{ $application->user->name }}</h5>
                            <span class="badge jobpost-badge-soft">Jobseeker</span>
                            <span class="mx-1">applied for</span>
                            <h5 class="mb-0">{{ $application->jobPost->title }}</h5>
                            <span class="badge jobpost-badge-soft">JobPost</span>
                        </div>

                        <p class="mb-2"><strong>Status:</strong> {{ $application->status }}</p>
                        <p class="mb-2"><strong>Date:</strong> {{ $application->date }}</p>
                        <p class="mb-2"><strong>Motivation:</strong> {{ $application->motivation }}</p>
                        <p class="mb-0"><strong>Blocked:</strong>
                            @if($application->isBlocked())
                            <span class="badge jobpost-badge">Yes</span>
                            @else
                            <span class="badge jobpost-badge-soft">No</span>
                            @endif
                        </p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection