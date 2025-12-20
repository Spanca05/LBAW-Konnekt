@extends('layouts.app')

@section('title', 'Apply to Job')

@section('content')
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <article class="card shadow-sm jobpost-card-detail">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <h3 class="card-title mb-1">Apply to: {{ $jobPost->title }}</h3>
                            <div class="small text-muted">
                                <a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}" class="text-decoration-none text-muted">
                                    {{ $jobPost->employer->name ?? 'Employer' }}
                                </a>
                            </div>
                        </div>
                        <span class="badge jobpost-badge">{{ $jobPost->work_model }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge jobpost-badge-soft">{{ $jobPost->jobCategory->name ?? 'Category' }}</span>
                        @if(!empty($jobPost->location))
                        <span class="badge jobpost-badge-soft">{{ $jobPost->location }}</span>
                        @endif
                        <span class="badge jobpost-badge-soft">{{ $jobPost->salary }}€</span>
                    </div>

                    <div class="mt-3 border-top pt-3">
                        <h6 class="mb-2">Description</h6>
                        <p class="small mb-0">{{ $jobPost->description }}</p>
                    </div>

                    @if($errors->any())
                    <div class="message error mt-3">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mt-4 border-top pt-3">
                        <form method="POST" action="{{ route('jobpost.apply', ['jobpost' => $jobPost->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="motivation" class="form-label">Cover Letter (optional)</label>
                                <textarea class="form-control" id="motivation" name="motivation" rows="6" placeholder="Write here your Cover Letter">{{ old('motivation') }}</textarea>
                            </div>

                            <div class="d-flex gap-3 flex-wrap">
                                <button type="submit" class="button">Submit Application</button>
                                <a class="button button-outline" href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
