@extends('layouts.app')

@section('title', 'Job Post | ' . config('app.name'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">


            @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
            @endif



            @php
            $myApplication = null;
            if (Auth::check()) {
            $myApplication = \App\Models\Application::where('jobpost_id', $jobPost->id)
            ->where('jobseeker_id', Auth::id())
            ->first();
            }
            $hasApplied = (bool) $myApplication;
            @endphp

            @include('partials.jobpost', [
            'jobPost' => $jobPost,
            'variant' => 'detail',
            'description' => $jobPost->description,
            'hasApplied' => $hasApplied,
            'application' => $myApplication,
            ])


        </div>
    </div>
</div>

@endsection