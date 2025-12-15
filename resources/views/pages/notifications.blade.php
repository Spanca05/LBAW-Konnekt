@extends('layouts.app')

@section('title', 'Notifications | ' . config('app.name'))

@section('content')
    <h1>Notifications</h1>

    @if($notifications->isEmpty())
        <p>You don't have notifications</p>
    @else

        @if($unreadNotifications > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST" >
                @csrf
                <button type="submit" class="button">Mark All as Read</button>
            </form>
        @endif

        <div id="notifications_list">
            @foreach($notifications as $notification)
                <div style="margin-bottom: 1rem; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;
                        background-color: {{ $notification->pivot->seen ? '#fff' : '#f9f0ff' }}">
                    
                    <div style="display:flex; justify-content: space-between; align-items: center;">
                        <span>
                            <strong>{{ $notification->type }}</strong>
                            @if($notification->jobPost)
                                <a href="{{ route('jobpost.show', ['jobpost' => $notification->jobPost->id]) }}">
                                    {{ $notification->title }}
                                </a>
                            @else
                                {{ $notification->title }}
                            @endif
                            <small style="color: #999;">({{ $notification->date->format('d M Y H:i') }})</small>
                        </span>

                        <div>
                            @if(!$notification->pivot->seen)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="button button-outline">Mark as Read</button>
                                </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-outline" style="color:red;">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

