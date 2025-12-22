@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">
                    <h1 class="mb-4">Application Details</h1>

                    <!-- Job Post Info -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 style="color: #547792;" class="mb-3">
                            <i class="fas fa-briefcase me-2"></i>Job Position
                        </h5>
                        <h6 class="mb-2">{{ $application->jobPost->title }}</h6>
                        <p class="text-muted mb-0">
                            <i class="fas fa-building me-1"></i>
                            {{ $application->jobPost->employer->name ?? 'Unknown Company' }}
                        </p>
                    </div>

                    <!-- Applicant Info -->
                    <div class="mb-4">
                        <h5 style="color: #547792;" class="mb-3">
                            <i class="fas fa-user me-2"></i>Applicant Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Name:</strong><br>
                                <span class="text-muted">{{ $application->user->name }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong><br>
                                <span class="text-muted">{{ $application->user->email }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Applied on:</strong><br>
                                <span class="text-muted">
                                    @php
                                    try {
                                    $date = new DateTime($application->date ?? '');
                                    echo $date->format('M d, Y H:i');
                                    } catch (Exception $e) {
                                    echo $application->date ?? 'N/A';
                                    }
                                    @endphp
                                </span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge {{ $application->status === 'Accepted' ? 'bg-success' : ($application->status === 'Rejected' ? 'bg-danger' : 'bg-secondary') }}">
                                    {{ $application->status ?? 'Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Motivation -->
                    <div class="mb-5">
                        <h5 style="color: #547792;" class="mb-3">
                            <i class="fas fa-comment-dots me-2"></i>Motivation Letter
                        </h5>
                        @if($application->motivation)
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $application->motivation }}</p>
                        </div>
                        @else
                        <p class="text-muted fst-italic">No motivation letter provided.</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 flex-wrap mb-2">
                        <a href="{{ route('profile.other', ['id' => $application->jobseeker_id]) }}" class="button button-outline">
                            <i class="fas fa-user me-1"></i>View Applicant Profile
                        </a>
                        <a href="{{ route('profile') }}" class="button button-outline">
                            <i class="fas fa-arrow-left me-1"></i>Back to Profile
                        </a>
                        @if($application->status === 'Accepted')
                        <a href="{{ route('applications.conversation', ['application' => $application->id]) }}" class="button">
                            <i class="fas fa-comments me-1"></i>Open Chat
                        </a>
                        @endif
                    </div>

                    @if($application->status === 'Pending')
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <form method="POST" action="{{ route('applications.status.update', $application) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Accepted">
                            <button type="submit" class="button" style="background-color: #2ecc71; border-color: #27ae60;">
                                <i class="fas fa-check me-1"></i>Accept
                            </button>
                        </form>
                        <form method="POST" action="{{ route('applications.status.update', $application) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Rejected">
                            <button type="submit" class="button" style="background-color: #e74c3c; border-color: #c0392b;">
                                <i class="fas fa-times me-1"></i>Reject
                            </button>
                        </form>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection