<article class="jobpost" data-id="{{ $jobPost->id }}">
    <header>
        <h3><a href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}">{{$jobPost->title }}</a></h3>
        <h4><a href="{{ route('profile.other', ['id' => $jobPost->employer_id]) }}"> Employer: {{ $jobPost->employer->name }}</a></h4>
    </header>

    <div class="meta">
        <span class="salary"><b>Salary:</b>{{ $jobPost->salary }}€</span>
        <br>
        <span class="employer"><b>Employer Name:</b> {{ $jobPost->jobUser->name }}</span>
        <br>
        <span class="work_model"><b>Work Model:</b> {{ $jobPost->work_model }}</span>
        <br>
        <span class="contract_type"><b>Contract Type: </b>{{ $jobPost->contract_type }}</span>
        <br>
        <span class="location"><b>Location: </b>{{ $jobPost->location ?? 'Not specified' }}</span>
        <br>
        <span class="category"><b>Category: </b>{{ $jobPost->jobCategory->name }}</span>
    </div>
    <br>
</article>