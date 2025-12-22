<!-- Navigation Tabs -->
<ul class="nav nav-tabs" id="profileTabs" role="tablist">
    <li class="nav-item mb-0" role="presentation">
        <button class="nav-link active" id="jobposts-tab" data-bs-toggle="tab" data-bs-target="#jobposts" type="button" role="tab" aria-controls="jobposts" aria-selected="true">
            My Job Posts
        </button>
    </li>
    <li class="nav-item mb-0" role="presentation">
        <button class="nav-link" id="applications-received-tab" data-bs-toggle="tab" data-bs-target="#applications-received" type="button" role="tab" aria-controls="applications-received" aria-selected="false">
            Applications Received
        </button>
    </li>
    <li class="nav-item mb-0" role="presentation">
        <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">
            Account
        </button>
    </li>
    @if(auth()->check() && auth()->id() === $user->id)
    <li class="nav-item mb-0" role="presentation">
        <button class="nav-link"
            id="expired-tab"
            data-bs-toggle="tab"
            data-bs-target="#expired"
            type="button"
            role="tab"
            aria-controls="expired"
            aria-selected="false">
            Expired Job Posts
        </button>
    </li>
    @endif

</ul>

<!-- Tab Content -->
<div class="tab-content border border-top-0 rounded-0 rounded-bottom p-4 bg-white" id="profileTabsContent">

    <!-- My Job Posts Tab -->
    <div class="tab-pane fade show active" id="jobposts" role="tabpanel" aria-labelledby="jobposts-tab">
        <div class="mb-3">
            <h4>
                @if(auth()->check() && auth()->id() === $user->id)
                My Job Posts
                @else
                {{ $user->name }}'s Job Posts
                @endif
            </h4>
        </div>

        @if(isset($jobPosts) && $jobPosts->isNotEmpty())
        <div class="row g-3">
            @foreach($jobPosts as $jobPost)
            <div class="col-12 col-md-6">
                @include('partials.jobpost', ['jobPost' => $jobPost])
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">No job posts yet.</p>
        @endif
    </div>

    <!-- Applications Received Tab -->
    <div class="tab-pane fade" id="applications-received" role="tabpanel" aria-labelledby="applications-received-tab">
        <h4 class="mb-3">Applications Received</h4>

        @if(isset($jobPosts) && $jobPosts->isNotEmpty())
        @php
        $hasApplications = false;
        foreach($jobPosts as $jobPost) {
        if(isset($jobPost->applications) && $jobPost->applications->isNotEmpty()) {
        $hasApplications = true;
        break;
        }
        }
        @endphp

        @if($hasApplications)
        <div class="d-flex flex-column gap-4">
            @foreach($jobPosts as $jobPost)
            @if(isset($jobPost->applications) && $jobPost->applications->isNotEmpty())
            <div class="border-bottom pb-3">
                <h6 class="mb-2">{{ $jobPost->title }}</h6>
                <div class="small text-muted mb-3">{{ $jobPost->applications->count() }} application(s)</div>

                @foreach($jobPost->applications as $app)
                <div class="d-flex justify-content-between align-items-center gap-3 mb-2 p-2 {{ $loop->iteration % 2 === 0 ? 'bg-light' : '' }}">
                    <div class="flex-grow-1">
                        <div class="small">
                            <strong>{{ $app->jobSeeker->name ?? 'Unknown' }}</strong>
                        </div>
                        <div class="small text-muted">
                            Applied:
                            @php
                            try {
                            $date = new DateTime($app->date ?? '');
                            echo $date->format('Y-m-d H:i');
                            } catch (Exception $e) {
                            echo $app->date ?? 'N/A';
                            }
                            @endphp
                            <span class="mx-1">•</span>
                            <span class="badge {{ $app->status === 'Accepted' ? 'bg-success' : ($app->status === 'Rejected' ? 'bg-danger' : 'bg-secondary') }}">
                                {{ $app->status ?? 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        @if($app->status === 'Accepted')
                        <a class="button" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" href="{{ route('applications.conversation', ['application' => $app->id]) }}">Chat</a>
                        @endif
                        <a class="button" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" href="{{ route('applications.show', $app) }}">View</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">No applications received yet.</p>
        @endif
        @else
        <p class="text-muted mb-0">No job posts yet. Create one to receive applications.</p>
        @endif
    </div>

    <!-- Account Tab -->
    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">

        <!-- Account Information Section -->
        <div class="mb-4">
            <h5 class="mb-3" style="color: #213448;">Account Information</h5>
            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Name:</strong> {{ $user->name }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Email:</strong> {{ $user->email }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Phone:</strong> {{ $user->phone_number }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Role:</strong> {{ $user->role }}</div>
                </div>
                <div class="col-12">
                    <div class="small"><strong>Location:</strong> {{ $user->location ?? 'Not specified' }}</div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        @if($user->description)
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-3" style="color: #213448;">About</h5>
            <p class="small mb-0 text-muted">{{ $user->description }}</p>
        </div>
        @endif

        <!-- Actions Section -->
        @if(auth()->check() && auth()->id() === $user->id)
        <div class="pt-3 border-top">
            <h5 class="mb-3" style="color: #213448;">Actions</h5>
            <div class="d-flex gap-2 flex-wrap">
                <a class="button" href="{{ route('conversations.index') }}">View Chats</a>
                <a class="button" href="{{ route('profile.edit') }}">Edit Profile</a>
                <a class="button" href="{{ route('jobpost.create') }}">Create New JobPost</a>

                <form action="{{ route('profile.destroy') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="button" type="submit" onclick="return confirm('Are you sure you want to delete your account? This action is irreversible.')">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
    @if(auth()->check() && auth()->id() === $user->id)
    <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">

        <div class="mb-3">
            <h4>Expired Job Posts</h4>
        </div>

        @if($expiredjobPosts->isNotEmpty())
        <div class="row g-3">
            @foreach($expiredjobPosts as $expiredjobPost)
            <div class="col-12 col-md-6">
                @include('partials.jobpost', ['jobPost' => $expiredjobPost])
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">You have no expired job posts.</p>
        @endif
    </div>
    @endif

</div>