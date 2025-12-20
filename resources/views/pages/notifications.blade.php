@extends('layouts.app')

@section('title', 'Notifications | ' . config('app.name'))

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Notifications</h1>

    @if($notifications->isEmpty())
        <div class="alert alert-info" role="alert">
            You don't have notifications.
        </div>
    @else

        @if($unreadNotifications > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="button">Mark All as Read</button>
            </form>
        @endif

        <div class="row justify-content-center g-3">
            @foreach($notifications as $notification)
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="card w-75 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $notification->type }}</strong>
                                @if($notification->jobPost)
                                    <a href="{{ route('jobpost.show', ['jobpost' => $notification->jobPost->id]) }}">
                                        {{ $notification->title }}
                                    </a>
                                @else
                                    {{ $notification->title }}
                                @endif
                                <br>
                                <small class="text-muted">{{ $notification->date->format('d M Y H:i') }}</small>
                            </div>

                            <div class="d-flex gap-2">
                                @if(!$notification->pivot->seen)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-info">Mark as Read</button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
</div>
@endsection
