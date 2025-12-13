<article class="card shadow-sm h-100 jobpost-card" data-id="{{ $jobPost->id }}">
    <div class="card-body d-flex flex-column">

        <div class="d-flex justify-content-between align-items-start gap-2">
            <div>
                <h5 class="card-title mb-1">
                    <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}" class="text-decoration-none jobpost-title">
                        {{ $jobPost->title }}
                    </a>
                </h5>

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

        <div class="mt-auto pt-3">
            <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}" class="button w-100">
                View details
            </a>
        </div>

    </div>
</article>