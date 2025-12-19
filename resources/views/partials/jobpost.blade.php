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
                    <h3 class="card-title mb-1">{{ $jobPost->title }}</h3>
                    @else
                    <h5 class="card-title mb-1">
                        <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}" class="text-decoration-none jobpost-title">
                            {{ $jobPost->title }}
                        </a>
                    </h5>
                    @endif
                    <div class="small text-muted">
                        <a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}" class="text-decoration-none text-muted">
                            {{ $jobPost->employer->name ?? '' }}
                        </a>
                    </div>
                </div>

                <span class="badge jobpost-badge">
                    {{ $jobPost->work_model }}
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
                <h6 class="mb-2">Contract Type</h6>
                <p class="small mb-0">{{ $jobPost->contract_type }}</p>
            </div>

            <div class="mt-3 border-top pt-3">
                <h6 class="mb-2">Description</h6>
                <p class="small mb-0">{{ $description ?? $jobPost->description }}</p>
            </div>

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
                @endif
                @else
                <a class="button" href="{{ route('login') }}">Login to apply</a>
                @endauth

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