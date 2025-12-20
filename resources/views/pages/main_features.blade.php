@extends('layouts.app')

@section('title', 'Main Features')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mb-5 shadow">
                <div class="card-body text-center">
                    <h1 class="card-title display-4 fw-bold mb-3">Why use Konnekt?</h1>
                    <p class="fs-4">
                        The bridge between talent and opportunity.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h3 class="card-title mb-3">Advanced Search Engine</h3>
                    <p class="fs-5">
                        Forget simple keyword matching. Our platform uses 
                        <strong>PostgreSQL Full Text Search</strong> to rank results by relevance.
                        Filter jobs by category, sort by date or alphabetical order, 
                        and find exactly what you are looking for instantly via AJAX suggestions.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">    
        <div class="col-md-8 col-lg-6">
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h3 class="card-title mb-3">For Employers</h3>
                    <p class="fs-5">
                        <strong>Post jobs in seconds.</strong> Manage your recruitment process efficiently.
                        View applicant profiles, check their CVs, and track the status of your job openings
                        in a dedicated dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title mb-3">For Job Seekers</h3>
                    <p class="fs-5">
                        Create your professional profile and upload your CV. Browse thousands of job offers
                        and apply with a single click. Keep track of your application history and land your dream job.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
