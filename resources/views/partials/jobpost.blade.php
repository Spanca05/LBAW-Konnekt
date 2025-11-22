<article class="jobpost" data-id="{{ $jobPost->id }}">
    <header>
        <h2>
            {{-- vai para pagina especifica de cada jobpost --}}
            <a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}">
                {{$jobPost->title }}
            </a>
        </h2>
        {{-- Delete button (JS handles behavior) --}}
        {{-- <a href="#" class="delete">&#10761;</a> --}}
    </header>

    <div class="meta">
        <span class="salary">€{{ $jobPost->salary }}</span>
        <span class="employer">Employer ID: {{ $jobPost->employer_id }}</span>
        <br>
        <span class="work_model">Work Model: {{ $jobPost->work_model }}</span>
    </div>

    <p class="description">Description {{ $jobPost->description }} </p>


</article>