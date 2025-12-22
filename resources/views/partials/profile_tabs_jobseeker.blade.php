<ul class="nav nav-tabs mb-0" id="profileTabs" role="tablist">
    <li class="nav-item m-0" role="presentation">
        <button class="nav-link active fs-5" id="applications-tab" data-bs-toggle="tab" data-bs-target="#applications" type="button" role="tab" aria-controls="applications" aria-selected="true">
            My Applications
        </button>
    </li>
    <li class="nav-item m-0" role="presentation">
        <button class="nav-link fs-5" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">
            Account
        </button>
    </li>
        <li class="nav-item m-0" role="presentation">
        <button class="nav-link" id="favourites-tab" data-bs-toggle="tab" data-bs-target="#favourites" type="button" role="tab" aria-controls="favourites" aria-selected="false">
            Favourite Job Posts
        </button>
    </li>
</ul>

<div class="tab-content border border-top-0 rounded-0 rounded-bottom p-4 bg-white" id="profileTabsContent">

    <div class="tab-pane fade show active" id="applications" role="tabpanel" aria-labelledby="applications-tab">

        @if(isset($applications) && $applications->isNotEmpty())
        <div class="d-flex flex-column gap-3"> @foreach($applications as $app)
            <div class="pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fs-4">
                            <a href="{{ route('jobpost.show', ['jobpost' => $app->jobPost->id ?? $app->jobpost_id]) }}" class="text-decoration-none" style="color: #213448;">
                                {{ $app->jobPost->title ?? ('Job #' . ($app->jobpost_id ?? '')) }}
                            </a>
                        </h5>
                        
                        <div class="text-muted fs-5">
                            Submitted:
                            @php
                            try {
                            $date = new DateTime($app->date ?? '');
                            echo $date->format('Y-m-d H:i');
                            } catch (Exception $e) {
                            echo $app->date ?? 'N/A';
                            }
                            @endphp
                            <span class="mx-1">•</span>
                            <span class="badge {{ $app->status === 'Accepted' ? 'bg-success' : ($app->status === 'Rejected' ? 'bg-danger' : 'badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10') }}">
                                {{ $app->status ?? 'Pending' }}
                            </span>
                        </div>
                        
                        @if(!empty($app->motivation))
                        <p class="mb-0 text-muted mt-2 fs-5">{{ Str::limit($app->motivation, 120) }}</p>
                        @endif
                    </div>

                    <div class="d-flex gap-2 flex-shrink-0">
                        @if($app->status === 'Rejected')
                        <a class="button fs-5 px-4 py-2" href="{{ route('applications.edit', ['application' => $app->id]) }}">Resend</a>
                        @elseif($app->status === 'Pending')
                        <a class="button fs-5 px-4 py-2" href="{{ route('applications.edit', ['application' => $app->id]) }}">Edit</a>

                        @else
                        <a class="button" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" href="{{ route('applications.conversation', ['application' => $app->id]) }}">Chat</a>
                        @endif

                        <form method="POST" action="{{ route('applications.destroy', ['application' => $app->id]) }}" onsubmit="return confirm('Withdraw this application?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="redirect_to" value="{{ route('profile') }}">
                            <button class="button fs-5 px-4 py-2" type="submit">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0 fs-5">No applications yet.</p>
        @endif
    </div>

    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">

        <div class="mb-4">
            <h5 class="mb-3 fs-4" style="color: #213448;">Account Information</h5>
            <div class="row g-3"> <div class="col-12 col-md-6">
                    <div class="fs-5"><strong>Name:</strong> {{ $user->name }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="fs-5"><strong>Email:</strong> {{ $user->email }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="fs-5"><strong>Phone:</strong> {{ $user->phone_number }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="fs-5"><strong>Role:</strong> {{ $user->role }}</div>
                </div>
                <div class="col-12">
                    <div class="fs-5"><strong>Location:</strong> {{ $user->location ?? 'Not specified' }}</div>
                </div>
            </div>
        </div>

        @if($user->description)
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-3 fs-4" style="color: #213448;">About</h5>
            <p class="mb-0 text-muted fs-5">{{ $user->description }}</p>
        </div>
        @endif

        @if($user->skills && count($user->skills) > 0)
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-3 fs-4" style="color: #213448;">Skills</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($user->skills as $skill)
                <span class="badge jobpost-badge-soft fs-5 p-2" title="{{ $skill->description }}">
                    {{ $skill->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        @if(optional($user->cv)->file_path)
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-3 fs-4" style="color: #213448;">CV</h5>
            <a class="button fs-5 px-4" href="{{ route('profile.cv.download') }}">Download CV</a>
        </div>
        @endif

        @if(auth()->check() && auth()->id() === $user->id)
        <div class="pt-3 border-top">
            <h5 class="mb-3 fs-4" style="color: #213448;">Actions</h5>
            <div class="d-flex gap-2 flex-wrap">
                <a class="button" href="{{ route('conversations.index') }}">View Chats</a>
                <a class="button fs-5 px-4" href="{{ route('profile.edit') }}">Edit Profile</a>

                <form action="{{ route('profile.destroy') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="button fs-5 px-4" type="submit" onclick="return confirm('Are you sure you want to delete your account? This action is irreversible.')">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
        @endif
                </div>

        <!-- Favourite Job Posts Tab -->
        <div class="tab-pane fade" id="favourites" role="tabpanel" aria-labelledby="favourites-tab">
            @if($favourites->isEmpty())
                <p class="text-muted mb-0">No favourites yet.</p>
            @else
                <div class="row g-4">
                    @foreach($favourites as $job)
                        @if ($job->employer)
                            <div class="col-12 col-sm-6 col-lg-4">
                                @include('partials.jobpost', ['jobPost' => $job])
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

</div>