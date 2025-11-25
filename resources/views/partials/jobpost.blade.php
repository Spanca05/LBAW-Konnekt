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
        @if (auth()->id() != $jobPost->employer_id)
            <a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}">
                <button class="view_profile">{{ $jobPost->employer->name }}</button>
            </a>
        @endif      
        <br>
        <span class="salary">Salary:{{ $jobPost->salary }}€</span>
        <br>
        <span class="work_model">Work Model: {{ $jobPost->work_model }}</span>
        <br>
        <span class="category">Category ID: {{ $jobPost->category_id }}</span>
    </div>


</article>