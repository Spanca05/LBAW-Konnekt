@extends('layouts.app')

@section('title', 'Main Features')

@section('content')
<div class="container" >
    <h1>Why use Konnekt?</h1>
    <p class="lead">The bridge between talent and opportunity.</p>
    <div>
        <h3>Advanced Search Engine</h3>
        <p>
            Forget simple keyword matching. Our platform uses <strong>PostgreSQL Full Text Search</strong> 
            to rank results by relevance. Filter jobs by category, sort by date or alphabetical order, 
            and find exactly what you are looking for instantly via AJAX suggestions.
        </p>
    </div>
    <hr>
    <div>
        <div>
            <h3>For Employers</h3>
            <p>
                <strong>Post Jobs in seconds.</strong> Manage your recruitment process efficiently. 
                View applicant profiles, check their CVs, and track the status of your job openings 
                in a dedicated dashboard.
            </p>
        </div>
    </div>
    <hr>
    <div class="row" style="margin-bottom: 30px; align-items: center;">
        <div >
            <h3>For Job Seekers</h3>
            <p>
                Create your professional profile and upload your CV. Browse thousands of job offers 
                and apply with a single click. Keep track of your application history and land your dream job.
            </p>
        </div>
    </div>
</div>
@endsection
