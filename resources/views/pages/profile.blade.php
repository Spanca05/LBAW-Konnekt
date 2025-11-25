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
        <li><strong>Name:</strong> {{ $user->name}}</li>
        <li><strong>Email:</strong> {{ $user->email}}</li>
        <li><strong>Phone:</strong> {{ $user->phone_number}}</li>
    </ul>
    
    <p>
        <a class="button" href="{{ route('profile.edit') }}">Edit profile</a>   
    </p>
    @if ($user->role === 'JobSeeker')
        <section class="card">
            <h2>My Applications</h2>
                @if(isset($applications) && $applications->isNotEmpty())
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
                    @else
                        <p>You have not applied to any jobs yet.</p>
                    @endif
        </section>

    @elseif($user->role === 'Employer')
        <section id="jobposts">
            <h3>My JobPosts</h3>
            @if (isset($jobPosts) && $jobPosts->isNotEmpty())
                @foreach ($jobPosts as $jobPost)
                    {{-- Mostra cada job usando o partial --}}
                    @include('partials.jobpost', ['jobPost' => $jobPost])
                @endforeach
            @else
                <p>You have not created any job posts.</p>
            @endif
        </section>
        <p>
            <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>
        </p>
    @endif
</section>

@endsection
