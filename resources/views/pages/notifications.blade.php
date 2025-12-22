@extends('layouts.app')

@section('title', 'Notifications | ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush


@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1>Notifications</h1>
        
        @if(!$notifications->isEmpty() && $unreadNotifications > 0)
            <div class="text-center">
                <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="button">Mark All as Read</button>
                </form>
            </div>
        @endif
    </div>

    @if($notifications->isEmpty())
        <p class="text-center py-4">You don't have any notifications</p>
    @else
        <div class="row g-4" id="notifications-grid">
            @foreach($notifications as $notification)
                <div class="col-12 col-md-6 col-xl-4">
                    <article class="card shadow-sm h-100 notification-card 
                                {{ $notification->pivot->seen ? 'notification-read' : 'notification-unread' }}">
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h6 class="card-title mb-1 notification-title">
                                        @if($notification->jobPost)
                                            <a href="{{ route('jobpost.show', ['jobpost' => $notification->jobPost->id]) }}" 
                                               class="text-decoration-none">
                                                {{ $notification->title }}
                                            </a>
                                        @else
                                            {{ $notification->title }}
                                        @endif
                                    </h6>
                                    <div class="small text-muted">
                                        <span>{{ $notification->type }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="badge jobpost-badge-soft">
                                    {{ $notification->date->format('d M Y') }}
                                </span>
                                <span class="badge jobpost-badge-soft">
                                    {{ $notification->date->format('H:i') }}
                                </span>
                            </div>


                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex gap-2">
                                    @if(!$notification->pivot->seen)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="button w-100">Mark as Read</button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button w-100 btn-delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection