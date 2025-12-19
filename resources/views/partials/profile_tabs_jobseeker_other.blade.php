<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-0" id="profileTabs" role="tablist">
    <li class="nav-item m-0" role="presentation">
        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
            Profile Information
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content border border-top-0 rounded-0 rounded-bottom p-4 bg-white" id="profileTabsContent">

    <!-- Profile Information Tab -->
    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">

        <div class="mb-4">
            <h5 class="mb-3" style="color: #213448;">Account Information</h5>
            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Name:</strong> {{ $user->name }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Email:</strong> {{ $user->email }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Phone:</strong> {{ $user->phone_number ?? 'Not specified' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small"><strong>Location:</strong> {{ $user->location ?? 'Not specified' }}</div>
                </div>
            </div>
        </div>

        @if($user->skills && count($user->skills))
        <div class="mb-4">
            <h5 class="mb-3" style="color: #213448;">Skills</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($user->skills as $skill)
                <span class="badge jobpost-badge-soft">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-4">
            <p class="text-muted mb-0">{{ $user->name }} has no skills listed.</p>
        </div>
        @endif

        @if(optional($user->cv)->file_path)
        <div class="mb-4 pt-3 border-top">
            <h5 class="mb-3" style="color: #213448;">Curriculum Vitae</h5>
            <a class="button" href="{{ route('profile.cv.download_other', ['user' => $user->id]) }}">Download CV</a>
        </div>
        @endif

    </div>

</div>