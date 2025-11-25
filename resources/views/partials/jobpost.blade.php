<article class="jobpost" data-id="{{ $jobPost->id }}">
    <header>
        <h2><a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}">{{$jobPost->title }}</a></h2>
        <h4><a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}"> Employer: {{ $jobPost->employer->name }}</a></h4>
    </header>

    <div class="meta">
        <span class="salary">Salary:{{ $jobPost->salary }}€</span>
        <br>
        <span class="work_model">Work Model: {{ $jobPost->work_model }}</span>
        <br>
        <span class="category">Category ID: {{ $jobPost->category_id }}</span>
    </div>
    <br>
</article>