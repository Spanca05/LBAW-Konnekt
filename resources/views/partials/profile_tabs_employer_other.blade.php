<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-0" id="profileTabs" role="tablist">
    <li class="nav-item m-0" role="presentation">
        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
            Profile Information
        </button>
    </li>
    <li class="nav-item m-0" role="presentation">
        <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab" aria-controls="jobs" aria-selected="false">
            Job Posts
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content border border-top-0 rounded-0 rounded-bottom p-4 bg-white" id="profileTabsContent">

    <!-- Profile Information Tab -->
    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">

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
                    <div class="small"><strong>Phone:</strong> {{ $user->phone_number ?? 'Not specified' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Location:</strong> {{ $user->location ?? 'Not specified' }}</div>
                </div>
                <div class="col-12">
                    <div class="small"><strong>Role:</strong> {{ $user->role }}</div>
                </div>
            </div>
        </div>

        @if(!empty($user->description))
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-2" style="color: #213448;">Description</h5>
            <p class="small mb-0">{{ $user->description }}</p>
        </div>
        @endif

    </div>

    <!-- Job Posts Tab -->
    <div class="tab-pane fade" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">

        @if(isset($jobPosts) && $jobPosts->isNotEmpty())
        <div class="d-flex flex-column gap-3">
            @foreach($jobPosts as $job)
            <a href="{{ route('jobpost.show', ['jobpost' => $job->id]) }}" class="text-decoration-none">
                @include('partials.jobpost', ['jobPost' => $job])
            </a>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">No job posts yet.</p>
        @endif

    </div>

</div>