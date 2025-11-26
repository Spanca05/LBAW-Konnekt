@auth
	@if(isset($jobPost) && Auth::id() === $jobPost->employer_id)
		@php
			$applications = $jobPost->applications()->with(['user', 'user.cv'])->orderByDesc('date')->get();
		@endphp

		<section class="card applications-received">
			<h3>Applications Received ({{ $applications->count() }})</h3>

			@if($applications->isEmpty())
				<p>No applications yet for this job post.</p>
			@else
				<ol>
					@foreach($applications as $app)
						<li style="margin-bottom:1rem">
							<strong>
									<a href="{{ route('profile.other', ['id' => $app->user->id ?? $app->jobseeker_id]) }}">
											{{ $app->user->name }}
									</a>
							</strong>
                            <p>Submitted: {{ $app->date }}<br>
                            Status: {{ $app->status}} <br>
                            Motivation: {{ $app->motivation }} </p>
						</li>
					@endforeach
				</ol>
			@endif
		</section>
	@endif
@endauth

