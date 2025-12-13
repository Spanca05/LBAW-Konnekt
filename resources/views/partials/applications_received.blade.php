@auth
	@if(isset($jobPost) && Auth::id() === $jobPost->employer_id)
		@php
			$applications = $jobPost->applications()->with(['user', 'user.cv'])->orderByDesc('date')->get();
		@endphp

		<section class="applications-received">
			<h3>Applications Received ({{ $applications->count() }})</h3>

			@if($applications->isEmpty())
				<p>No applications yet for this job post.</p>
			@else
				<ol>
					@foreach($applications as $app)
						<li>
							<strong>
									<a href="{{ route('profile.other', ['id' => $app->user->id ?? $app->jobseeker_id]) }}">
											{{ $app->user->name }}
									</a>
							</strong>
                            <p>Submitted: {{ $app->date }}<br>
                            Status: {{ $app->status}} <br>
                            Motivation: {{ $app->motivation }} </p>
							@if($app->status === 'Pending')
							<div style="display:flex; gap:0.5rem;">
								<form method="POST" action="{{ route('applications.status.update', ['application' => $app->id]) }}">
										@csrf
										@method('PATCH')
										<input type="hidden" name="status" value="Accepted">
										<button type="submit" class="button" style="background:#2ecc71; color:#fff">Accept</button>
									</form>
									
									<form method="POST" action="{{ route('applications.status.update', ['application' => $app->id]) }}">
										@csrf
										@method('PATCH')
										<input type="hidden" name="status" value="Rejected">
										<button type="submit" class="button" style="background:#e74c3c; color:#fff">Reject</button>
									</form>
								</div>
							@endif
						</li>
					@endforeach
				</ol>
			@endif
		</section>
	@endif
@endauth

