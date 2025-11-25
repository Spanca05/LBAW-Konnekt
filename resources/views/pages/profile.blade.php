@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section class="profile_info">
    @if(auth()->id() === $user->id)
        <h2>My Profile</h2>
    @else
        <h2>{{ $user->name }}'s Profile</h2>
    @endif

    <ul>
        <li><strong>ID:</strong> {{ $user->id}}</li>
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
        <li><strong>Role:</strong> {{ $user->role}}</li>
    </ul>
    
    <p>
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>   
    </p>

    @if(isset($applications) && $applications->isNotEmpty())
        <section class="card">
            <h3>My Applications</h3>
            <ul>
                @foreach($applications as $app)
                    <li>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div>
                                <a href="{{ route('jobpost.show', ['jobpost' => $app->jobPost->id ?? $app->jobpost_id]) }}">
                                    {{ $app->jobPost->title ?? ('Job #' . ($app->jobpost_id ?? '')) }}
                                </a>
                                <div class="muted">Submitted: {{ $app->date ?? '' }} — Status: {{ $app->status ?? '' }}</div>
                                @if(!empty($app->motivation))
                                    <p>{{ Illuminate\Support\Str::limit($app->motivation, 250) }}</p>
                                @endif
                            </div>
                            <div style="display:flex;gap:8px">
                                <a class="button" href="{{ route('applications.edit', ['application' => $app->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('applications.destroy', ['application' => $app->id]) }}" onsubmit="return confirm('Withdraw this application?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button" type="submit">Withdraw</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @else
        @if(isset($user) && $user->role === 'JobSeeker')
            <p>You have not applied to any jobs yet.</p>
        @endif
    @endif
</section>

@if($user->role === 'Employer')
    <p>
        <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
    </p>
    <section id="jobposts">
        @if(auth()->id() === $user->id && $user->role === 'Employer')
            <h2>My JobPosts</h2>
        @elseif($user->role === 'Employer')
            <h2>{{ $user->name }}'s JobPosts</h2>
        @endif

        @foreach ($jobPosts as $jobPost)
            {{-- Mostra cada job usando o partial --}}
            @include('partials.jobpost', ['jobPost' => $jobPost])
        @endforeach

    </section>

@endif


@endsection
