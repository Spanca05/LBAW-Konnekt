@php
$variant=$variant ?? 'list' ;
$isDetail=$variant==='detail' ;
$hasApplied=$hasApplied ?? false;
$application=$application ?? null;
@endphp

<article class="card shadow-sm {{ $isDetail ? 'jobpost-card-detail' : 'h-100 jobpost-card' }}" data-id="{{ $jobPost->id }}">
    <div class="card-body {{ $isDetail ? 'p-4 p-md-5' : 'p-3' }} d-flex flex-column">

        <div class="d-flex justify-content-between align-items-start gap-2">
            <div>
                @if($isDetail)
                <h3 class="card-title mb-1 fs-2">{{ $jobPost->title }}</h3>
                @else
                <h5 class="card-title mb-1 fs-2">
                    <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}" class="text-decoration-none jobpost-title">
                        {{ $jobPost->title }}
                    </a>
                </h5>
                @endif
                <div class="text-muted fs-5">
                    <a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}" class="text-decoration-none text-muted">
                        {{ $jobPost->employer->name ?? '' }}
                    </a>
                </div>
            </div>

            <span class="badge jobpost-badge fs-5">
                {{ $jobPost->work_model }}
            </span>
        </div>

        <div class="mt-3 d-flex flex-wrap gap-2">
            <span class="badge jobpost-badge-soft fs-5">
                {{ $jobPost->jobCategory->name }}
            </span>
            <span class="badge jobpost-badge-soft fs-5">
                {{ $jobPost->location ?? 'Not specified' }}
            </span>
            <span class="badge jobpost-badge-soft fs-5">
                {{ $jobPost->salary }}€
            </span>
        </div>

        <div class="mt-3 d-flex flex-wrap gap-2">
            <span class="badge jobpost-badge-soft">
                {{ $jobPost->jobCategory->name }}
            </span>
            <span class="badge jobpost-badge-soft">
                {{ $jobPost->location ?? 'Not specified' }}
            </span>
            <span class="badge jobpost-badge-soft">
                {{ $jobPost->salary }}€
            </span>
        </div>

        @if($isDetail)
        <div class="mt-3 border-top pt-3">
            <h6 class="mb-3 fs-4">Contract Type</h6>
            <p class="small mb-0 fs-5">{{ $jobPost->contract_type }}</p>
        </div>

        <div class="mt-3 border-top pt-3">
            <h6 class="mb-3 fs-4">Description</h6>
            <p class="mb-0 fs5">{{ $description ?? $jobPost->description }}</p>
        </div>

        <div class="mt-3 border-top pt-3">
            <h6 class="mb-2">Deadline</h6>
            <p class="small mb-0">
                @if($jobPost->deadline)
                {{ $jobPost->deadline->format('d M Y, H:i') }}
                @else
                None
                @endif
            </p>
        </div>


        @if($jobPost->jobCategory && $jobPost->jobCategory->skills->isNotEmpty())
        <div class="mt-3 border-top pt-3">
            <h6 class="mb-2">Skills required</h6>
            @foreach($jobPost->jobCategory->skills as $skill)
            <span class="badge jobpost-badge-soft">
                {{ $skill->name }}
            </span>
            @endforeach
        </div>
        @endif

        <div class="mt-3 border-top pt-3 d-flex gap-3 flex-wrap">
            @auth
            @if(Auth::user()->role === 'JobSeeker')
            @if(!$hasApplied)
            <a class="button" href="{{ route('jobpost.apply.form', ['jobpost' => $jobPost->id]) }}">Apply Now</a>
            @else
            <button class="button" disabled>Already applied</button>
            @if($application)
            <a class="button" href="{{ route('applications.edit', ['application' => $application->id]) }}">Edit application</a>
            @endif
            @endif
            @elseif(Auth::id() === $jobPost->employer_id)
            <a class="button" href="{{ route('jobpost.edit', ['jobpost' => $jobPost->id]) }}">Edit</a>
            <a class="button" href="{{ route('jobpost.applications', $jobPost) }}">View Applications</a>
            <form method="POST" action="{{ route('jobpost.delete', ['jobpost' => $jobPost->id]) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="button" onclick="return confirm('Do you want to delete this job post?');">Delete</button>
            </form>
            @endif
            @else
            <a class="button" href="{{ route('login') }}">Login to apply</a>
            @endauth

            @if(auth()->check() && auth()->user()->role === 'JobSeeker')
            <form action="{{ route('jobpost.favourite', $jobPost->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="button">
                    @if(auth()->user()->favouriteJobs->contains($jobPost->id))
                    Remove Favourite
                    @else
                    Add to Favourite
                    @endif
                </button>
            </form>
            @endif
            <a class="button" href="{{ url()->previous() }}">Return</a>
        </div>
        @endif

        <div class="mt-auto pt-3">
            @if(!$isDetail)
            <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}" class="button w-100">
                View details
            </a>
            @endif
        </div>

    </div>

</article>