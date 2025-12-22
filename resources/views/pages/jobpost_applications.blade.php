@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card rounded-3 shadow">
                <div class="card-body p-5 p-md-6">
                    <h1 class="mb-4">Applications for: {{ $jobpost->title }}</h1>

                    @if($applications->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No applications received yet.
                    </div>
                    @else
                    <div class="mb-4 p-3 bg-light rounded">
                        <strong style="color: #547792;">{{ $applications->count() }}</strong> application(s) received
                    </div>

                    <div class="list-group">
                        @foreach($applications as $app)
                        <div class="list-group-item mb-3 p-3 bg-light rounded">
                            <div class="d-flex w-100 justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">
                                        <i class="fas fa-user me-2"></i>{{ $app->user->name }}
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i>{{ $app->user->email }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $app->status === 'Accepted' ? 'bg-success' : ($app->status === 'Rejected' ? 'bg-danger' : 'bg-secondary') }}">
                                        {{ $app->status ?? 'Pending' }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        @php
                                        try {
                                        $date = new DateTime($app->date ?? '');
                                        echo $date->format('M d, Y H:i');
                                        } catch (Exception $e) {
                                        echo $app->date ?? 'N/A';
                                        }
                                        @endphp
                                    </small>
                                </div>
                            </div>

                            @if($app->motivation)
                            <div class="mb-3">
                                <strong style="color: #547792;">Motivation:</strong>
                                <p class="mb-0 mt-2 p-3 rounded" style="background-color: white;">{{ $app->motivation }}</p>
                            </div>
                            @endif

                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('profile.other', ['id' => $app->jobseeker_id]) }}" class="button button-outline">
                                    <i class="fas fa-user me-1"></i>View Profile
                                </a>
                                @if($app->status === 'Accepted')
                                <a href="{{ route('applications.conversation', ['application' => $app->id]) }}" class="button">
                                    <i class="fas fa-comments me-1"></i>Chat
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('jobpost.show', $jobpost) }}" class="button button-outline">
                            <i class="fas fa-arrow-left me-1"></i>Back to Job Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection