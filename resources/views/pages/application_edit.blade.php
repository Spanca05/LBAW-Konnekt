@extends('layouts.app')

@section('title', 'Edit Application')

@section('content')
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <article class="card shadow-sm jobpost-card-detail">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <h3 class="card-title mb-1">Edit Application</h3>
                            <div class="small text-muted">
                                <a href="{{ route('jobpost.show', ['jobpost' => $application->jobpost_id]) }}" class="text-decoration-none text-muted">
                                    {{ $application->jobPost->title ?? ('Job #' . $application->jobpost_id) }}
                                </a>
                            </div>
                        </div>
                        <span class="badge jobpost-badge">{{ $application->jobPost->work_model }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge jobpost-badge-soft">{{ $application->jobPost->jobCategory->name ?? 'Category' }}</span>
                        @if(!empty($application->jobPost->location))
                        <span class="badge jobpost-badge-soft">{{ $application->jobPost->location }}</span>
                        @endif
                        <span class="badge jobpost-badge-soft">{{ $application->jobPost->salary }}€</span>
                    </div>

                    <div class="mt-3 border-top pt-3">
                        <h6 class="mb-2">Description</h6>
                        <p class="small mb-0">{{ $application->jobPost->description }}</p>
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
                        <form method="POST" action="{{ route('applications.update', ['application' => $application->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="motivation" class="form-label">Cover Letter / Motivation</label>
                                <textarea class="form-control" id="motivation" name="motivation" rows="8">{{ old('motivation', $application->motivation) }}</textarea>
                            </div>

                            <div class="d-flex gap-3 flex-wrap">
                                <button type="submit" class="button">Save</button>
                                <a class="button button-outline" href="{{ url()->previous() }}">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <form method="POST" action="{{ route('applications.destroy', ['application' => $application->id]) }}" onsubmit="return confirm('Withdraw this application?');">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="redirect_to" value="{{ route('jobpost.show', $application->jobpost_id) }}">

                            <button class="button" type="submit">Withdraw Application</button>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection