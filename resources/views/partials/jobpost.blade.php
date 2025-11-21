<article class="jobpost" data-id="{{ $jobpost->id }}">
    <header>
        <h2>
            {{-- Link to the card detail page --}}
            <a href="{{ route('jobpost.show', $jobPost) }}">
                {{$jobPost->title }}
            </a>
        </h2>
        {{-- Delete button (JS handles behavior) --}}
        <a href="#" class="delete">&#10761;</a>
    </header>

    <div class="meta">
        <span class="salary">€{{ $jobPost->salary }}</span>
        <span class="employer">Employer ID: {{ $jobPost->employer_id }}</span>
    </div>

    <p class="description">{{ $jobPost->description }} </p>
</article>